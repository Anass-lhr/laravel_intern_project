<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleCommentReply;
use App\Models\ArticleCommentReport; 
use App\Models\ArticleReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Article::query();
        
        // Récupérer et valider le paramètre 'show'
        $showFilter = $request->get('show');
        
        // Si l'utilisateur a les permissions d'administration des articles
        if (auth()->check() && $this->userHasArticleModule()) {
            if ($showFilter === 'deleted') {
                $query->where('is_deleted', true);
            } elseif ($showFilter === 'all') {
                // Ne pas filtrer, montrer tous les articles
            } else {
                // Par défaut ou explicitement 'active': ne montrer que les articles actifs
                $query->where('is_deleted', false);
            }
        } else {
            // Les utilisateurs sans permissions ne voient que les articles actifs
            $query->where('is_deleted', false);
        }
        
        // Ne montrer que les articles publiés dans l'index (pas les brouillons)
        $query->where(function($q) {
            $q->where('status', 'published')
              ->orWhereNull('status');
        });
        
        // Chargement anticipé des relations pour optimiser les performances
        $query->with(['creator', 'deleter']);
        
        $articles = $query->orderBy('created_at', 'desc')->get();
        
        // Calculer si l'utilisateur a le module d'articles pour la vue
        $userHasArticleModule = $this->userHasArticleModule();
        
        return view('articles.index', [
            'articles' => $articles,
            'currentFilter' => $showFilter ?: 'active',
            'userHasArticleModule' => $userHasArticleModule
        ]);
    }

    /**
     * Affiche la liste des brouillons d'articles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
 * Affiche la liste des brouillons d'articles.
 */
public function drafts(Request $request) 
{
    // Vérifier que l'utilisateur a le module article affecté
    if (!$this->userHasArticleModule()) {
        return redirect()->route('articles.index')
            ->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder aux brouillons.');
    }

    // Ajouter des logs pour débugger
    Log::info('Drafts method called by user: ' . Auth::id());
    
    // Construire la requête pour les brouillons
    $query = Article::query()->where('status', 'draft');
    
    // Si l'utilisateur est un admin (non superadmin), ne montrer que ses propres brouillons
    if (Auth::user()->role === 'admin' && Auth::user()->role !== 'superadmin') {
        $query->where('created_by', Auth::id());
    }
    
    // Récupérer le paramètre 'show' pour le filtrage
    $showFilter = $request->get('show');
    
    // Filtre pour les brouillons supprimés ou actifs
    if ($showFilter === 'deleted') {
        $query->where('is_deleted', true);
    } elseif ($showFilter === 'all') {
        // Ne pas filtrer par suppression
    } else {
        // Par défaut: ne montrer que les brouillons actifs
        $query->where('is_deleted', false);
        $showFilter = 'active';
    }
    
    // Chargement anticipé des relations
    $query->with(['creator', 'deleter']);
    
    $drafts = $query->latest()->get();
    
    return view('articles.drafts', [
        'drafts' => $drafts,
        'currentFilter' => $showFilter,
        'userHasArticleModule' => true
    ]);
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Vérifier que l'utilisateur a le module article affecté
        if (!$this->userHasArticleModule()) {
            return redirect()->route('articles.index')
                ->with('error', 'Vous n\'avez pas les permissions nécessaires pour créer un article.');
        }
        
        return view('articles.create', [
            'userHasArticleModule' => true
        ]);
    }

    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    // Vérifier que l'utilisateur a le module article affecté
    if (!$this->userHasArticleModule()) {
        return redirect()->route('articles.index')
            ->with('error', 'Vous n\'avez pas les permissions nécessaires pour créer un article.');
    }

    // Validation des champs obligatoires
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'auteur' => 'required|string|max:255',
        'description' => 'required|string',
        'corps' => 'required|string',
        'categories-json' => 'required|string',
        'image' => 'required|file|mimes:jpeg,png,jpg,mp3,wav,ogg|max:20480',
        'status' => 'required|string|in:published,draft',
    ]);

    $article = new Article();
    $article->titre = $validated['titre'];
    $article->auteur = $validated['auteur'];
    $article->description = $validated['description'];
    $article->corps = $validated['corps'];
    $article->status = $validated['status'];
    $article->created_by = Auth::id();
    
    // Traitement des catégories - Fix JSON handling
    $categories = json_decode($validated['categories-json'], true);
    if (is_array($categories) && !empty($categories)) {
        $article->categorie = json_encode($categories);
    } else {
        return back()->withErrors(['categories-json' => 'Au moins une catégorie est requise.']);
    }

    // Traiter l'upload de fichier
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');
        $article->image = '/storage/' . $path;
    }

    $article->save();

    // Redirection en fonction du statut
    if ($article->status === 'draft') {
        return redirect()->route('articles.drafts')
            ->with('success', 'Brouillon enregistré avec succès.');
    } else {
        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès.');
    }
}

    /**
 * Sauvegarde automatique d'un article comme brouillon.
 */
public function autosave(Request $request)
{
    // Vérifier les permissions
    if (!$this->userHasArticleModule()) {
        return response()->json(['success' => false, 'message' => 'Permissions insuffisantes'], 403);
    }

    // Si un ID d'article est fourni, c'est une mise à jour
    if ($request->filled('article_id')) {
        $article = Article::findOrFail($request->article_id);
        
        // Vérifier que l'utilisateur peut modifier cet article
        if (!$this->canEditArticle($article)) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }
    } else {
        // Sinon, c'est un nouvel article
        $article = new Article();
        $article->created_by = Auth::id();
    }
    
    // Mettre à jour les attributs
    $article->titre = $request->filled('titre') ? $request->input('titre') : 'Brouillon sans titre';
    $article->description = $request->input('description');
    $article->corps = $request->input('corps');
    $article->auteur = $request->input('auteur');
    $article->status = 'draft';
    
    // Traitement des catégories - Fix the JSON encoding issue
    if ($request->has('categorie')) {
        $categories = $request->input('categorie');
        if (is_array($categories)) {
            $article->categorie = json_encode($categories);
        } else {
            $article->categorie = $categories;
        }
    } elseif ($request->has('categories-json')) {
        $categories = json_decode($request->input('categories-json'), true);
        if (is_array($categories)) {
            $article->categorie = json_encode($categories);
        }
    }
    
    // Traiter l'upload de fichier
    if ($request->hasFile('image')) {
        if ($article->image && Storage::disk('public')->exists(str_replace('/storage/', '', $article->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->image));
        }
        
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');
        $article->image = '/storage/' . $path;
    }
    
    $article->save();
    
    return response()->json([
        'success' => true,
        'message' => 'Brouillon sauvegardé automatiquement',
        'article_id' => $article->id
    ]);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        
        // Ne pas montrer les articles supprimés aux utilisateurs sans permissions
        if ($article->is_deleted && !$this->userHasArticleModule()) {
            abort(404);
        }
        
        // Ne pas montrer les brouillons sauf à leur auteur ou utilisateurs avec permissions
        if ($article->status === 'draft' && !$this->canViewDraft($article)) {
            abort(404);
        }
        
        // Calculer les permissions pour la vue
        $userHasArticleModule = $this->userHasArticleModule();
        $canEdit = $this->canEditArticle($article);
        $canDelete = $this->canDeleteArticle($article);
        
        return view('articles.show', compact('article', 'userHasArticleModule', 'canEdit', 'canDelete'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour modifier un article.');
        }
        
        $article = Article::findOrFail($id);
        
        // Vérifier les permissions d'édition
        if (!$this->canEditArticle($article)) {
            return redirect()->route('articles.index')
                ->with('error', 'Vous n\'avez pas les permissions nécessaires pour modifier cet article.');
        }
        
        return view('articles.edit', [
            'article' => $article,
            'userHasArticleModule' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);
    
    // Vérifier les permissions d'édition
    if (!$this->canEditArticle($article)) {
        return redirect()->route('articles.index')
            ->with('error', 'Vous n\'avez pas les permissions nécessaires pour modifier cet article.');
    }
    
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'corps' => 'nullable|string',
        'auteur' => 'nullable|string|max:255',
        'categorie' => 'nullable|array',
        'categories_json' => 'nullable|string',
        'categories-json' => 'nullable|string',
        'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp3,wav,ogg|max:20480',
        'supprimer_image' => 'nullable|boolean',
        'status' => 'nullable|string|in:published,draft',
    ]);

    $article->titre = $validated['titre'];
    $article->description = $validated['description'] ?? $article->description;
    $article->corps = $validated['corps'] ?? $article->corps;
    $article->auteur = $validated['auteur'] ?? $article->auteur;
    $article->status = $request->input('status', $article->status ?? 'published');
    
    // Traiter les catégories - Fix the JSON handling
    if (isset($validated['categories_json']) && !empty($validated['categories_json'])) {
        $categories = json_decode($validated['categories_json'], true);
        if (is_array($categories)) {
            $article->categorie = json_encode($categories);
        }
    } elseif (isset($validated['categories-json']) && !empty($validated['categories-json'])) {
        $categories = json_decode($validated['categories-json'], true);
        if (is_array($categories)) {
            $article->categorie = json_encode($categories);
        }
    } elseif (isset($validated['categorie']) && is_array($validated['categorie'])) {
        $article->categorie = json_encode($validated['categorie']);
    }
    
    // Gestion de l'image
    if ($request->has('supprimer_image') && $request->supprimer_image == 1) {
        if ($article->image && Storage::disk('public')->exists(str_replace('/storage/', '', $article->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->image));
        }
        $article->image = null;
    } elseif ($request->hasFile('image')) {
        if ($article->image && Storage::disk('public')->exists(str_replace('/storage/', '', $article->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->image));
        }
        
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');
        $article->image = '/storage/' . $path;
    }
    
    $article->save();

    // Redirection en fonction du statut
    if ($article->status === 'draft') {
        return redirect()->route('articles.drafts')
            ->with('success', 'Brouillon mis à jour avec succès.');
    } else {
        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Article mis à jour avec succès.');
    }
}

    /**
     * Publie un article en brouillon.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function publish(Article $article)
    {
        // Vérifier les permissions
        if (!$this->canEditArticle($article)) {
            return redirect()->route('articles.drafts')
                ->with('error', 'Vous n\'avez pas les permissions nécessaires pour publier cet article.');
        }

        // Vérifier si tous les champs obligatoires sont remplis
        $validator = Validator::make($article->toArray(), [
            'titre' => 'required',
            'auteur' => 'required',
            'description' => 'required',
            'corps' => 'required',
            'image' => 'required',
            'categorie' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('articles.edit', $article->id)
                ->with('error', 'Tous les champs obligatoires doivent être remplis avant de publier l\'article.')
                ->withErrors($validator);
        }

        $article->status = 'published';
        $article->save();

        return redirect()->route('articles.index')
            ->with('success', 'L\'article a été publié avec succès.');
    }

    /**
     * Soft delete the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
        // Vérifier les permissions de suppression
        if (!$this->canDeleteArticle($article)) {
            abort(403, 'Vous n\'avez pas les permissions nécessaires pour supprimer cet article.');
        }
        
        $article->is_deleted = true;
        $article->deleted_by = Auth::id();
        $article->deleted_at = now();
        $article->save();

        // Redirection selon le statut
        if ($article->status === 'draft') {
            return redirect()->route('articles.drafts')
                ->with('success', 'Brouillon supprimé avec succès.');
        } else {
            return redirect()->route('articles.index')
                ->with('success', 'Article supprimé avec succès.');
        }
    }
    
    /**
     * Restore a deleted article.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        // Seuls les superadmins peuvent restaurer
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Seuls les superadmins peuvent restaurer des articles supprimés.');
        }
        
        $article = Article::findOrFail($id);
        
        $article->is_deleted = false;
        $article->deleted_by = null;
        $article->deleted_at = null;
        
        // Gérer le paramètre de publication
        if ($request->has('publish')) {
            $article->status = $request->input('publish') == '1' ? 'published' : 'draft';
        }
        
        $article->save();
        
        // Redirection selon le statut final
        if ($article->status === 'draft') {
            return redirect()->route('articles.drafts')
                ->with('success', 'Article restauré comme brouillon avec succès.');
        } else {
            return redirect()->route('articles.index')
                ->with('success', 'Article restauré et publié avec succès.');
        }
    }

    /**
 * Met un article publié en brouillon
 */
public function toDraft(Article $article, Request $request)
{
    // Vérifier les permissions
    if (!$this->canEditArticle($article)) {
        abort(403, 'Vous n\'avez pas les permissions nécessaires pour modifier cet article.');
    }
    
    // Sauvegarder les modifications si demandé
    if ($request->input('save_changes') == '1') {
        $article->titre = $request->input('draft_titre');
        $article->auteur = $request->input('draft_auteur');
        $article->description = $request->input('draft_description');
        $article->corps = $request->input('draft_corps');
        
        if ($request->has('draft_categories')) {
            try {
                $categories = json_decode($request->input('draft_categories'), true);
                if (is_array($categories)) {
                    $article->categorie = json_encode($categories);
                }
            } catch (\Exception $e) {
                // Garder les catégories existantes en cas d'erreur
                Log::error('Error processing categories in toDraft: ' . $e->getMessage());
            }
        }
    }
    
    $article->status = 'draft';
    $article->save();
    
    return redirect()->route('articles.drafts')
        ->with('success', 'L\'article a été déplacé vers les brouillons.');
}

// Add these missing helper methods that are referenced in the controller

/**
 * Vérifie si l'utilisateur a le module article
 */
private function userHasArticleModule()
{
    if (!Auth::check()) {
        return false;
    }
    
    $user = Auth::user();
    
    // Superadmin a toujours accès
    if ($user->role === 'superadmin') {
        return true;
    }
    
    // Admin avec module article
    if ($user->role === 'admin' && $user->is_active) {
        return $user->affectation && 
               isset($user->affectation->modules) && 
               in_array('article', $user->affectation->modules);
    }
    
    return false;
}

/**
 * Vérifie si l'utilisateur peut modifier un article
 */
private function canEditArticle($article)
{
    if (!Auth::check()) {
        return false;
    }
    
    $user = Auth::user();
    
    // Superadmin peut tout modifier
    if ($user->role === 'superadmin') {
        return true;
    }
    
    // Admin avec module article peut modifier ses propres articles
    if ($user->role === 'admin' && $this->userHasArticleModule()) {
        return $article->created_by === $user->id;
    }
    
    return false;
}

/**
 * Vérifie si l'utilisateur peut supprimer un article
 */
private function canDeleteArticle($article)
{
    if (!Auth::check()) {
        return false;
    }
    
    $user = Auth::user();
    
    // Superadmin peut tout supprimer
    if ($user->role === 'superadmin') {
        return true;
    }
    
    // Admin avec module article peut supprimer ses propres articles
    if ($user->role === 'admin' && $this->userHasArticleModule()) {
        return $article->created_by === $user->id;
    }
    
    return false;
}

/**
 * Vérifie si l'utilisateur peut voir un brouillon
 */
private function canViewDraft($article)
{
    if (!Auth::check()) {
        return false;
    }
    
    $user = Auth::user();
    
    // Superadmin peut voir tous les brouillons
    if ($user->role === 'superadmin') {
        return true;
    }
    
    // Auteur peut voir ses propres brouillons
    if ($article->created_by === $user->id) {
        return true;
    }
    
    // Admin avec module article peut voir ses propres brouillons
    if ($user->role === 'admin' && $this->userHasArticleModule()) {
        return $article->created_by === $user->id;
    }
    
    return false;
}

/**
 * Vérifie si l'utilisateur peut commenter
 */
private function userCanComment()
{
    return Auth::check();
}

/**
 * Vérifie si l'utilisateur peut supprimer un commentaire
 */
private function canDeleteComment($comment)
{
    if (!Auth::check()) {
        return false;
    }
    
    $user = Auth::user();
    
    // Superadmin peut tout supprimer
    if ($user->role === 'superadmin') {
        return true;
    }
    
    // Admin avec module article peut supprimer les commentaires
    if ($user->role === 'admin' && $this->userHasArticleModule()) {
        return true;
    }
    
    // Utilisateur peut supprimer ses propres commentaires
    return $comment->user_id === $user->id;
}

/**
 * Vérifie si l'utilisateur peut supprimer une réponse
 */
private function canDeleteReply($reply)
{
    if (!Auth::check()) {
        return false;
    }
    
    $user = Auth::user();
    
    // Superadmin peut tout supprimer
    if ($user->role === 'superadmin') {
        return true;
    }
    
    // Admin avec module article peut supprimer les réponses
    if ($user->role === 'admin' && $this->userHasArticleModule()) {
        return true;
    }
    
    // Utilisateur peut supprimer ses propres réponses
    return $reply->user_id === $user->id;
}
    // ===== MÉTHODES POUR LES COMMENTAIRES =====

    public function getComments($articleId)
    {
        try {
            $comments = ArticleComment::where('article_id', $articleId)
                ->where('is_deleted', false)
                ->with([
                    'user',
                    'replies' => function ($query) {
                        $query->where('is_deleted', false);
                    },
                    'replies.user',
                    'replies.replies' => function ($query) {
                        $query->where('is_deleted', false);
                    },
                    'replies.replies.user'
                ])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($comment) {
                    $mapReplies = function ($replies) use (&$mapReplies) {
                        return $replies->map(function ($reply) use ($mapReplies) {
                            return [
                                'id' => $reply->id,
                                'author' => $reply->user->name,
                                'avatar' => $reply->user->avatar ?? 'https://via.placeholder.com/40',
                                'content' => $reply->content,
                                'timestamp' => $reply->created_at->toDateTimeString(),
                                'parentId' => $reply->comment_id,
                                'parentReplyId' => $reply->parent_reply_id,
                                'reported' => $reply->reported ?? false,
                                'replies' => $mapReplies($reply->replies),
                            ];
                        })->toArray();
                    };

                    return [
                        'id' => $comment->id,
                        'author' => $comment->user->name,
                        'avatar' => $comment->user->avatar ?? 'https://via.placeholder.com/40',
                        'content' => $comment->content,
                        'timestamp' => $comment->created_at->toDateTimeString(),
                        'reported' => $comment->reported ?? false,
                        'replies' => $mapReplies($comment->replies),
                    ];
                });

            return response()->json(['comments' => $comments->values()]);
        } catch (\Exception $e) {
            Log::error('Erreur dans getComments: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération des commentaires: ' . $e->getMessage()], 500);
        }
    }

    public function addComment(Request $request)
    {
        try {
            if (!$this->userCanComment()) {
                return response()->json(['error' => 'Vous devez être connecté pour commenter.'], 401);
            }

            $request->validate([
                'article_id' => 'required|exists:articles,id',
                'content' => 'required|string|max:1000',
            ]);

            $user = Auth::user();
            $comment = ArticleComment::create([
                'user_id' => $user->id,
                'article_id' => $request->article_id,
                'content' => $request->content,
            ]);

            return response()->json([
                'id' => $comment->id,
                'author' => $user->name,
                'avatar' => $user->avatar ?? 'https://via.placeholder.com/40',
                'content' => $comment->content,
                'timestamp' => $comment->created_at->toDateTimeString(),
                'replies' => [],
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans addComment: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'ajout du commentaire: ' . $e->getMessage()], 500);
        }
    }

    public function addReply(Request $request)
    {
        try {
            if (!$this->userCanComment()) {
                return response()->json(['error' => 'Vous devez être connecté pour commenter.'], 401);
            }

            $validated = $request->validate([
                'comment_id' => 'required|exists:article_comments,id',
                'parent_reply_id' => 'nullable|exists:article_comment_replies,id',
                'content' => 'required|string|max:1000',
            ]);

            $user = Auth::user();
            $reply = ArticleCommentReply::create([
                'user_id' => $user->id,
                'comment_id' => $validated['comment_id'],
                'parent_reply_id' => $validated['parent_reply_id'] ?? null,
                'content' => $validated['content'],
            ]);

            return response()->json([
                'id' => $reply->id,
                'author' => $user->name,
                'avatar' => $user->avatar ?? 'https://via.placeholder.com/40',
                'content' => $reply->content,
                'timestamp' => $reply->created_at->toDateTimeString(),
                'parentId' => $validated['comment_id'],
                'parentReplyId' => $validated['parent_reply_id'] ?? null,
                'replies' => [],
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans addReply: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'ajout de la réponse: ' . $e->getMessage()], 500);
        }
    }

    public function deleteComment($id)
    {
        try {
            $comment = ArticleComment::findOrFail($id);
            $user = Auth::user();

            // Vérifier les permissions
            if (!$this->canDeleteComment($comment)) {
                return response()->json(['error' => 'Vous ne pouvez supprimer que vos propres commentaires.'], 403);
            }

            $comment->is_deleted = true;
            $comment->deleted_by = $user->id;
            $comment->deleted_at = now();
            $comment->save();

            // Marquer les réponses comme supprimées
            ArticleCommentReply::where('comment_id', $comment->id)
                ->update([
                    'is_deleted' => true,
                    'deleted_by' => $user->id,
                    'deleted_at' => now()
                ]);

            return response()->json(['message' => 'Commentaire supprimé avec succès.']);
        } catch (\Exception $e) {
            Log::error('Erreur dans deleteComment: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression du commentaire: ' . $e->getMessage()], 500);
        }
    }

    public function deleteReply($id)
    {
        try {
            $reply = ArticleCommentReply::findOrFail($id);
            $user = Auth::user();

            // Vérifier les permissions
            if (!$this->canDeleteReply($reply)) {
                return response()->json(['error' => 'Vous ne pouvez supprimer que vos propres réponses.'], 403);
            }

            $reply->is_deleted = true;
            $reply->deleted_by = $user->id;
            $reply->deleted_at = now();
            $reply->save();

            return response()->json(['message' => 'Réponse supprimée avec succès.']);
        } catch (\Exception $e) {
            Log::error('Erreur dans deleteReply: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la suppression de la réponse: ' . $e->getMessage()], 500);
        }
    }



/**
 * Affiche la liste des signalements de commentaires d'articles
 * Uses the unified view: resources/views/dashboard/articles-signales.blade.php
 */
public function viewReports(Request $request)
{
    // Vérifier les permissions
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        abort(403, 'Accès non autorisé');
    }

    // Use ArticleCommentReport model for comment reports
    $query = \App\Models\ArticleCommentReport::with(['article', 'reporter', 'reviewer', 'resolver']);

    // Filtres
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    if ($request->filled('reason_category')) {
        $query->where('reason_category', $request->reason_category);
    }

    if ($request->filled('comment_type')) {
        $query->where('comment_type', $request->comment_type);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('comment_content', 'LIKE', "%{$search}%")
              ->orWhere('comment_author', 'LIKE', "%{$search}%")
              ->orWhere('reason_details', 'LIKE', "%{$search}%")
              ->orWhereHas('article', function($articleQuery) use ($search) {
                  $articleQuery->where('titre', 'LIKE', "%{$search}%");
              });
        });
    }

    // Tri
    $sortField = 'created_at';
    $sortDirection = 'desc';
    
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'created_at_asc':
                $sortDirection = 'asc';
                break;
            case 'status_asc':
                $sortField = 'status';
                $sortDirection = 'asc';
                break;
            case 'status_desc':
                $sortField = 'status';
                $sortDirection = 'desc';
                break;
            case 'priority_asc':
                $sortField = 'priority';
                $sortDirection = 'asc';
                break;
            case 'priority_desc':
                $sortField = 'priority';
                $sortDirection = 'desc';
                break;
        }
    }

    $query->orderBy($sortField, $sortDirection);

    // Pagination
    $reports = $query->paginate(20);

    // Transform reports for view compatibility
    $reports->getCollection()->transform(function ($report) {
        $report->reason_category_label = $this->getReasonCategoryLabel($report->reason_category);
        return $report;
    });

    // Statistics for comment reports
    $stats = [
        'total' => \App\Models\ArticleCommentReport::count(),
        'pending' => \App\Models\ArticleCommentReport::where('status', 'pending')->count(),
        'resolved' => \App\Models\ArticleCommentReport::where('status', 'resolved')->count(),
        'dismissed' => \App\Models\ArticleCommentReport::where('status', 'dismissed')->count(),
    ];

    // Pass report type to view
    $reportType = 'comment';

    return view('dashboard.articles-signales', compact('reports', 'stats', 'reportType'));
}

/**
 * Traitement par lots des signalements de commentaires
 */
public function bulkProcessReports(Request $request)
{
    // Check permissions
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
    }
    
    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        return response()->json(['success' => false, 'message' => 'Accès non autorisé'], 403);
    }

    $request->validate([
        'report_ids' => 'required|array',
        'report_ids.*' => 'exists:article_comment_reports,id',
        'action' => 'required|in:dismiss,resolve,delete_comment,warn_user,block_user'
    ]);

    $processed = 0;
    $errors = [];

    foreach ($request->report_ids as $reportId) {
        try {
            $report = \App\Models\ArticleCommentReport::findOrFail($reportId);
            
            switch ($request->action) {
                case 'dismiss':
                    $report->update([
                        'status' => 'dismissed',
                        'resolved_by' => auth()->id(),
                        'resolved_at' => now(),
                        'action_taken' => 'dismissed',
                        'admin_notes' => 'Signalement rejeté - aucune action requise'
                    ]);
                    break;
                    
                case 'resolve':
                    $report->update([
                        'status' => 'resolved',
                        'resolved_by' => auth()->id(),
                        'resolved_at' => now(),
                        'action_taken' => 'manual_review',
                        'admin_notes' => 'Signalement résolu manuellement'
                    ]);
                    break;
                    
                case 'delete_comment':
                    $this->deleteReportedComment($report);
                    $report->update([
                        'status' => 'resolved',
                        'resolved_by' => auth()->id(),
                        'resolved_at' => now(),
                        'action_taken' => 'comment_deleted',
                        'admin_notes' => 'Commentaire supprimé'
                    ]);
                    break;
                    
                case 'warn_user':
                    $this->warnCommentAuthor($report);
                    $report->update([
                        'status' => 'resolved',
                        'resolved_by' => auth()->id(),
                        'resolved_at' => now(),
                        'action_taken' => 'user_warned',
                        'admin_notes' => 'Utilisateur averti'
                    ]);
                    break;
                    
                case 'block_user':
                    $this->blockCommentAuthor($report);
                    $report->update([
                        'status' => 'resolved',
                        'resolved_by' => auth()->id(),
                        'resolved_at' => now(),
                        'action_taken' => 'user_blocked',
                        'admin_notes' => 'Utilisateur bloqué'
                    ]);
                    break;
            }
            $processed++;
        } catch (\Exception $e) {
            $errors[] = "Erreur pour le signalement {$reportId}: " . $e->getMessage();
            \Log::error("Bulk process error for report {$reportId}: " . $e->getMessage());
        }
    }

    if ($processed > 0) {
        return response()->json([
            'success' => true,
            'message' => "{$processed} signalement(s) traité(s) avec succès" . 
                        (count($errors) > 0 ? " (" . count($errors) . " erreur(s))" : ""),
            'errors' => $errors
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Aucun signalement n\'a pu être traité',
        'errors' => $errors
    ], 500);
}

/**
 * Update comment report status
 */
public function updateReportStatus(Request $request, $id)
{
    // Check permissions
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
    }
    
    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        return response()->json(['success' => false, 'message' => 'Accès non autorisé'], 403);
    }

    $request->validate([
        'status' => 'required|in:pending,reviewing,resolved,dismissed',
        'action_taken' => 'nullable|string',
        'admin_notes' => 'nullable|string'
    ]);

    try {
        $report = \App\Models\ArticleCommentReport::findOrFail($id);
        
        $updateData = [
            'status' => $request->status,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now()
        ];
        
        if ($request->filled('admin_notes')) {
            $updateData['admin_notes'] = $request->admin_notes;
        }
        
        if ($request->filled('action_taken')) {
            $updateData['action_taken'] = $request->action_taken;
        }

        // If resolving or dismissing, set resolved fields
        if (in_array($request->status, ['resolved', 'dismissed'])) {
            $updateData['resolved_by'] = auth()->id();
            $updateData['resolved_at'] = now();
        }
        
        $report->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Statut du signalement mis à jour avec succès.'
        ]);
    } catch (\Exception $e) {
        \Log::error('Error updating comment report: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Update comment report (alternative method name for consistency)
 */
public function updateReport(Request $request, $id)
{
    return $this->updateReportStatus($request, $id);
}

/**
 * View article reports dashboard - uses the same view
 * Uses the unified view: resources/views/dashboard/articles-signales.blade.php
 */
public function viewArticleReports(Request $request)
{
    // Check permissions
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        abort(403, 'Accès non autorisé');
    }

    // Use ArticleReport model for article reports
    $query = \App\Models\ArticleReport::with(['article', 'reporter']);

    // Apply filters
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    if ($request->filled('reason_category')) {
        $query->where('reason_category', $request->reason_category);
    }

    if ($request->filled('priority')) {
        $query->where('priority', $request->priority);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('article', function($articleQuery) use ($search) {
                $articleQuery->where('titre', 'LIKE', "%{$search}%")
                           ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('reporter', function($reporterQuery) use ($search) {
                $reporterQuery->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhere('reason_details', 'LIKE', "%{$search}%");
        });
    }

    // Apply sorting
    $sortField = 'created_at';
    $sortDirection = 'desc';
    
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'created_at_asc':
                $sortDirection = 'asc';
                break;
            case 'status_asc':
                $sortField = 'status';
                $sortDirection = 'asc';
                break;
            case 'status_desc':
                $sortField = 'status';
                $sortDirection = 'desc';
                break;
            case 'priority_asc':
                $sortField = 'priority';
                $sortDirection = 'asc';
                break;
            case 'priority_desc':
                $sortField = 'priority';
                $sortDirection = 'desc';
                break;
        }
    }

    $reports = $query->orderBy($sortField, $sortDirection)->paginate(20);

    // Transform reports for view compatibility
    $reports->getCollection()->transform(function ($report) {
        $report->reason_category_label = $this->getReasonCategoryLabel($report->reason_category);
        return $report;
    });

    // Calculate statistics for article reports
    $stats = [
        'total' => \App\Models\ArticleReport::count(),
        'pending' => \App\Models\ArticleReport::where('status', 'pending')->count(),
        'resolved' => \App\Models\ArticleReport::where('status', 'resolved')->count(),
        'dismissed' => \App\Models\ArticleReport::where('status', 'dismissed')->count(),
    ];

    // Pass report type to view
    $reportType = 'article';

    return view('dashboard.articles-signales', compact('reports', 'stats', 'reportType'));
}

/**
 * Update article report status
 */
public function updateArticleReport(Request $request, $id)
{
    // Check permissions
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
    }
    
    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        return response()->json(['success' => false, 'message' => 'Accès non autorisé'], 403);
    }

    $request->validate([
        'status' => 'required|in:pending,resolved,dismissed',
        'priority' => 'sometimes|in:low,medium,high',
        'admin_notes' => 'nullable|string'
    ]);

    try {
        $report = \App\Models\ArticleReport::findOrFail($id);
        
        $updateData = [
            'status' => $request->status,
            'updated_at' => now()
        ];

        if ($request->filled('priority')) {
            $updateData['priority'] = $request->priority;
        }

        if ($request->filled('admin_notes')) {
            $updateData['admin_notes'] = $request->admin_notes;
        }
        
        $report->update($updateData);

        return response()->json([
            'success' => true, 
            'message' => 'Statut du signalement mis à jour avec succès.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Bulk process article reports
 */
public function bulkProcessArticleReports(Request $request)
{
    // Check permissions
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
    }
    
    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        return response()->json(['success' => false, 'message' => 'Accès non autorisé'], 403);
    }

    $request->validate([
        'report_ids' => 'required|array',
        'report_ids.*' => 'exists:article_reports,id',
        'action' => 'required|in:approve,reject,delete_article,block_user'
    ]);

    $processed = 0;
    $errors = [];

    foreach ($request->report_ids as $reportId) {
        try {
            $report = \App\Models\ArticleReport::findOrFail($reportId);
            
            switch ($request->action) {
                case 'approve':
                    $report->update(['status' => 'dismissed', 'updated_at' => now()]);
                    break;
                    
                case 'reject':
                    $report->update(['status' => 'resolved', 'updated_at' => now()]);
                    break;
                    
                case 'delete_article':
                    // Mark article as deleted
                    if ($report->article) {
                        $report->article->update([
                            'is_deleted' => true,
                            'deleted_by' => auth()->id(),
                            'deleted_at' => now()
                        ]);
                    }
                    $report->update(['status' => 'resolved', 'updated_at' => now()]);
                    break;
                    
                case 'block_user':
                    // Block the article author
                    if ($report->article && $report->article->user_id) {
                        \App\Models\User::where('id', $report->article->user_id)
                            ->update(['is_active' => false]);
                    }
                    $report->update(['status' => 'resolved', 'updated_at' => now()]);
                    break;
            }
            $processed++;
        } catch (\Exception $e) {
            $errors[] = "Erreur pour le signalement {$reportId}: " . $e->getMessage();
        }
    }

    if ($processed > 0) {
        return response()->json([
            'success' => true,
            'message' => "{$processed} signalement(s) traité(s) avec succès" . 
                        (count($errors) > 0 ? " (" . count($errors) . " erreur(s))" : "")
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Aucun signalement n\'a pu être traité'
    ], 500);
}

/**
 * Report an article
 */
public function reportArticle(Request $request)
{
    \Log::info('Report request received', [
        'method' => $request->method(),
        'data' => $request->all()
    ]);
    
    try {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour signaler un article.',
                'error' => 'unauthenticated'
            ], 401);
        }
        
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'reason_category' => 'required|string|in:spam,inappropriate,misinformation,hate_speech,violence,other',
            'reason_details' => 'nullable|string|max:500'
        ]);
        
        // Check if user already reported this article
        $existingReport = \App\Models\ArticleReport::where('article_id', $validated['article_id'])
            ->where('reporter_id', Auth::id())
            ->first();
            
        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà signalé cet article.',
                'error' => 'already_reported'
            ], 400);
        }
        
        $report = \App\Models\ArticleReport::create([
            'article_id' => $validated['article_id'],
            'reporter_id' => Auth::id(),
            'reason_category' => $validated['reason_category'],
            'reason_details' => $validated['reason_details'],
            'status' => 'pending',
            'priority' => $this->calculatePriority($validated['reason_category'])
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Article signalé avec succès'
        ], 200);
       
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Données invalides.',
            'error' => 'validation_failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Erreur lors du signalement d\'article: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors du signalement',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Report a comment
 */
public function reportComment(Request $request)
{
    \Log::info('Comment report request received', [
        'method' => $request->method(),
        'data' => $request->all()
    ]);
   
    try {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour signaler un commentaire.',
                'error' => 'unauthenticated'
            ], 401);
        }
       
        $validated = $request->validate([
            'comment_id' => 'required|integer',
            'article_id' => 'required|exists:articles,id',
            'comment_type' => 'required|string|in:comment,reply',
            'reason_category' => 'required|string|in:inappropriate,spam,harassment,hate_speech,violence,other',
            'reason_details' => 'nullable|string|max:500'
        ]);
       
        // Get the comment based on type
        $comment = null;
        if ($validated['comment_type'] === 'comment') {
            $comment = \App\Models\ArticleComment::find($validated['comment_id']);
        } else {
            $comment = \App\Models\ArticleCommentReply::find($validated['comment_id']);
        }
       
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Commentaire non trouvé.',
                'error' => 'comment_not_found'
            ], 404);
        }
       
        // Check if user already reported this comment
        $existingReport = \App\Models\ArticleCommentReport::where('comment_id', $validated['comment_id'])
            ->where('comment_type', $validated['comment_type'])
            ->where('reporter_id', Auth::id())
            ->first();
           
        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà signalé ce commentaire.',
                'error' => 'already_reported'
            ], 400);
        }
       
        $report = \App\Models\ArticleCommentReport::create([
            'comment_id' => $validated['comment_id'],
            'article_id' => $validated['article_id'],
            'comment_content' => $comment->content,
            'comment_author' => $comment->user->name ?? 'Utilisateur inconnu',
            'reported_by' => Auth::user()->name,
            'reporter_id' => Auth::id(),
            'comment_type' => $validated['comment_type'],
            'reason_category' => $validated['reason_category'],
            'reason_details' => $validated['reason_details'],
            'status' => 'pending'
        ]);
       
        return response()->json([
            'success' => true,
            'message' => 'Commentaire signalé avec succès'
        ], 200);
       
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Données invalides.',
            'error' => 'validation_failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Erreur lors du signalement de commentaire: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors du signalement',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Calculate priority based on reason category
 */
private function calculatePriority($category)
{
    $highPriorityReasons = ['hate_speech', 'violence'];
    $mediumPriorityReasons = ['inappropriate', 'misinformation'];
    
    if (in_array($category, $highPriorityReasons)) {
        return 'high';
    } elseif (in_array($category, $mediumPriorityReasons)) {
        return 'medium';
    }
    
    return 'low';
}

/**
 * Get reason category label
 */
private function getReasonCategoryLabel($category)
{
    $labels = [
        'spam' => 'Spam',
        'inappropriate' => 'Contenu inapproprié',
        'misinformation' => 'Désinformation',
        'hate_speech' => 'Discours de haine',
        'violence' => 'Violence',
        'harassment' => 'Harcèlement',
        'other' => 'Autre'
    ];

    return $labels[$category] ?? 'Non spécifié';
}

/**
 * Delete the reported comment or reply
 */
private function deleteReportedComment(\App\Models\ArticleCommentReport $report)
{
    try {
        if ($report->comment_type === 'comment') {
            $comment = \App\Models\ArticleComment::find($report->comment_id);
            if ($comment) {
                $comment->delete();
            }
        } else {
            $reply = \App\Models\ArticleCommentReply::find($report->comment_id);
            if ($reply) {
                $reply->delete();
            }
        }
    } catch (\Exception $e) {
        \Log::error('Erreur lors de la suppression du commentaire signalé: ' . $e->getMessage());
        throw $e;
    }
}

/**
 * Warn the comment author
 */
private function warnCommentAuthor(\App\Models\ArticleCommentReport $report)
{
    try {
        $comment = null;
        if ($report->comment_type === 'comment') {
            $comment = \App\Models\ArticleComment::find($report->comment_id);
        } else {
            $comment = \App\Models\ArticleCommentReply::find($report->comment_id);
        }
       
        if ($comment && $comment->user_id) {
            \Log::info("Utilisateur {$comment->user_id} averti pour le commentaire {$report->comment_id}");
            
            // Optional: Implement warning system
            // You can create a UserWarning model and table if needed
        }
    } catch (\Exception $e) {
        \Log::error('Erreur lors de l\'avertissement de l\'utilisateur: ' . $e->getMessage());
        throw $e;
    }
}

/**
 * Block the comment author
 */
private function blockCommentAuthor(\App\Models\ArticleCommentReport $report)
{
    try {
        $comment = null;
        if ($report->comment_type === 'comment') {
            $comment = \App\Models\ArticleComment::find($report->comment_id);
        } else {
            $comment = \App\Models\ArticleCommentReply::find($report->comment_id);
        }
       
        if ($comment && $comment->user_id) {
            \App\Models\User::where('id', $comment->user_id)
                ->update(['is_active' => false]);
           
            \Log::info("Utilisateur {$comment->user_id} bloqué pour le commentaire {$report->comment_id}");
        }
    } catch (\Exception $e) {
        \Log::error('Erreur lors du blocage de l\'utilisateur: ' . $e->getMessage());
        throw $e;
    }
}





public function viewAllReports(Request $request)
{
    // Get filters from request
    $status = $request->get('status', 'all');
    $type = $request->get('type', 'all');
    $search = $request->get('search');

    // Initialize queries
    $articleReportsQuery = ArticleReport::with(['article']);
    $commentReportsQuery = ArticleCommentReport::with(['article']);

    // Apply status filter
    if ($status !== 'all') {
        $articleReportsQuery->where('status', $status);
        $commentReportsQuery->where('status', $status);
    }

    // Apply search filter
    if ($search) {
        $articleReportsQuery->where(function($query) use ($search) {
            $query->where('reason_details', 'like', "%{$search}%")
                  ->orWhere('reported_by', 'like', "%{$search}%")
                  ->orWhereHas('article', function($q) use ($search) {
                      $q->where('titre', 'like', "%{$search}%");
                  });
        });

        $commentReportsQuery->where(function($query) use ($search) {
            $query->where('reason_details', 'like', "%{$search}%")
                  ->orWhere('reported_by', 'like', "%{$search}%")
                  ->orWhere('comment_content', 'like', "%{$search}%")
                  ->orWhere('comment_author', 'like', "%{$search}%")
                  ->orWhereHas('article', function($q) use ($search) {
                      $q->where('titre', 'like', "%{$search}%");
                  });
        });
    }

    // Get reports based on type filter
    $articleReports = null;
    $commentReports = null;

    if ($type === 'all' || $type === 'article') {
        $articleReports = $articleReportsQuery
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'article_page');
    }

    if ($type === 'all' || $type === 'comment') {
        $commentReports = $commentReportsQuery
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'comment_page');
    }

    // Calculate statistics
    $stats = [
        'pending' => 0,
        'resolved' => 0,
        'dismissed' => 0,
        'total' => 0
    ];

    // Article reports stats
    $articleStats = ArticleReport::selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

    // Comment reports stats  
    $commentStats = ArticleCommentReport::selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

    // Combine stats
    foreach (['pending', 'resolved', 'dismissed'] as $status) {
        $stats[$status] = ($articleStats[$status] ?? 0) + ($commentStats[$status] ?? 0);
        $stats['total'] += $stats[$status];
    }

    // Handle AJAX requests for statistics
    if ($request->ajax() && $request->get('ajax') === 'stats') {
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    return view('dashboard.articles-signales', compact(
        'articleReports',
        'commentReports',
        'stats'
    ));
}






}