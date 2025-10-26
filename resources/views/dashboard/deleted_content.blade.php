<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenu Supprimé - Business+ Talk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1a9e9e',
                            hover: '#25c4c4',
                            dark: '#148585',
                        },
                        danger: '#b91c1c',
                        warning: '#b45309',
                        success: '#10b981',
                        dark: {
                            DEFAULT: '#121212',
                            card: '#1e1e1e',
                            element: '#252525',
                            border: '#333333',
                        },
                    },
                }
            }
        }
    </script>
    <style>
        /* Variables CSS harmonisées */
        :root {
            @php
                $settings = App\Models\Setting::first();
                $primaryColor = $settings->primary_color ?? '#1EB5AD';
            @endphp
            --primary-color: {{ $primaryColor }};
           --dark-bg: #1A1D21;
            --darker-bg: #111315;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
            --gray-bg: #2A2D35;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--darker-bg);
            color: var(--light-text);
            overflow-x: hidden;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
        }

        /* En-tête */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--dark-border);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--light-text);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header h1 i {
            color: var(--primary-color);
        }

        .back-btn {
            background: linear-gradient(135deg, var(--gray-bg), var(--dark-element));
            color: var(--light-text);
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--dark-border);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, var(--dark-element), var(--gray-bg));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }

        /* Messages d'alerte */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-left-color: var(--success);
        }

        .alert-error {
            background-color: rgba(185, 28, 28, 0.1);
            color: var(--danger);
            border-left-color: var(--danger);
        }

        /* Onglets */
        .tabs-container {
            margin-bottom: 2rem;
        }

        .tabs-nav {
            display: flex;
            gap: 0.5rem;
            border-bottom: 1px solid var(--dark-border);
            overflow-x: auto;
            padding-bottom: 0;
        }

        .tab-button {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            color: var(--gray-text);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .tab-button:hover {
            color: var(--light-text);
            background-color: rgba(26, 158, 158, 0.1);
        }

        .tab-button.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            background-color: rgba(26, 158, 158, 0.15);
        }

        .tab-badge {
            background-color: var(--dark-element);
            color: var(--light-text);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            min-width: 1.5rem;
            text-align: center;
        }

        .tab-button.active .tab-badge {
            background-color: var(--primary-color);
        }

        /* Contenu des onglets */
        .tab-content {
            display: none;
            animation: fadeInUp 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary-color);
        }

        /* Tables */
        .table-container {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: var(--dark-element);
        }

        .table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-text);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--dark-border);
        }

        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--dark-border);
            color: var(--light-text);
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(26, 158, 158, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges de type */
        .type-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .type-badge.comment {
            background-color: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }

        .type-badge.reply {
            background-color: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .type-badge.podcast {
            background-color: rgba(139, 92, 246, 0.15);
            color: #a78bfa;
        }

        .type-badge.post {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
        }

        /* Liens */
        .table-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .table-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* Texte tronqué */
        .text-truncate {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-muted {
            color: var(--gray-text);
        }

        /* État vide */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-text);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--dark-element);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--light-text);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .header h1 {
                font-size: 2rem;
                text-align: center;
            }

            .tabs-nav {
                justify-content: center;
            }

            .tab-button {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .table-container {
                overflow-x: auto;
            }

            .table th,
            .table td {
                padding: 0.75rem 1rem;
                min-width: 120px;
            }

            .text-truncate {
                max-width: 200px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <!-- En-tête -->
        <div class="header">
            <h1>
                <i class="fas fa-trash-alt"></i>
                Contenu Supprimé
            </h1>
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Retour au Dashboard
            </a>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Onglets -->
        <div class="tabs-container">
            <nav class="tabs-nav">
                <button onclick="showTab('comments')" 
                        class="tab-button active"
                        id="comments-tab">
                    <i class="fas fa-newspaper"></i>
                    Articles
                    <span class="tab-badge">
                        {{ (isset($deletedComments) ? $deletedComments->count() : 0) + (isset($deletedReplies) ? $deletedReplies->count() : 0) }}
                    </span>
                </button>
                
                <button onclick="showTab('podcasts')" 
                        class="tab-button"
                        id="podcasts-tab">
                    <i class="fas fa-podcast"></i>
                    Podcasts
                    <span class="tab-badge">
                        {{ (isset($deletedPodcasts) ? $deletedPodcasts->count() : 0) + (isset($deletedPodcastComments) ? $deletedPodcastComments->count() : 0) }}
                    </span>
                </button>
                
                <button onclick="showTab('forums')" 
                        class="tab-button"
                        id="forums-tab">
                    <i class="fas fa-comments"></i>
                    Forums
                    <span class="tab-badge">
                        {{ (isset($deletedPosts) ? $deletedPosts->count() : 0) + (isset($deletedForumComments) ? $deletedForumComments->count() : 0) }}
                    </span>
                </button>
            </nav>
        </div>

        <!-- Onglet Commentaires d'Articles -->
        <div id="comments-content" class="tab-content active">
            <h3 class="section-title">
                <i class="fas fa-comment"></i>
                Commentaires d'Articles Supprimés
            </h3>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Auteur</th>
                            <th>Contenu</th>
                            <th>Type</th>
                            <th>Article</th>
                            <th>Supprimé par</th>
                            <th>Date de suppression</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $allDeletedComments = collect();
                            
                            if(isset($deletedComments)) {
                                foreach($deletedComments as $comment) {
                                    $deletedByName = 'Système';
                                    if($comment->deleted_by) {
                                        $deletedByUser = \App\Models\User::find($comment->deleted_by);
                                        $deletedByName = $deletedByUser ? $deletedByUser->name : 'Utilisateur supprimé';
                                    }
                                    
                                    $allDeletedComments->push([
                                        'id' => $comment->id,
                                        'type' => 'comment',
                                        'author' => $comment->user->name ?? 'Utilisateur supprimé',
                                        'content' => $comment->content,
                                        'article_title' => $comment->article->titre ?? 'Article supprimé',
                                        'article_id' => $comment->article->id ?? null,
                                        'deleted_by' => $deletedByName,
                                        'deleted_at' => $comment->deleted_at,
                                        'model' => $comment
                                    ]);
                                }
                            }
                            
                            if(isset($deletedReplies)) {
                                foreach($deletedReplies as $reply) {
                                    $deletedByName = 'Système';
                                    if($reply->deleted_by) {
                                        $deletedByUser = \App\Models\User::find($reply->deleted_by);
                                        $deletedByName = $deletedByUser ? $deletedByUser->name : 'Utilisateur supprimé';
                                    }
                                    
                                    $allDeletedComments->push([
                                        'id' => $reply->id,
                                        'type' => 'reply',
                                        'author' => $reply->user->name ?? 'Utilisateur supprimé',
                                        'content' => $reply->content,
                                        'article_title' => $reply->comment->article->titre ?? 'Article supprimé',
                                        'article_id' => $reply->comment->article->id ?? null,
                                        'deleted_by' => $deletedByName,
                                        'deleted_at' => $reply->deleted_at,
                                        'model' => $reply
                                    ]);
                                }
                            }
                            
                            $allDeletedComments = $allDeletedComments->sortByDesc('deleted_at');
                        @endphp

                        @forelse($allDeletedComments as $item)
                            <tr>
                                <td>
                                    <div class="text-sm font-medium">{{ $item['author'] }}</div>
                                </td>
                                <td>
                                    <div class="text-sm text-truncate" title="{{ $item['content'] }}">
                                        {{ Str::limit($item['content'], 100) }}
                                    </div>
                                </td>
                                <td>
                                    @if($item['type'] === 'comment')
                                        <span class="type-badge comment">
                                            <i class="fas fa-comment mr-1"></i>
                                            Commentaire
                                        </span>
                                    @else
                                        <span class="type-badge reply">
                                            <i class="fas fa-reply mr-1"></i>
                                            Réponse
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($item['article_id'])
                                        <a href="{{ route('articles.show', $item['article_id']) }}" 
                                           class="table-link text-truncate"
                                           target="_blank" 
                                           title="{{ $item['article_title'] }}">
                                            {{ Str::limit($item['article_title'], 60) }}
                                        </a>
                                    @else
                                        <div class="text-muted text-truncate">{{ Str::limit($item['article_title'], 60) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-sm">{{ $item['deleted_by'] }}</div>
                                </td>
                                <td>
                                    <div class="text-sm">
                                        {{ $item['deleted_at'] ? $item['deleted_at']->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h3>Aucun commentaire supprimé</h3>
                                        <p>Il n'y a actuellement aucun commentaire d'article supprimé.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
<!-- Onglet Podcasts -->
<div id="podcasts-content" class="tab-content">
    <h3 class="text-lg font-semibold text-white-800 mb-4">
        🎧 Commentaires de Podcasts Supprimés</h3>
    @if($deletedPodcastComments->isEmpty())
        <div class="bg-gray-100 text-gray-500 p-6 rounded-lg text-center">
            Aucun commentaire de podcast supprimé trouvé
        </div>
    @else
        <div class="table-container">
            <table class="table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Vidéo ID</th>
                        <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Contenu</th>
                        <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Auteur</th>
                        <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Supprimé par</th>
                        <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Date de suppression</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedPodcastComments as $comment)
                        <tr class="hover:bg-gray-50"id=>
                            <td class="px-4 py-3 border-b">
                                <div class="text-sm text-white-900">{{ $comment->id }}</div>
                            </td>
                            <td class="px-4 py-3 border-b">
                                @if($comment->parent_id)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Réponse
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Commentaire
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="text-sm text-white-900">{{ $comment->video_id }}</div>
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="text-sm text-white-900 max-w-xs" title="{{ $comment->content }}">
                                    {{ \Illuminate\Support\Str::limit($comment->content, 50) }}
                                </div>
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="text-sm text-white-900">{{ $comment->user->name ?? 'Inconnu' }}</div>
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="text-sm text-white-900">{{ $comment->deletedBy->name ?? 'Inconnu' }}</div>
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="text-sm text-white-900">
                                    {{ $comment->deleted_at ? \Carbon\Carbon::parse($comment->deleted_at)->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($deletedPodcastComments->hasPages())
            <div class="mt-6 flex justify-center">
                <nav class="pagination flex items-center gap-2">
                    <div class="nav">
                        @if($deletedPodcastComments->onFirstPage())
                            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded cursor-not-allowed">Précédent</span>
                        @else
                            <a href="{{ $deletedPodcastComments->previousPageUrl() }}" class="px-3 py-1 bg-gray-100 text-blue-600 rounded hover:bg-blue-600 hover:text-white">Précédent</a>
                        @endif
                        @if($deletedPodcastComments->hasMorePages())
                            <a href="{{ $deletedPodcastComments->nextPageUrl() }}" class="px-3 py-1 bg-gray-100 text-blue-600 rounded hover:bg-blue-600 hover:text-white">Suivant</a>
                        @else
                            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded cursor-not-allowed">Suivant</span>
                        @endif
                    </div>
                    <div class="info px-3 py-1 bg-gray-100 text-gray-800 rounded">
                        Affichage de {{ $deletedPodcastComments->firstItem() }} à {{ $deletedPodcastComments->lastItem() }} sur {{ $deletedPodcastComments->total() }} résultats
                    </div>
                    <div class="pages flex gap-1">
                        @for($i = max(1, $deletedPodcastComments->currentPage() - 2); $i <= min($deletedPodcastComments->lastPage(), $deletedPodcastComments->currentPage() + 2); $i++)
                            @if($i == $deletedPodcastComments->currentPage())
                                <span class="px-3 py-1 bg-blue-600 text-white rounded font-semibold">{{ $i }}</span>
                            @else
                                <a href="{{ $deletedPodcastComments->url($i) }}" class="px-3 py-1 bg-gray-100 text-blue-600 rounded hover:bg-blue-600 hover:text-white">{{ $i }}</a>
                            @endif
                        @endfor
                    </div>
                </nav>
            </div>
        @endif
    @endif
</div>
        
        <!-- Onglet Forums -->
        <div id="forums-content" class="tab-content">
            <!-- Posts Supprimés -->
            <div class="mb-8">
                <h3 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Posts de Forum Supprimés
                </h3>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Supprimé par</th>
                                <th>Date de suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($deletedPosts))
                                @forelse($deletedPosts as $post)
                                <tr>
                                    <td>
                                        <div class="text-sm font-medium text-truncate" title="{{ $post->title }}">
                                            {{ $post->title }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm">{{ $post->user ? $post->user->name : 'Utilisateur inconnu' }}</div>
                                    </td>
                                    <td>
                                        <div class="text-sm">{{ $post->deletedBy ? $post->deletedBy->name : 'Utilisateur inconnu' }}</div>
                                    </td>
                                    <td>
                                        <div class="text-sm">{{ $post->deleted_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-file-alt"></i>
                                            <h3>Aucun post supprimé</h3>
                                            <p>Il n'y a actuellement aucun post de forum supprimé.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-file-alt"></i>
                                            <h3>Aucun post supprimé</h3>
                                            <p>Il n'y a actuellement aucun post de forum supprimé.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Commentaires de Forum Supprimés -->
            <div>
                <h3 class="section-title">
                    <i class="fas fa-comment"></i>
                    Commentaires de Forum Supprimés
                </h3>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Contenu</th>
                                <th>Post Associé</th>
                                <th>Auteur</th>
                                <th>Supprimé par</th>
                                <th>Date de suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($deletedForumComments))
                                @forelse($deletedForumComments as $comment)
                                <tr>
                                    <td>
                                        <div class="text-sm text-truncate" title="{{ $comment->content }}">
                                            {{ Str::limit($comment->content, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($comment->post)
                                            <a href="{{ route('post.show', $comment->post_id) }}" class="table-link text-truncate" title="{{ $comment->post->title }}">
                                                {{ Str::limit($comment->post->title, 40) }}
                                            </a>
                                        @else
                                            <span class="text-muted">Post supprimé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-sm">{{ $comment->user ? $comment->user->name : 'Utilisateur inconnu' }}</div>
                                    </td>
                                    <td>
                                        <div class="text-sm">{{ $comment->deletedBy ? $comment->deletedBy->name : 'Utilisateur inconnu' }}</div>
                                    </td>
                                    <td>
                                        <div class="text-sm">{{ $comment->deleted_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <i class="fas fa-comment"></i>
                                            <h3>Aucun commentaire supprimé</h3>
                                            <p>Il n'y a actuellement aucun commentaire de forum supprimé.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <i class="fas fa-comment"></i>
                                            <h3>Aucun commentaire supprimé</h3>
                                            <p>Il n'y a actuellement aucun commentaire de forum supprimé.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Cacher tous les contenus d'onglets
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            
            // Désactiver tous les boutons d'onglets
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });
            
            // Afficher le contenu de l'onglet sélectionné
            document.getElementById(tabName + '-content').classList.add('active');
            
            // Activer le bouton d'onglet sélectionné
            const activeButton = document.getElementById(tabName + '-tab');
            if (activeButton) {
                activeButton.classList.add('active');
            }
        }

        // Initialiser avec l'onglet Articles actif
        document.addEventListener('DOMContentLoaded', function() {
            showTab('comments');
            
            // Animation d'entrée pour les éléments
            const elements = document.querySelectorAll('.table-container, .section-title');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
                element.classList.add('fade-in');
            });
        });

        // Gestion des alertes auto-dismiss
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>