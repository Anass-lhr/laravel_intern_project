<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BUSINESS+ : Découvrez les épisodes exclusifs du podcast The Diary Of A CEO.">
    <meta name="keywords" content="business, podcasts, The Diary Of A CEO, Spotify, stratégies digitales">
    <title>BUSINESS+Talk - Épisodes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-teal': '#00B7C3',
                        'primary-black': '#0F0F0F',
                        'dark-gray': '#1A1A1A',
                        'medium-gray': '#333333',
                        'light-gray': '#CCCCCC',
                        'accent-white': '#FFFFFF',
                        'accent-red': '#E50914',
                        'cyan-glow': '#00CED1',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'pulse-slow': 'pulse 1.8s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 4s ease-in-out infinite'
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-15px)' } },
                        pulse: { '0%, 100%': { opacity: 1, transform: 'scale(1)' }, '50%': { opacity: .6, transform: 'scale(1.1)' } }
                    }
                }
            }
        }
    </script>
<style>
    /* Variables CSS unifiées pour les couleurs */
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

    /* Réinitialisation des styles */
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

    /* Style du conteneur principal pour ajuster avec la sidebar */
    .container-main {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        position: relative;
        z-index: 1;
    }
    .sidebar {
    z-index: 1000; /* Augmenter le z-index de la sidebar */
    position: fixed; /* S'assurer qu'elle est fixe */
}

    .main-content {
        flex: 1;
        margin-left: 280px;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        transition: margin-left 0.3s ease;
        min-height: calc(100vh - 70px - 100px); /* Ajuster pour header (70px) et footer (est. 100px) */
    }

    /* Styles du contenu principal */
    .content-area {
        padding: 2rem;
        flex: 1;
    }

    .error-message {
        color: #e53e3e;
        text-align: center;
        padding: 1rem;
        font-size: 1rem;
        border-radius: 0.5rem;
        background-color: rgba(229, 62, 62, 0.2);
        border: 1px solid #e53e3e;
        margin-bottom: 1rem;
    }

    /* Titre des épisodes */
    .podcast-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--light-text);
        text-align: center;
        margin-bottom: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

    /* Grille des épisodes */
    .episodes-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

   .episode-card {
    background-color: var(--gray-bg);
    border-radius: 0.75rem;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    z-index: 1; /* Plus bas que la sidebar */
}

    .episode-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        border-color: var(--primary-color);
    }

    .episode-image-container {
        position: relative;
        padding-top: 56.25%;
        width: 100%;
    }

    .episode-image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .episode-card-content {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .episode-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--light-text);
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .description-container {
        position: relative;
        flex-grow: 1;
    }

    .description-text {
        color: var(--gray-text);
        font-size: 0.9rem;
        line-height: 1.6;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .description-text.collapsed {
        max-height: 3.6rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .description-text.expanded {
        max-height: none;
        display: block;
    }

    .toggle-btn {
        background: none;
        border: none;
        color: var(--gray-text);
        cursor: pointer;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        padding: 0;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .toggle-btn:hover {
        color: var(--primary-color);
    }

    .toggle-btn::before {
        content: '...';
        color: var(--gray-text);
        margin-right: 0.25rem;
    }

    .toggle-btn.expanded::before {
        content: '';
        margin-right: 0;
    }

    .spotify-player-container {
        width: 100%;
        max-height: 120px;
        margin-top: auto;
    }

   .spotify-player-container iframe {
    width: 100%;
    height: 120px;
    border-radius: 0.5rem;
    position: relative;
    z-index: 1; /* Assurer que les vidéos restent en dessous de la sidebar */
}

    /* Boutons harmonisés */
    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: var(--light-text);
        border: none;
    }

    .btn-primary:hover {
        background-color: color-mix(in srgb, var(--primary-color) 80%, #000000);
        transform: translateY(-2px);
    }

    /* Animation personnalisée */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Styles responsifs */
    @media (min-width: 769px) and (max-width: 992px) {
        .main-content {
            margin-left: 10px;
            margin-right: 10px;
            padding: 1.5rem;
        }

        .episodes-container {
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        }

        .episode-card img {
            height: 170px;
        }

        .spotify-player-container iframe {
            height: 150px;
        }
    }

    @media (min-width: 577px) and (max-width: 768px) {
    
        .episode-card img {
            height: 160px;
        }

        .spotify-player-container iframe {
            height: 140px;
        }

        .episode-card-title {
            font-size: 1.05rem;
        }

        .description-text {
            font-size: 0.85rem;
        }
        .main-content {
        margin-left: 0; /* Remove left margin since sidebar is at the bottom */
        margin-right: 10px;
        padding: 1rem;
        padding-bottom: 60px; /* Ensure content clears the sidebar */
    }

    .content-area {
        padding: 1rem;
        padding-bottom: 60px; /* Ensure episode cards clear the sidebar */
    }

    .episodes-container {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        padding-bottom: 60px; /* Additional padding to avoid overlap */
    }

    .spotify-player-container {
        margin-bottom: 60px; /* Ensure the Spotify player doesn’t overlap with the sidebar */
    }
    }

    @media (min-width: 401px) and (max-width: 576px) {
        .main-content {
            margin-left: 10px;
            margin-right: 10px;
            padding: 0.75rem;
        }

        .episodes-container {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .episode-card img {
            height: 140px;
        }

        .spotify-player-container iframe {
            height: 130px;
        }

        .episode-card-title {
            font-size: 1rem;
        }

        .description-text {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 400px) {
        .main-content {
            margin-left: 10px;
            margin-right: 10px;
            padding: 0.5rem;
        }

        .episodes-container {
            grid-template-columns: 1fr;
        }

        .episode-card img {
            height: 120px;
        }

        .spotify-player-container iframe {
            height: 120px;
        }

        .episode-card-title {
            font-size: 0.9rem;
        }

        .description-text {
            font-size: 0.8rem;
        }

        .toggle-btn {
            font-size: 0.75rem;
        }

        .error-message {
            font-size: 0.8rem;
            padding: 0.75rem;
        }
    }
</style>
</head>
<body class="bg-primary-black text-light-gray font-sans">
    <div class="container-main">
        <!-- Inclusion de la sidebar -->
        @include('components.sidebar')

        <!-- Contenu principal -->
        <div class="main-content">
            <!-- Inclusion du header -->
            @include('components.header')

            <!-- Zone de contenu -->
            <div class="content-area">
                <h2 class="text-3xl md:text-4xl font-bold mb-16 text-center text-accent-white animate__animated animate__fadeIn"> Nos Episodes</h2>
                @if (isset($error))
                    <div class="error-message">
                        {{ $error }}
                        <button onclick="window.location.reload()" class="btn btn-primary mt-4">Réessayer</button>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="episodes-container">
                        @foreach ($episodes as $episode)
                            <div class="episode-card">
                                <div class="episode-image-container">
                                    <img src="{{ $episode->images[0]->url ?? 'https://via.placeholder.com/320x180?text=Image+Indisponible' }}"
                                         alt="{{ $episode->name }}">
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="flex items-center mb-3">
                                        <span class="bg-primary-teal/20 text-primary-teal text-xs px-3 py-1 rounded-full mr-2 font-semibold">PODCAST</span>
                                    </div>
                                    <h3 class="text-lg font-semibold mb-3 text-accent-white line-clamp-2">{{ $episode->name }}</h3>
                                    <div class="description-container mb-4">
                                        <p id="description-text-{{ $episode->id }}" class="description-text collapsed text-sm text-gray-300">
                                            {{ Str::limit(strip_tags($episode->description), 150) }}
                                        </p>
                                        <button id="toggle-description-{{ $episode->id }}"
                                                class="toggle-btn"
                                                onclick="toggleDescription('{{ $episode->id }}')">VOIR PLUS</button>
                                    </div>
                                    <div class="spotify-player-container mt-auto">
                                        <iframe src="https://open.spotify.com/embed/episode/{{ $episode->id }}?theme=0"
                                                frameborder="0"
                                                allowtransparency="true"
                                                allow="encrypted-media"></iframe>
                                    </div>
                                    <a href="{{ $episode->external_urls->spotify }}"
                                       target="_blank"
                                       class="btn btn-primary mt-4 text-center">
                                        Écouter sur Spotify
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (empty($episodes))
                        <div class="error-message">
                            Aucun épisode disponible pour le moment.
                            <button onclick="window.location.reload()" class="btn btn-primary mt-4">Réessayer</button>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Inclusion du footer -->
        @include('components.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.sidebar-menu a');
            const authButtons = document.querySelector('.auth-buttons');
            const userProfile = document.querySelector('.user-profile');
            const userAvatar = document.querySelector('.user-avatar');
            const userName = document.querySelector('.user-name');
            const searchInput = document.querySelector('.search-input');

            // Vérifier si l'utilisateur est connecté
            const isLoggedIn = <?php echo auth()->check() ? 'true' : 'false'; ?>;

            // Mettre à jour l'en-tête en fonction de l'état de connexion
            function updateHeader() {
                if (isLoggedIn) {
                    authButtons.classList.add('hidden');
                    userProfile.classList.remove('hidden');
                    <?php if (auth()->check()): ?>
                        @if (auth()->user()->avatar)
                            if (userAvatar) {
                                userAvatar.src = '<?php echo Storage::url(auth()->user()->avatar); ?>';
                            }
                        @elseif (auth()->user()->provider)
                            if (userAvatar) {
                                userAvatar.src = 'https://via.placeholder.com/150';
                            }
                        @endif
                        userName.textContent = '<?php echo auth()->user()->name; ?>';
                    <?php endif; ?>
                } else {
                    authButtons.classList.remove('hidden');
                    userProfile.classList.add('hidden');
                }
            }

            // Rediriger vers la page de profil lors du clic sur l'avatar ou le nom
            userProfile.addEventListener('click', function(e) {
                if (isLoggedIn) {
                    window.location.href = '/profile';
                }
            });

            // État initial de l'en-tête
            updateHeader();

            // Navigation dans la barre latérale
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navItems.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Gestion de la barre de recherche
            searchInput.addEventListener('input', function() {
                console.log('Recherche :', this.value);
            });
        });

        function toggleDescription(episodeId) {
            const descriptionText = document.getElementById(`description-text-${episodeId}`);
            const toggleBtn = document.getElementById(`toggle-description-${episodeId}`);
            const isCollapsed = descriptionText.classList.contains('collapsed');

            if (isCollapsed) {
                descriptionText.classList.remove('collapsed');
                descriptionText.classList.add('expanded');
                toggleBtn.classList.add('expanded');
                toggleBtn.textContent = 'AFFICHER MOINS';
            } else {
                descriptionText.classList.remove('expanded');
                descriptionText.classList.add('collapsed');
                toggleBtn.classList.remove('expanded');
                toggleBtn.textContent = 'VOIR PLUS';
            }
        }
        
    </script>
</body>
</html>