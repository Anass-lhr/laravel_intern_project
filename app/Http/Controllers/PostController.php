<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\Comment;
use App\Models\PostVote;
use App\Models\CommentVote;
use App\Models\DeletedPost;
use App\Models\DeletedComment;
use App\Models\BlockedUser;
use App\Models\User;
use App\Models\Affectation;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private function canManageForum()
    {
        return Auth::check() && Auth::user()->canManageForum();
    }

    public function createForm(Request $request, $type = null)
    {
        \Log::info('Type reçu dans createForm:', ['type' => $type]);

        if (!$type) {
            return redirect()->route('post.createForm', ['type' => 'text']);
        }

        return view('forum.create', compact('type'));
    }

    public function create(Request $request)
    {
        \Log::info('Form Data:', $request->all());

        if (!Auth::user()->is_active) {
            return redirect()->back()->with('error', 'Vous êtes bloqué et ne pouvez pas poster.');
        }

        $rules = [
            'post_type' => 'required|in:text,image,link',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'poll_question' => 'nullable|string',
            'poll_options' => 'nullable|array',
            'poll_type' => 'nullable|in:single,multiple',
        ];

        if ($request->post_type === 'image') {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['media_url'] = 'nullable|url';
        } elseif ($request->post_type === 'link') {
            $rules['media_url'] = 'required|url';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['media_url'] = 'nullable|url';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules);

        $mediaType = null;
        $mediaUrl = null;

        if ($request->hasFile('image')) {
            $mediaType = 'image';
            $mediaUrl = $request->file('image')->store('public/images');
            $mediaUrl = Storage::url($mediaUrl);
        } elseif ($request->media_url) {
            $mediaType = $this->detectMediaType($request->media_url);
            $mediaUrl = $request->media_url;
        }

        $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content ?? $request->description,
            'media_type' => $mediaType,
            'media_url' => $mediaUrl,
        ]);

        if ($request->poll_question && !empty($request->poll_options)) {
            $poll = $post->poll()->create([
                'question' => $request->poll_question,
                'is_multiple_choice' => $request->poll_type === 'multiple',
            ]);

            foreach ($request->poll_options as $option) {
                if ($option) {
                    $poll->options()->create(['option_text' => $option]);
                }
            }
        }

        return redirect()->route('forum.index')->with('success', 'Post créé avec succès !');
    }

    public function show(Post $post)
    {
        $post->load([
            'user',
            'poll',
            'poll.options.votes',
            'poll.votes',
            'comments' => function ($query) {
                $query->whereNull('parent_id')->with('replies', 'votes');
            },
            'votes',
            'reports'
        ]);
        return view('forum.show', compact('post'));
    }

    public function report(Request $request, $reportableType, $reportableId)
    {
        $request->validate([
            'reason_category' => 'required|in:Contenu inapproprié,Spam,Harcèlement,Informations fausses ou trompeuses,Autre',
            'reason_details' => 'required|string|max:500',
        ]);

        $reportable = ($reportableType === 'post') ? Post::findOrFail($reportableId) : Comment::findOrFail($reportableId);

        $reportableClass = ($reportableType === 'post') ? Post::class : Comment::class;

        Report::create([
            'user_id' => Auth::id(),
            'reportable_type' => $reportableClass,
            'reportable_id' => $reportableId,
            'reason_category' => $request->reason_category,
            'reason_details' => $request->reason_details,
        ]);

        return redirect()->back()->with('success', 'Signalement envoyé avec succès !');
    }

    public function reports()
        {
            if (!$this->canManageForum()) {
                return redirect()->route('dashboard')->with('error', 'Vous n\'êtes pas autorisé à voir les signalements.');
            }

            // Charger uniquement les signalements non résolus (statut différent de "dismissed")
            $reports = Report::with(['user', 'reportable.user'])
                ->where('status', '!=', 'dismissed')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($reports as $report) {
                if (!$report->user) {
                    \Log::warning('Utilisateur manquant pour le signalement ID: ' . $report->id);
                }
                if (!$report->reportable || !$report->reportable->user) {
                    \Log::warning('Contenu ou auteur manquant pour le signalement ID: ' . $report->id);
                }
            }

            return view('dashboard.reports', compact('reports'));
        }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if (!Auth::user()->is_active) {
            return redirect()->back()->with('error', 'Vous êtes bloqué et ne pouvez pas commenter.');
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
    }

    public function deleteComment(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !$this->canManageForum()) {
            return response()->json(['success' => false, 'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.'], 403);
        }

        // Enregistrer le commentaire supprimé dans la table deleted_comments
        DeletedComment::create([
            'content' => $comment->content,
            'post_id' => $comment->post_id,
            'user_id' => $comment->user_id,
            'parent_id' => $comment->parent_id,
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);

        // Marquer tous les signalements associés comme "dismissed"
        Report::where('reportable_type', Comment::class)
            ->where('reportable_id', $comment->id)
            ->update(['status' => 'dismissed']);

        // Supprimer le commentaire
        $comment->delete();

        // Si la requête est AJAX, retourner une réponse JSON
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Commentaire supprimé avec succès !']);
        }

        // Sinon, redirection pour les requêtes non-AJAX
        return redirect()->back()->with('success', 'Commentaire supprimé avec succès !');
    }
    public function deletePost(Post $post)
    {
        if (Auth::id() !== $post->user_id && !$this->canManageForum()) {
            return response()->json(['success' => false, 'message' => 'Vous n\'êtes pas autorisé à supprimer ce post.'], 403);
        }

        // Charger les commentaires associés au post
        $post->load('comments');

        // Enregistrer le post supprimé dans la table deleted_posts
        DeletedPost::create([
            'title' => $post->title,
            'content' => $post->content,
            'media_type' => $post->media_type,
            'media_url' => $post->media_url,
            'user_id' => $post->user_id,
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);

        // Enregistrer chaque commentaire associé dans la table deleted_comments
        foreach ($post->comments as $comment) {
            DeletedComment::create([
                'content' => $comment->content,
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'parent_id' => $comment->parent_id,
                'deleted_at' => now(),
                'deleted_by' => Auth::id(),
            ]);

            // Marquer les signalements associés au commentaire comme "dismissed"
            Report::where('reportable_type', Comment::class)
                ->where('reportable_id', $comment->id)
                ->update(['status' => 'dismissed']);
        }

        // Marquer tous les signalements associés au post comme "dismissed"
        Report::where('reportable_type', Post::class)
            ->where('reportable_id', $post->id)
            ->update(['status' => 'dismissed']);

        // Supprimer le post (les commentaires seront supprimés en cascade si configuré dans la base de données)
        $post->delete();

        // Si la requête est AJAX, retourner une réponse JSON
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Post supprimé avec succès !']);
        }

        // Sinon, redirection pour les requêtes non-AJAX
        return redirect()->route('forum.index')->with('success', 'Post supprimé avec succès !');
    }


    public function votePost(Request $request, Post $post)
    {
        $request->validate([
            'is_upvote' => 'required|boolean',
        ]);

        if (!Auth::user()->is_active) {
            return redirect()->back()->with('error', 'Vous êtes bloqué et ne pouvez pas voter.');
        }

        $vote = PostVote::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => Auth::id()],
            ['is_upvote' => $request->is_upvote]
        );

        return redirect()->back()->with('success', 'Vote enregistré !');
    }

    public function voteComment(Request $request, Comment $comment)
    {
        $request->validate([
            'is_upvote' => 'required|boolean',
        ]);

        if (!Auth::user()->is_active) {
            return redirect()->back()->with('error', 'Vous êtes bloqué et ne pouvez pas voter.');
        }

        $vote = CommentVote::updateOrCreate(
            ['comment_id' => $comment->id, 'user_id' => Auth::id()],
            ['is_upvote' => $request->is_upvote]
        );

        return redirect()->back()->with('success', 'Vote enregistré !');
    }

    public function blockUser(User $user)
        {
            if (!$this->canManageForum()) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à bloquer cet utilisateur.');
            }

            if ($user->role === 'superadmin') {
                return redirect()->back()->with('error', 'Impossible de bloquer un superadmin.');
            }

            $user->update(['is_active' => false]);

            BlockedUser::create([
                'user_id' => $user->id,
                'blocked_by' => Auth::id(),
                'blocked_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Utilisateur bloqué avec succès !');
        }

    public function updateReport(Request $request, $id)
        {
            if (!$this->canManageForum()) {
                return redirect()->route('dashboard')->with('error', 'Vous n\'êtes pas autorisé à modifier les signalements.');
            }

            $report = Report::findOrFail($id);
            $request->validate([
                'status' => 'required|in:pending,reviewed,dismissed',
            ]);

            $report->update(['status' => $request->status]);

            return redirect()->route('dashboard.reports')->with('success', 'Statut du signalement mis à jour.');
        }

    public function unblockUser(User $user)
        {
            if (!$this->canManageForum()) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à débloquer cet utilisateur.');
            }

            $user->update(['is_active' => true]);

            BlockedUser::where('user_id', $user->id)->delete();

            return redirect()->back()->with('success', 'Utilisateur débloqué avec succès !');
        }

    public function blockedUsers()
    {
        if (!$this->canManageForum()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        \Log::info('Accès à blockedUsers', [
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'affectation_modules' => Auth::user()->affectation ? Auth::user()->affectation->modules : null,
        ]);

        $blockedUsers = BlockedUser::with(['user', 'blockedBy'])->orderBy('blocked_at', 'desc')->get();
        return view('dashboard.blocked-users', compact('blockedUsers'));
    }

    private function detectMediaType($url)
    {
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches) || preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
            return 'youtube';
        }

        if (preg_match('/\.(jpg|jpeg|png|gif|bmp)$/i', $url)) {
            return 'image';
        }

        return 'link';
    }
}