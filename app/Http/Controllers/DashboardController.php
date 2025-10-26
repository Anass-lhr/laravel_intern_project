<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ArticleComment;
use App\Models\ArticleCommentReply;
use App\Models\Article;
use App\Models\DeletedPost;
use App\Models\DeletedComment;
use App\Models\User;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques des utilisateurs
        $totalUsers = User::count();
        $totalAdmins = User::whereIn('role', ['admin', 'superadmin'])->count();
        $activeUsers = User::where('role', 'user')->count();
        $pendingReports = 0; // Remplacez par votre logique de signalements
        $recentUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $superAdmins = User::where('role', 'superadmin')->count();
        $regularAdmins = User::where('role', 'admin')->count();
        $regularUsers = User::where('role', 'user')->count();

        // Calculer les pourcentages
        $adminPercent = $totalUsers > 0 ? round(($totalAdmins / $totalUsers) * 100, 1) : 0;
        $activePercent = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0;
        $reportsPercent = $totalUsers > 0 ? round(($pendingReports / $totalUsers) * 100, 1) : 0;
        $recentUsersPercent = $totalUsers > 0 ? round(($recentUsers / $totalUsers) * 100, 1) : 0;
        $superAdminsPercent = $totalUsers > 0 ? round(($superAdmins / $totalUsers) * 100, 1) : 0;
        $regularAdminsPercent = $totalUsers > 0 ? round(($regularAdmins / $totalUsers) * 100, 1) : 0;

        return view('dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'activeUsers',
            'pendingReports',
            'adminPercent',
            'activePercent',
            'reportsPercent',
            'recentUsers',
            'superAdmins',
            'regularAdmins',
            'regularUsers',
            'recentUsersPercent',
            'superAdminsPercent',
            'regularAdminsPercent'
        ));
    }

    public function getStats()
    {
        if (!auth()->user() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $stats = [
            'totalUsers' => User::count(),
            'totalAdmins' => User::whereIn('role', ['admin', 'superadmin'])->count(),
            'activeUsers' => User::where('role', 'user')->count(),
            'pendingReports' => 0, // Remplacez par votre logique
            'recentUsers' => User::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'superAdmins' => User::where('role', 'superadmin')->count(),
            'regularAdmins' => User::where('role', 'admin')->count(),
            'regularUsers' => User::where('role', 'user')->count(),
        ];

        // Calculer les pourcentages
        $stats['adminPercent'] = $stats['totalUsers'] > 0 ? round(($stats['totalAdmins'] / $stats['totalUsers']) * 100, 1) : 0;
        $stats['activePercent'] = $stats['totalUsers'] > 0 ? round(($stats['activeUsers'] / $stats['totalUsers']) * 100, 1) : 0;
        $stats['reportsPercent'] = $stats['totalUsers'] > 0 ? round(($stats['pendingReports'] / $stats['totalUsers']) * 100, 1) : 0;
        $stats['recentUsersPercent'] = $stats['totalUsers'] > 0 ? round(($stats['recentUsers'] / $stats['totalUsers']) * 100, 1) : 0;
        $stats['superAdminsPercent'] = $stats['totalUsers'] > 0 ? round(($stats['superAdmins'] / $stats['totalUsers']) * 100, 1) : 0;
        $stats['regularAdminsPercent'] = $stats['totalUsers'] > 0 ? round(($stats['regularAdmins'] / $stats['totalUsers']) * 100, 1) : 0;

        return response()->json($stats);
    }

    public function getDeletedContentStats()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Accès non autorisé');
        }

        $stats = [
            'deleted_articles' => Article::where('is_deleted', true)->count(),
            'deleted_comments' => ArticleComment::where('is_deleted', true)->count(),
            'deleted_replies' => ArticleCommentReply::where('is_deleted', true)->count(),
            'deleted_podcasts' => 0,
            'deleted_forums' => 0,
        ];

        return response()->json($stats);
    }

    public function searchDeletedContent(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Accès non autorisé');
        }

        $search = $request->get('search');
        $type = $request->get('type', 'all');

        $results = [];

        if ($type === 'all' || $type === 'articles') {
            $deletedArticles = Article::where('is_deleted', true)
                ->where(function($query) use ($search) {
                    $query->where('titre', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhere('auteur', 'like', "%{$search}%");
                })
                ->with(['creator', 'deleter'])
                ->get();
            
            $results['articles'] = $deletedArticles;
        }

        if ($type === 'all' || $type === 'comments') {
            $deletedComments = ArticleComment::where('is_deleted', true)
                ->where('content', 'like', "%{$search}%")
                ->with(['user', 'article', 'deletedBy'])
                ->get();
            
            $results['comments'] = $deletedComments;
        }

        if ($type === 'all' || $type === 'replies') {
            $deletedReplies = ArticleCommentReply::where('is_deleted', true)
                ->where('content', 'like', "%{$search}%")
                ->with(['user', 'comment.article', 'deletedBy'])
                ->get();
            
            $results['replies'] = $deletedReplies;
        }

        $deletedPosts = collect();
        $deletedForumComments = collect();

        return view('dashboard.deleted_content_search', compact('deletedPosts', 'deletedForumComments'));
    }

public function deletedContent()
{
    // Vérifier que l'utilisateur est superadmin
    if (Auth::user()->role !== 'superadmin') {
        abort(403, 'Accès non autorisé');
    }

    // ========== ARTICLES ==========
    $deletedArticles = Article::where('is_deleted', true)
        ->with(['creator', 'deleter'])
        ->orderBy('deleted_at', 'desc')
        ->get();

    $deletedComments = ArticleComment::where('is_deleted', true)
        ->with(['user', 'article', 'deletedBy'])
        ->orderBy('deleted_at', 'desc')
        ->get();

    $deletedReplies = ArticleCommentReply::where('is_deleted', true)
        ->with(['user', 'comment.article', 'deletedBy'])
        ->orderBy('deleted_at', 'desc')
        ->get();

    // ========== FORUMS ==========
    $deletedPosts = collect();
    $deletedForumComments = collect();
    
    if (class_exists('App\Models\DeletedPost')) {
        $deletedPosts = \App\Models\DeletedPost::with(['user', 'deletedBy'])
            ->orderBy('deleted_at', 'desc')
            ->get();
    }

    if (class_exists('App\Models\DeletedComment')) {
        $deletedForumComments = \App\Models\DeletedComment::with(['user', 'deletedBy', 'post'])
            ->orderBy('deleted_at', 'desc')
            ->get();
    }

    // ========== PODCASTS ==========
    $deletedPodcasts = collect(); // Collection vide pour les podcasts supprimés
    $deletedPodcastComments = collect();

    if (class_exists('App\Models\DeletedCommentsPodcast')) {
        $deletedPodcastComments = \App\Models\DeletedCommentsPodcast::with(['user', 'deletedBy', 'parent'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(20); // Paginate to match showDeletedComments
    }

    return view('dashboard.deleted_content', compact(
        'deletedArticles',
        'deletedComments',
        'deletedReplies',
        'deletedPodcasts',
        'deletedPosts',
        'deletedForumComments',
        'deletedPodcastComments'
    ));
}
}