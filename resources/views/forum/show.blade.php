<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - BUSINESS+ Talk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
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

        img {
            max-width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .container {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            margin-right:0;
            margin-left: 280px;
            padding: 0;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .content-area {
            padding: 2rem;
            flex: 1;
        }

        .back-link {
            display: block;
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: color-mix(in srgb, var(--primary-color) 80%, #ffffff);
            text-decoration: underline;
        }

        .error-message {
            color: #E50914;
            text-align: center;
            padding: 20px;
            background-color: #1A1A1A;
            border: 1px solid #E50914;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-out;
        }

        .error-message a {
            color: var(--primary-color);
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .disabled-btn {
            background-color: #2a2a2a !important;
            cursor: not-allowed !important;
            opacity: 0.6;
        }

        /* SOLUTION : Remplacer le CSS existant pour .post-media a */
        .post-media a {
            color: var(--primary-color);
            font-size: 0.9rem;
            text-decoration: none;
            margin-top: 0.5rem;
            display: block;
            
            /* NOUVEAU : Gestion des liens longs */
            word-wrap: break-word;
            word-break: break-all;
            overflow-wrap: break-word;
            hyphens: auto;
            
            /* Alternative : Limiter à une ligne avec ellipsis */
            /* 
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            */
        }

        .post-media a:hover {
            text-decoration: underline;
        }

        /* CSS supplémentaire pour s'assurer que la carte reste contenue */
        .post-card {
            background-color: var(--darker-bg);
            padding: 1rem;
            border-radius: 0.75rem;
            transition: transform 0.2s ease;
            border: 1px solid #333333;
            
            /* NOUVEAU : Forcer la largeur et empêcher le débordement */
            width: 100%;
            max-width: 100%;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* NOUVEAU : Gestion spécifique pour les médias */
        .post-media {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
            word-wrap: break-word;
        }

        .post-card:hover {
            transform: translateY(-3px);
            border: 1px solid var(--primary-color);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .initial-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
            background-color: var(--gray-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
            color: var(--light-text);
            text-transform: uppercase;
        }

        .user-details .username {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--light-text);
        }

        .user-details .post-date {
            font-size: 0.75rem;
            color: var(--gray-text);
        }

        .more-actions-btn {
            background: none;
            border: none;
            color: var(--gray-text);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 2px;
            transition: color 0.2s ease;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .more-actions-btn:hover {
            color: var(--light-text);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: var(--gray-bg);
            border: 1px solid #333333;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            display: none;
            z-index: 10;
            min-width: 120px;
            padding: 2px 0;
        }

        .dropdown-item {
            padding: 8px 12px;
            font-size: 14px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.2s ease;
            width: 100%;
            text-align: left;
            border: 1px solid #333333;
        }


        .dropdown-item:hover {
            background-color: rgb(255, 0, 0);
            color: #fff;
        }

        .dropdown-item.delete {
            background-color: var(--gray-bg);
            border:none;
            border-radius: 4px;
            color: #fff;
        }

        .dropdown-item.delete:hover {
            background-color: rgb(255, 0, 0);
            color: #fff;
        }

        .dropdown-item.report {
            border-radius: 4px;
            color: #fff;
        }

        .dropdown-item.report:hover {
            background-color: rgb(255, 0, 0);
            color: #fff;
        }

        .report-form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            z-index: 1000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            width: 400px;
            max-width: 90%;
        }

        .report-form-container label {
            display: block;
            font-size: 0.875rem;
            margin-bottom: 5px;
        }

        .report-form-container select,
        .report-form-container textarea {
            width: 100%;
            padding: 8px;
            background-color: #1a1a1a;
            color: #ffffff;
            border: 1px solid #444;
            border-radius: 4px;
            font-size: 0.875rem;
            margin-bottom: 10px;
        }

        .report-form-container textarea {
            resize: vertical;
            min-height: 80px;
        }

        .report-form-container .btn {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .report-form-container .btn-submit {
            background-color: #e53e3e;
            color: #ffffff;
            border: none;
        }

        .report-form-container .btn-submit:hover {
            background-color: #c53030;
        }

        .report-form-container .btn-cancel {
            background-color: #6b7280;
            color: #ffffff;
            border: none;
        }

        .report-form-container .btn-cancel:hover {
            background-color: #4b5563;
        }

        .report-form-container .flex {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .post-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 0.5rem;
            transition: color 0.2s ease;
        }

        .post-title:hover {
            color: var(--primary-color);
        }

        .post-content {
            font-size: 0.9rem;
            color: var(--gray-text);
            line-height: 1.5;
            margin-bottom: 0.75rem;
        }

        .post-media img {
            border-radius: 1rem;
            margin-top: 0.5rem;
            margin-left: auto;
            margin-right: auto;
            height: 500px;
            width: 80%;
        }

        .post-media iframe {
            border-radius: 1rem;
            margin-top: 0.5rem;
            margin-left: 10%;
            margin-right: auto ;
            height: 500px;
            width: 80%; 
        }



        .poll {
            margin-top: 1rem;
        }

        .poll-question {
            font-size: 1rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 0.5rem;
        }

        .poll-option {
            position: relative;
            margin-bottom: 0.5rem;
        }

        .poll-option button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--darker-bg);
            color: var(--light-text);
            border: 1px solid #333333;
            border-radius: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            transition: background-color 0.2s ease;
        }

        .poll-option button:hover {
            background-color: var(--dark-bg);
        }

        .poll-option .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 0.5rem;
            z-index: 0;
        }

        .poll-option span {
            z-index: 1;
        }

        .post-interactions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.75rem;
            font-size: 0.85rem;
            color: var(--gray-text);
        }

        .vote-buttons {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .vote-buttons button {
            background: none;
            border: none;
            color: var(--gray-text);
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .vote-buttons button:hover {
            color: var(--light-text);
        }

        .vote-score {
            font-weight: 600;
            color: var(--light-text);
        }

        .comments-count {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--gray-text);
        }

        .comments-section {
            margin-top: 2rem;
        }

        .comments-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .comment-form {
            margin-bottom: 1.5rem;
        }

        .comment-form textarea {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--dark-bg);
            color: var(--light-text);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            resize: vertical;
        }

        .comment-form button {
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .comment-form button:hover {
            background-color: color-mix(in srgb, var(--primary-color) 80%, #000000);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .confirm-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--gray-bg);
            border: 1px solid var(--dark-bg);
            border-radius: 8px;
            padding: 20px;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            max-width: 400px;
            width: 90%;
        }

        .confirm-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }

        .confirm-modal-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--light-text);
        }

        .confirm-modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .confirm-modal-buttons button {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .confirm-modal-cancel {
            background: transparent;
            border: 1px solid var(--gray-text);
            color: var(--light-text);
        }

        .confirm-modal-confirm {
            background: #e53e3e;
            border: none;
            color: var(--light-text);
        }

        .confirm-modal-cancel:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .confirm-modal-confirm:hover {
            background: #c53030;
        }

        @media (max-width: 992px) and (min-width: 769px) {
                    .sidebar {
                width: 80px;
                z-index: 1050;
            }
            .main-content {
                margin-left: 15px;
                margin-right: 15px;
            }

            .post-media iframe {
                height: 180px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                z-index: 1050;
            }
            .main-content {
                margin-left: 15px;
                margin-right: 15px;
            }

            .content-area {
                padding: 1rem;
            }

            .post-title {
                font-size: 1.1rem;
            }

            .post-media iframe {
                height: 160px;
            }

            .comments-title {
                font-size: 1.1rem;
            }

            .comment-form button {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .post-title {
                font-size: 1rem;
            }

            .user-avatar, .initial-avatar {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .user-details .username {
                font-size: 0.85rem;
            }

            .user-details .post-date {
                font-size: 0.7rem;
            }

            .post-media iframe {
                height: 140px;
            }

            .comments-title {
                font-size: 1rem;
            }

            .comment-form textarea {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 400px) {
                    .sidebar {
                width: 40px;
                z-index: 1050;
            }
            .main-content {
                margin-left: 15px;
                margin-right: 15px;
            }

            .post-title {
                font-size: 0.9rem;
            }

            .post-content {
                font-size: 0.85rem;
            }

            .post-media iframe {
                height: 140px;
            }

            .poll-option button {
                font-size: 0.85rem;
                padding: 0.5rem;
            }
        }
         #delete-post{
            width: 100%;
         }
    </style>
</head>
<body>
    <div class="container">
        @include('components.sidebar')
        <div class="main-content">
            @include('components.header')
            <div class="content-area">
                <!-- NOUVEAU : Message de blocage affiché en haut de la page -->
                @auth
                    @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                        <div class="error-message animate__animated animate__fadeIn">
                            Vous êtes bloqué et ne pouvez pas interagir avec le contenu. Si vous avez des questions, veuillez nous contacter : 
                            <a href="mailto:businessplus@gmail.com" class="underline">businessplus@gmail.com</a>.
                        </div>
                    @endif
                @endauth 
                <a href="{{ route('forum.index') }}" class="back-link">← Retour au Forum</a>
                <div class="post-card">
                    <div class="post-header">
                        <div class="user-info">
                            @if ($post->user->avatar)
                                <img src="{{ Storage::url($post->user->avatar) }}" alt="User Avatar" class="user-avatar">
                            @elseif ($post->user->provider)
                                <img src="https://via.placeholder.com/150" alt="User Avatar" class="user-avatar">
                            @else
                                <div class="initial-avatar">{{ substr($post->user->name, 0, 1) }}</div>
                            @endif
                            <div class="user-details">
                                <span class="username">{{ $post->user->name }}</span>
                                <p class="post-date">le {{ $post->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <!-- MODIFIÉ : Suppression du message de blocage ici -->
                        @auth
                            @if (!(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active)))
                                <div class="relative">
                                    <button class="more-actions-btn" onclick="toggleDropdown('post-menu-{{ $post->id }}')">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="6" r="2" fill="currentColor"/>
                                            <circle cx="12" cy="12" r="2" fill="currentColor"/>
                                            <circle cx="12" cy="18" r="2" fill="currentColor"/>
                                        </svg>
                                    </button>
                                    <div id="post-menu-{{ $post->id }}" class="dropdown-menu">
                                        @if (Auth::id() === $post->user_id || Auth::user()->isAdminOrSuperAdmin())
                                            <form action="{{ route('post.delete', $post) }}" method="POST" class="inline-block" id="delete-post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir supprimer ce post ?', 'Supprimer')" class="dropdown-item delete">Supprimer</button>
                                            </form>
                                        @endif
                                        @if (Auth::id() !== $post->user_id)
                                            <div class="dropdown-item report" onclick="toggleReportForm('post-report-{{ $post->id }}')">Signaler</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>


                    <a href="{{ route('post.show', $post) }}" class="block">
                        <h2 class="post-title">{{ $post->title }}</h2>
                    </a>
                    @if ($post->content)
                        <p class="post-content">{{ $post->content }}</p>
                    @endif

                    <div class="post-media">
                        @if ($post->media_type === 'image')
                            <img src="{{ $post->media_url }}" alt="Media">
                        @elseif ($post->media_type === 'youtube')
                            <iframe class="w-full" src="https://www.youtube.com/embed/{{ preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $post->media_url, $matches) ? $matches[1] : (preg_match('/youtu\.be\/([^\&\?\/]+)/', $post->media_url, $matches) ? $matches[1] : '') }}" frameborder="0" allowfullscreen></iframe>
                        @elseif ($post->media_type === 'link')
                            <a href="{{ $post->media_url }}" target="_blank">{{ $post->media_url }}</a>
                        @endif
                    </div>

                    @if ($post->poll)
                        <div class="poll">
                            <h3 class="poll-question">{{ $post->poll->question }}</h3>
                            <form action="{{ route('poll.vote', $post->poll) }}" method="POST" class="space-y-2">
                                @csrf
                                @php
                                    $totalVotes = $post->poll->votes->count();
                                @endphp
                                @foreach ($post->poll->options as $option)
                                    <div class="poll-option">
                                        @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                                            <button type="button" class="disabled-btn" disabled>
                                                <span>{{ $option->option_text }}</span>
                                                <span>
                                                    {{ $option->votes->count() }} votes
                                                    @if ($totalVotes > 0)
                                                        ({{ number_format(($option->votes->count() / $totalVotes) * 100, 2) }}%)
                                                    @else
                                                        (0%)
                                                    @endif
                                                </span>
                                            </button>
                                        @else
                                            <button type="submit" name="option_id" value="{{ $option->id }}">
                                                <span>{{ $option->option_text }}</span>
                                                <span>
                                                    {{ $option->votes->count() }} votes
                                                    @if ($totalVotes > 0)
                                                        ({{ number_format(($option->votes->count() / $totalVotes) * 100, 2) }}%)
                                                    @else
                                                        (0%)
                                                    @endif
                                                </span>
                                            </button>
                                        @endif
                                        <div class="progress-bar" style="width: {{ $totalVotes > 0 ? ($option->votes->count() / $totalVotes * 100) : 0 }}%;"></div>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    @endif

                    <div class="post-interactions">
                        <div class="vote-buttons">
                            @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                                <button type="button" class="disabled-btn" disabled><i class="fas fa-arrow-up"></i></button>
                                <span class="vote-score">{{ $post->vote_score }}</span>
                                <button type="button" class="disabled-btn" disabled><i class="fas fa-arrow-down"></i></button>
                            @else
                                <form action="{{ route('post.vote', $post) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="is_upvote" value="1">
                                    <button type="submit"><i class="fas fa-arrow-up"></i></button>
                                </form>
                                <span class="vote-score">{{ $post->vote_score }}</span>
                                <form action="{{ route('post.vote', $post) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="is_upvote" value="0">
                                    <button type="submit"><i class="fas fa-arrow-down"></i></button>
                                </form>
                            @endif
                        </div>
                        <span class="comments-count">
                            <i class="far fa-comment"></i>
                            <span>{{ $post->comments->count() }} Commentaires</span>
                        </span>
                    </div>
                </div>

                <div class="comments-section">
                    <h2 class="comments-title animate__animated animate__fadeIn">Commentaires</h2>

                    @auth
                        @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                            <div class="comment-form">
                                <textarea rows="3" readonly placeholder="Vous êtes bloqué et ne pouvez pas commenter." class="cursor-not-allowed bg-[#2a2a2a] opacity-60"></textarea>
                                <button type="button" class="disabled-btn" disabled>Commenter</button>
                            </div>
                        @else
                            <div class="comment-form">
                                <form action="{{ route('post.comment', $post) }}" method="POST">
                                    @csrf
                                    <textarea name="content" rows="3" placeholder="Écrire un commentaire..." required></textarea>
                                    <button type="submit">Commenter</button>
                                </form>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-400 mb-1">Veuillez vous connecter pour commenter.</p>
                    @endauth

                    @forelse ($post->comments as $comment)
                        @include('forum.comment', ['comment' => $comment, 'level' => 0])
                    @empty
                        <p class="text-gray-400">Aucun commentaire pour le moment.</p>
                    @endforelse
                </div>
                
                    @auth
                        @if (Auth::id() !== $post->user_id && !(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active)))
                            <div id="post-report-{{ $post->id }}" class="report-form-container">
                                <form action="{{ route('report.submit', ['type' => 'post', 'id' => $post->id]) }}" method="POST">
                                    @csrf
                                    <label for="reason_category">Raison du signalement</label>
                                    <select name="reason_category" id="reason_category" required>
                                        <option value="" disabled selected>Choisir une raison</option>
                                        <option value="Contenu inapproprié">Contenu inapproprié</option>
                                        <option value="Spam">Spam</option>
                                        <option value="Harcèlement">Harcèlement</option>
                                        <option value="Informations fausses ou trompeuses">Informations fausses ou trompeuses</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                    <textarea name="reason_details" rows="2" placeholder="Expliquez la situation..." required></textarea>
                                    <div class="flex">
                                        <button type="submit" class="btn btn-submit">Envoyer</button>
                                        <button type="button" onclick="toggleReportForm('post-report-{{ $post->id }}')" class="btn btn-cancel">Annuler</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth
            </div>

        </div>
        @include('components.footer')
    </div>

    <script>
        function showConfirmation(message, onConfirm) {
            const existingDialog = document.getElementById('confirmation-dialog');
            if (existingDialog) existingDialog.remove();
            const existingBackdrop = document.getElementById('confirmation-backdrop');
            if (existingBackdrop) existingBackdrop.remove();

            const backdrop = document.createElement('div');
            backdrop.id = 'confirmation-backdrop';
            backdrop.className = 'confirm-modal-backdrop';
            document.body.appendChild(backdrop);

            const dialog = document.createElement('div');
            dialog.id = 'confirmation-dialog';
            dialog.className = 'confirm-modal';

            const title = document.createElement('div');
            title.className = 'confirm-modal-title';
            title.textContent = 'Confirmation';
            dialog.appendChild(title);

            const messageDiv = document.createElement('p');
            messageDiv.textContent = message;
            messageDiv.style.marginBottom = '20px';
            messageDiv.style.textAlign = 'center';
            dialog.appendChild(messageDiv);

            const buttonsDiv = document.createElement('div');
            buttonsDiv.className = 'confirm-modal-buttons';

            const confirmBtn = document.createElement('button');
            confirmBtn.textContent = 'Confirmer';
            confirmBtn.className = 'confirm-modal-confirm';
            confirmBtn.onclick = () => {
                onConfirm();
                dialog.remove();
                backdrop.remove();
            };
            buttonsDiv.appendChild(confirmBtn);

            const cancelBtn = document.createElement('button');
            cancelBtn.textContent = 'Annuler';
            cancelBtn.className = 'confirm-modal-cancel';
            cancelBtn.onclick = () => {
                dialog.remove();
                backdrop.remove();
            };
            buttonsDiv.appendChild(cancelBtn);

            dialog.appendChild(buttonsDiv);
            document.body.appendChild(dialog);
        }

        function confirmAction(event, form, message, actionText) {
            event.preventDefault();
            showConfirmation(message, () => {
                form.submit();
            });
        }

        function toggleReplyForm(commentId) {
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.classList.toggle('hidden');
        }

        function toggleReplies(commentId) {
            const repliesDiv = document.getElementById(`replies-${commentId}`);
            const toggleButton = document.getElementById(`toggle-replies-${commentId}`);
            repliesDiv.classList.toggle('hidden');
            toggleButton.classList.toggle('text-blue-400');
            toggleButton.classList.toggle('text-blue-600');
        }

        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            document.querySelectorAll('.dropdown-menu').forEach(d => {
                if (d.id !== menuId && d.style.display === 'block') {
                    d.style.display = 'none';
                }
            });
            document.querySelectorAll('.report-form-container').forEach(form => {
                if (form.style.display === 'block') {
                    form.style.display = 'none';
                }
            });
        }

        function toggleReportForm(formId) {
            const form = document.getElementById(formId);
            const isVisible = form.style.display === 'block';
            form.style.display = isVisible ? 'none' : 'block';
            if (!isVisible) {
                document.querySelectorAll('.dropdown-menu').forEach(d => {
                    d.style.display = 'none';
                });
            }
        }

        function updateBlockedUserInteractions() {
            @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                document.querySelectorAll('.vote-buttons button').forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('disabled-btn');
                });

                document.querySelectorAll('.poll-option button').forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('disabled-btn');
                });

                const commentForm = document.querySelector('.comment-form');
                if (commentForm) {
                    const textarea = commentForm.querySelector('textarea');
                    const button = commentForm.querySelector('button');
                    if (textarea) {
                        textarea.readOnly = true;
                        textarea.classList.add('cursor-not-allowed', 'bg-[#2a2a2a]', 'opacity-60');
                    }
                    if (button) {
                        button.disabled = true;
                        button.classList.add('disabled-btn');
                    }
                }
            @endif
        }

        document.addEventListener('DOMContentLoaded', updateBlockedUserInteractions);

        document.addEventListener('click', function(event) {
            const clickedInMenu = event.target.closest('.more-actions-btn') || event.target.closest('.dropdown-menu');
            const clickedInForm = event.target.closest('.report-form-container');
            if (!clickedInMenu && !clickedInForm) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
                document.querySelectorAll('.report-form-container').forEach(form => {
                    form.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>