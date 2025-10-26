    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\SocialiteController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\PodcastController;
    use App\Http\Controllers\AffectationController;
    use App\Http\Controllers\EpisodeController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\SettingsController;
    use App\Http\Controllers\ForumController;
    use App\Http\Controllers\PostController;
    use App\Http\Controllers\PollController;
    use App\Http\Controllers\PodcastsAdminController;
    use App\Http\Controllers\ArticleController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\ChatbotController;
    use App\Http\Controllers\LogsController;
    use App\Http\Controllers\QuestionController;
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */

    // Chatbot routes
    Route::post('/chatbot/ask', [ChatbotController::class, 'ask']);
    Route::get('/chatbot', function () {
        return view('chatbot');
    });

    // Page d'accueil
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/episodes', [EpisodeController::class, 'index'])->name('episodes.index');

    // Routes pour les podcasts
    Route::get('/podcasts', [PodcastController::class, 'index'])->name('podcasts.index');
    Route::get('/podcasts/comments/{videoId}', [PodcastController::class, 'getComments'])->name('podcasts.comments');
    Route::get('/podcasts/likes/{videoId}', [PodcastController::class, 'getLikeCount'])->name('podcasts.getLikeCount');

    Route::middleware('auth')->group(function () {
        Route::post('/podcasts/like', [PodcastController::class, 'toggleLike'])->name('podcasts.like');
        Route::post('/podcasts/comment', [PodcastController::class, 'addComment'])->name('podcasts.comment');
        Route::post('/podcasts/reply', [PodcastController::class, 'addReply'])->name('podcasts.reply');
        Route::delete('/podcasts/comment/{id}', [PodcastController::class, 'deleteComment'])->name('podcasts.comment.delete');
        Route::delete('/podcasts/reply/{id}', [PodcastController::class, 'deleteReply'])->name('podcasts.reply.delete');
        Route::post('/podcasts/report', [PodcastController::class, 'reportComment'])->name('podcasts.report');
    });

    // Tableau de bord - accessible uniquement pour admin et superadmin
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin') {
                $controller = new DashboardController();
                return $controller->index();
            }
            return redirect()->route('home');
        })->name('dashboard');
        
        Route::get('/dashboard/stats', function () {
            if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin') {
                $controller = new DashboardController();
                return $controller->getStats();
            }
            return response()->json(['error' => 'Unauthorized'], 403);
        })->name('dashboard.stats');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard/articles-signales', [ArticleController::class, 'viewReports'])->name('dashboard.articles-signales');
        Route::patch('/dashboard/articles-signales/{id}', [ArticleController::class, 'updateReport'])->name('dashboard.articles.updateReport');
    });

    // Routes pour la gestion du profil
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');
    });

    // 🔐 Connexion via Google ou Facebook
    Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])
        ->where('provider', 'google|facebook')
        ->name('socialite.redirect');

    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])
        ->where('provider', 'google|facebook')
        ->name('socialite.callback');

    // Routes pour la gestion des utilisateurs et affectations
    Route::middleware(['auth', 'IsSuperadmin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');

        // NEW: Routes for admin creation
        Route::get('/users/create-admin', [UserController::class, 'createAdmin'])->name('users.create-admin');
        Route::post('/users/store-admin', [UserController::class, 'storeAdmin'])->name('users.store-admin');

        Route::get('/contact', function () {
        return view('contact');
        })->name('contact');

        // Routes pour les affectations
        Route::get('/affectations', [AffectationController::class, 'index'])->name('affectations.index');
        Route::get('/affectations/create', [AffectationController::class, 'create'])->name('affectations.create');
        Route::post('/affectations', [AffectationController::class, 'store'])->name('affectations.store');
        Route::get('/affectations/{id}/edit', [AffectationController::class, 'edit'])->name('affectations.edit');
        Route::put('/affectations/{id}', [AffectationController::class, 'update'])->name('affectations.update');
        Route::delete('/affectations/{id}', [AffectationController::class, 'destroy'])->name('affectations.destroy');
        Route::get('/affectations/ancien_admins', [AffectationController::class, 'anciensAdmins'])
            ->name('affectations.ancien_admins');
    });

    // Routes pour les paramètres
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Routes pour le forum
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::middleware('auth')->group(function () {
        Route::get('/forum/create/{type?}', [PostController::class, 'createForm'])->name('post.createForm');
        Route::post('/forum/create', [PostController::class, 'create'])->name('post.create');
        Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
        Route::post('/post/{post}/comment', [PostController::class, 'comment'])->name('post.comment');
        Route::delete('/comment/{comment}', [PostController::class, 'deleteComment'])->name('comment.delete');
        Route::delete('/post/{post}', [PostController::class, 'deletePost'])->name('post.delete');
        Route::post('/post/{post}/vote', [PostController::class, 'votePost'])->name('post.vote');
        Route::post('/comment/{comment}/vote', [PostController::class, 'voteComment'])->name('comment.vote');
        Route::post('/poll/{poll}/vote', [PollController::class, 'vote'])->name('poll.vote');
        Route::post('/user/{user}/block', [PostController::class, 'blockUser'])->name('user.block');
        Route::post('/user/{user}/unblock', [PostController::class, 'unblockUser'])->name('user.unblock');
        Route::post('/report/{type}/{id}', [PostController::class, 'report'])->name('report.submit');
        Route::get('/dashboard/reports', [PostController::class, 'reports'])->name('dashboard.reports');
        Route::patch('/dashboard/reports/{id}', [PostController::class, 'updateReport'])->name('dashboard.updateReport');
        Route::get('/dashboard/blocked-users', [PostController::class, 'blockedUsers'])->name('dashboard.blocked-users');
    });

    // Routes pour le contenu supprimé (superadmin uniquement)
    Route::middleware(['auth', 'IsSuperadmin'])->prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('deleted-content', [DashboardController::class, 'deletedContent'])->name('deleted_content');
        Route::post('restore-comment/{id}', [DashboardController::class, 'restoreComment'])->name('restore-comment');
        Route::post('restore-reply/{id}', [DashboardController::class, 'restoreReply'])->name('restore-reply');
        Route::delete('force-delete-comment/{id}', [DashboardController::class, 'forceDeleteComment'])->name('force-delete-comment');
        Route::delete('force-delete-reply/{id}', [DashboardController::class, 'forceDeleteReply'])->name('force-delete-reply');
        Route::get('deleted-content/stats', [DashboardController::class, 'getDeletedContentStats'])->name('deleted-content.stats');
        Route::get('deleted-content/search', [DashboardController::class, 'searchDeletedContent'])->name('deleted-content.search');
    }); 

    // Routes pour l'administration des signalements des podcasts
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard/podcasts/reports', [PodcastsAdminController::class, 'viewReports'])->name('dashboard.podcasts.reports');
        Route::patch('/dashboard/podcasts/reports/{id}', [PodcastsAdminController::class, 'updateReport'])->name('dashboard.podcasts.updateReport');
    });

    // Routes pour les logs (superadmin uniquement)
    Route::middleware(['auth', 'IsSuperadmin'])->prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('logs', [LogsController::class, 'index'])->name('logs.index');
        Route::get('logs/{log}', [LogsController::class, 'show'])->name('logs.show');
        Route::get('logs/stats', [LogsController::class, 'stats'])->name('logs.stats');
    });

/*
|--------------------------------------------------------------------------
| ROUTES POUR LES ARTICLES
|--------------------------------------------------------------------------
*/

// Routes publiques pour les articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show')->where('id', '[0-9]+');

// Routes pour les commentaires d'articles (ACCESSIBLES À TOUS)
Route::prefix('articles')->group(function () {
    // Récupérer les commentaires (accessible à tous)
    Route::get('/comments/{articleId}', [ArticleController::class, 'getComments'])
        ->name('articles.comments.get');

    // Routes nécessitant une authentification
    Route::middleware('auth')->group(function () {
        // Gestion des commentaires
        Route::post('/comment', [ArticleController::class, 'addComment'])
            ->name('articles.comment.add');
        Route::post('/reply', [ArticleController::class, 'addReply'])
            ->name('articles.reply.add');
        Route::delete('/comment/{commentId}', [ArticleController::class, 'deleteComment'])
            ->name('articles.comment.delete');
        Route::delete('/reply/{replyId}', [ArticleController::class, 'deleteReply'])
            ->name('articles.reply.delete');
        
        // Signalement des commentaires et articles
        Route::post('/report-comment', [ArticleController::class, 'reportComment'])
            ->name('articles.report-comment');
        Route::post('/report-article', [ArticleController::class, 'reportArticle'])
            ->name('articles.report-article');
    });
});

// Routes authentifiées pour la gestion des articles
Route::middleware(['auth'])->group(function () {
    // Routes de création et d'édition
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::get('/articles/drafts', [ArticleController::class, 'drafts'])->name('articles.drafts');
    Route::post('/articles/autosave', [ArticleController::class, 'autosave'])->name('articles.autosave');
    Route::get('/articles-supprimes', [ArticleController::class, 'supprimes'])->name('articles.supprimes');
    
    // Routes génériques pour les articles (avec ID)
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit')->where('id', '[0-9]+');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update')->where('id', '[0-9]+');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy')->where('id', '[0-9]+');
    
    // Routes d'action spécifiques avec ID
    Route::match(['post', 'patch'], '/articles/{article}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
    Route::match(['post', 'patch'], '/articles/{id}/restore', [ArticleController::class, 'restore'])->name('articles.restore')->where('id', '[0-9]+');
    Route::post('/articles/{article}/to-draft', [ArticleController::class, 'toDraft'])->name('articles.to-draft');
});

/*
|--------------------------------------------------------------------------
| ROUTES POUR LE DASHBOARD DES SIGNALEMENTS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    
    // Dashboard principal des signalements d'articles (commentaires)
    // Uses viewReports() method - displays comment reports using ArticleCommentReport model
    Route::get('/articles-signales', [ArticleController::class, 'viewReports'])
        ->name('articles-signales');
    
    // Actions sur les signalements de commentaires
    Route::post('/articles-signales/{id}/update-status', [ArticleController::class, 'updateReportStatus'])
        ->name('articles-signales.update-status');
    Route::patch('/articles-signales/{id}', [ArticleController::class, 'updateReport'])
        ->name('articles-signales.update');
    Route::post('/articles-signales/bulk-process', [ArticleController::class, 'bulkProcessReports'])
        ->name('articles-signales.bulk-process');
    
    // Dashboard des signalements d'articles entiers
    // Uses viewArticleReports() method - displays article reports using ArticleReport model
    Route::get('/articles-reports', [ArticleController::class, 'viewArticleReports'])
        ->name('articles-reports');
    
    // Actions sur les signalements d'articles
    Route::patch('/articles-reports/{id}', [ArticleController::class, 'updateArticleReport'])
        ->name('articles-reports.update');
    Route::post('/articles-reports/bulk-process', [ArticleController::class, 'bulkProcessArticleReports'])
        ->name('articles-reports.bulk-process');
    
    // Routes alternatives avec noms plus explicites (si nécessaire)
    Route::get('/comment-reports', [ArticleController::class, 'viewReports'])
        ->name('comment-reports');
    Route::patch('/comment-reports/{id}', [ArticleController::class, 'updateReportStatus'])
        ->name('comment-reports.update');
    Route::post('/comment-reports/bulk-process', [ArticleController::class, 'bulkProcessReports'])
        ->name('comment-reports.bulk-process');
    
    // Vue combinée pour tous les signalements liés aux articles - UPDATED
    Route::get('/all-article-reports', [ArticleController::class, 'viewAllReports'])
        ->name('all-article-reports');
});

// Route pour récupérer un nouveau token CSRF
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->name('csrf.token');


// Public routes
Route::get('/questions', [QuestionController::class, 'public'])->name('questions.public');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/ask-question', [QuestionController::class, 'index'])->name('questions.index');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
});

// Admin routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/questions', [QuestionController::class, 'admin'])->name('questions.admin');
    Route::get('/admin/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
    Route::post('/admin/questions/{question}/answer', [QuestionController::class, 'answer'])->name('questions.answer');
    Route::patch('/admin/questions/{question}/toggle-visibility', [QuestionController::class, 'toggleVisibility'])->name('questions.toggle_visibility');
});

// Routes auth Laravel Breeze (login, register, etc.)
require __DIR__.'/auth.php';