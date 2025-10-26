<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Business+ Talk</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS pour les couleurs et thèmes */
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

        /* Réinitialisation des marges et styles de base */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
/* Réinitialisation globale */
/* Réinitialisation globale */
html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    box-sizing: border-box;
}
      /* Assurer que le body et le container occupent toute la largeur */
body {
    background-color: var(--darker-bg);
    color: var(--light-text);
}

/* Conteneur principal */
.container {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    background-color: var(--dark-bg);
}

        /* Style global pour les images */
        img {
            max-width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }
        /* Ajuster la sidebar pour éviter les débordements */
/* Sidebar */
.sidebar {
    width: 280px; /* Valeur fixe pour la sidebar, mais ajustable en responsive */
    position: fixed;
    height: 100vh;
    top: 0;
    left: 0;
    z-index: 1000;
    background-color: var(--darker-bg);
}

        /* Conteneur du logo dans la barre latérale */
        .logo-container {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255255255 / 10%);
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Logo de la barre latérale */
        .logo {
            max-width: 200px;
            height: auto;
            margin: 0 auto;
        }

        /* Menu de la barre latérale */
        .sidebar-menu {
            flex-grow: 1;
            list-style: none;
            padding: 0 0.75rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.75rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--gray-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu a:hover {
            color: var(--light-text);
            background-color: color-mix(in srgb, var(--primary-color) 15%, transparent);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar-menu a.active {
            color: var(--light-text);
            border-left: 4px solid var(--primary-color);
            background: linear-gradient(90deg, var(--primary-color), rgba(0, 0, 0, 0.1));
            transform: scale(1.03);
            border-radius: 0.75rem;
        }

        .sidebar-menu a i {
            color: var(--light-text);
            margin-right: 1rem;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .sidebar-menu a:hover i {
            transform: scale(1.2);
        }

       

      /* Ajuster main-content pour occuper l'espace restant */
/* Contenu principal */
.main-content {
    margin-left: 280px; /* Décalage fixe pour la sidebar */
    width: calc(100vw - 280px); /* Utilise la largeur de la fenêtre viewport */
    min-height: 100vh;
    padding: 0;
    display: flex;
    flex-direction: column;
    transition: margin-left 0.3s ease;
    background-color: var(--dark-bg);
}

/* Zone de contenu */
.content-area {
    padding: 2rem;
    flex: 1;
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
}

        .section {
            margin-bottom: 3rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--light-text);
            margin-top:10px;
            border-bottom: 5px solid var(--primary-color);
            padding-bottom: 0.25rem;
            border-radius: 0.25rem;
        }

        .view-all {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        /* Grille de podcasts */
        .podcast-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .podcast-card {
            background-color: var(--gray-bg);
            border-radius: 0.75rem;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .podcast-card:hover {
            transform: translateY(-5px);
        }

        .podcast-title-wrapper {
            padding: 0.5rem;
        }

        /* Vignette de podcast */
        .podcast-thumbnail {
            position: relative;
            padding-top: 56.25%;
            width: 100%;
            max-width: 400px;
        }

        .podcast-thumbnail img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .podcast-thumbnail:hover .play-button {
            background-color: var(--primary-color);
        }

        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--primary-color);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .podcast-thumbnail:hover .play-button {
            opacity: 1;
        }

        .podcast-duration {
            position: absolute;
            bottom: 0.5rem;
            right: 0.5rem;
            background-color: rgba(0, 0, 0, 0.75);
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .podcast-info {
            padding: 1rem;
        }

        .podcast-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .podcast-meta {
            display: flex;
            align-items: center;
            color: var(--gray-text);
            font-size: 0.75rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .podcast-meta span {
            display: flex;
            align-items: center;
            margin-right: 0.75rem;
        }

        .podcast-meta i {
            margin-right: 0.25rem;
        }

        /* Section héro */
        .hero {
            background-color: var(--gray-bg);
            border-radius: 0.75rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            padding: 0;
            height: 40vh;
            min-height: 300px;
            max-height: 500px;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-content {
            position: relative;
            padding: 1rem;
        }

        /* Liste d'articles */
        .article-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .article-card {
            background-color: var(--gray-bg);
            border-radius: 0.75rem;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .article-card:hover {
            transform: translateY(-5px);
        }

        .article-thumbnail {
            position: relative;
            padding-top: 56.25%;
            width: 100%;
            max-width: 400px;
        }

        .article-thumbnail img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-info {
            padding: 1rem;
        }

        .article-tag {
            display: inline-block;
            background-color: rgba(30, 181, 173, 0.1);
            color: var(--primary-color);
            border-radius: 0.25rem;
            padding: 0.125rem 0.5rem;
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .article-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .article-excerpt {
            font-size: 0.875rem;
            color: var(--gray-text);
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .article-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--gray-text);
            font-size: 0.75rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* Assurer que le contenu interne ne déborde pas */


        .chat-box .message {
            margin: 10px 8px;
            padding: 12px 16px;
            border-radius: 20px;
            max-width: 75%;
            word-wrap: break-word;
            line-height: 1.5;
        }

        .chat-box .user {
            background-color: var(--primary-color);
            color: var(--light-text);
            margin-left: auto;
            text-align: right;
        }

        .chat-box .bot {
            background-color: var(--gray-text);
            color: #000000;
            margin-right: auto;
            text-align: left;
        }

        .chat-box::-webkit-scrollbar {
            width: 6px;
        }

        .chat-box::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-box::-webkit-scrollbar-thumb {
            background: var(--gray-text);
            border-radius: 3px;
        }

        .chat-box::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
       /* Ajuster le conteneur du chatbot */

/* Chatbot */
#chat-container {
    position: fixed;
    bottom: 24px; /* Aligné avec l'image */
    right: 4px; /* Aligné avec l'image */
    width: 100%;
    height: 500px; /* Hauteur totale comme dans l'image */
    max-width: 400px; /* Largeur maximale comme dans l'image */
    background-color: var(--dark-bg);
    border-radius: 16px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    padding: 16px;
    transform: translateX(0);
    transition: all 0.3s ease-in-out;
    z-index: 1002;
    overflow-y: auto;
    box-sizing: border-box;
}

#chat-container.hidden {
    transform: translateX(100%);
}

.chat-box {
    height: 330px; /* Hauteur ajustée pour laisser de l'espace aux boutons et input */
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--gray-text) transparent;
}

.suggestion-container {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.suggestion-row {
    display: flex;
    gap: 0.5rem;
    flex-wrap: nowrap;
}

.predefined-btn {
    flex: 1 1 calc(50% - 0.25rem);
    padding: 0.5rem 1rem;
    text-align: center;
    white-space: nowrap;
    background-color: var(--primary-color);
    color: var(--light-text);
    border: none;
    border-radius: 0.5rem;
    transition: background-color 0.3s ease, transform 0.2s ease;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
}

.predefined-btn:hover {
    background-color: color-mix(in srgb, var(--primary-color) 80%, #ffffff);
}

/* Ajustements responsifs */
@media (max-width: 768px) {
    #chat-container {
        width: calc(100vw - 2.5rem);
        height: 500px;
        right: 1.25rem;
        bottom: 5rem;
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    #chat-container {
        width: calc(100vw - 1.5rem);
        height: 500px;
        right: 0.75rem;
        bottom: 4rem;
    }
}

@media (max-width: 400px) {
    #chat-container {
        width: calc(100vw - 1rem);
        height: 500px;
        right: 0.5rem;
        bottom: 3.5rem;
    }
}
#chat-container.hidden {
    transform: translateX(100%);
}
#chat-toggle {
    position: fixed;
    bottom: 24px;
    right: 24px; /* Ajustez si nécessaire */
    width: 64px;
    height: 64px;
    background-color: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease-in-out;
    z-index: 1001;
}

        /* Ajustements responsifs */
        @media (max-width: 992px) and (min-width: 769px) {
            .contact-button:hover,
    .register-button:hover {
        transform: translateY(-2px);
    }

    .contact-button span,
    .register-button span {
        visibility: visible;
    }

    .contact-button::before,
    .register-button::before {
        content: none;
    }
            .main-content {
                margin-left: 80px;
            }

            .sidebar {
                width: 80px;
                padding: 1.5rem 0;
            }

            .logo-container {
                display: none;
            }

            .sidebar-menu a span {
                display: none;
            }

            .sidebar-menu a {
                padding: 1rem;
                justify-content: center;
            }

            .sidebar-menu a i {
                margin-right: 0;
                font-size: 1.75rem;
            }

            .hero {
                height: 35vh;
                min-height: 250px;
            }

            .podcast-grid, .article-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }

            .podcast-thumbnail, .article-thumbnail {
                max-width: 300px;
            }

            #chat-container {
                max-width: 100px;
                height:70%; /* Ajuste la hauteur maximale */
            }
        }

       /* Médias queries */
@media (max-width: 768px) {
    .button-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .contact-button span,
    .register-button span {
        visibility: hidden; /* Masque le texte original */
    }

    .contact-button::before {
        content: "Connexion";
        visibility: visible;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
    }

    .register-button::before {
        content: "Inscription";
        visibility: visible;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
    }

    .contact-button,
    .register-button {
        min-width: 150px; /* Appliquer la même largeur minimale en mode responsive */
    }
 .sidebar {
        width: 100%;
        height: 60px;
        bottom: 0;
        left: 0;
        top: auto;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }

   .main-content {
        margin-left: 0;
        margin-bottom: 60px;
        width: 100vw; /* Pleine largeur en mode mobile */
    }

  #chat-container {
        width: calc(100vw - 2.5rem); /* Ajuste en fonction de la viewport */
        height:70%; /* Hauteur fixe pour le conteneur du chatbot */
        right: 1.25rem;
        bottom: 5rem;
        max-width: 100%; /* Supprime la limite max-width en mode mobile */
    }
}

        @media (max-width: 576px) {
        #chat-container {
        width: calc(100vw - 1.5rem);
         height:70%;
        right: 0.75rem;
        bottom: 4rem;
    }
            .content-area {
                padding: 1rem;
            }

            .hero {
                height: 25vh;
                min-height: 150px;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .podcast-grid, .article-list {
                grid-template-columns: 1fr;
            }

            .podcast-card, .article-card {
                max-width: 100%;
            }

            #chat-container {
                width: calc(100% - 1.5rem);
                 height:70%;
                right: 0.75rem;
                bottom: 4rem;
            }
        }

        @media (max-width: 400px) {
          #chat-container {
        width: calc(100vw - 1rem);
         height:70%;
        right: 0.5rem;
        bottom: 3.5rem;
    }
            .sidebar {
                height: 50px;
                padding: 0.5rem 0;
            }

            .sidebar-menu a {
                padding: 0.5rem;
            }

            .sidebar-menu a i {
                font-size: 1.25rem;
            }

            .main-content {
                margin-left: 0;
                margin-bottom: 50px;
            }

            .podcast-meta span, .article-meta span {
                font-size: 0.65rem;
            }

            .hero {
                height: 20vh;
                min-height: 120px;
            }

            #chat-container {
                width: calc(100% - 1rem);
                 height:70%;
                right: 0.5rem;
                bottom: 3.5rem;
            }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .hero-particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .hero-particle:nth-child(1) { width: 20px; height: 20px; top: 15%; left: 10%; animation-delay: 0s; }
        .hero-particle:nth-child(2) { width: 15px; height: 15px; top: 70%; left: 85%; animation-delay: 1.5s; }
        .hero-particle:nth-child(3) { width: 25px; height: 25px; top: 40%; left: 60%; animation-delay: 3s; }
        .hero-particle:nth-child(4) { width: 12px; height: 12px; top: 85%; left: 25%; animation-delay: 4.5s; }

        /* Nouveaux styles pour les sections dynamiques */
        .episode-scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 1.5rem;
            padding: 1rem 0;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-x;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .episode-scroll-container::-webkit-scrollbar {
            display: none;
        }

        .episode-scroll-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .podcast-card, .article-card {
            flex: 0 0 300px;
            background-color: var(--gray-bg);
            border-radius: 0.75rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            box-shadow: 0 8px 16px var(--gray-bg);
        }

        .podcast-card:hover, .article-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px var(--primary-color);
            background-color: rgba(30, 181, 173, 0.05);
        }

        .podcast-title-wrapper, .article-title-wrapper {
            padding: 0.5rem;
        }

        .podcast-title, .article-title {
            color: var(--light-text);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            text-decoration: none;
        }

        .podcast-info, .article-info {
            padding: 1rem;
        }

        .podcast-meta, .article-meta {
            display: flex;
            align-items: center;
            color: var(--light-text);
            font-size: 0.8rem;
            gap: 0.75rem;
        }

        .podcast-meta span, .article-meta span {
            display: flex;
            align-items: center;
        }

        .podcast-meta i, .article-meta i {
            margin-right: 0.3rem;
            color: var(--primary-color);
        }

        .error-message {
            color: #ff5555;
            text-align: center;
            padding: 1rem;
            background-color: rgba(255, 85, 85, 0.1);
            border-radius: 0.5rem;
        }

        /* Ajustements responsifs pour les nouvelles cartes */
        @media (max-width: 992px) and (min-width: 769px) {
            .podcast-card, .article-card {
                flex: 0 0 250px;
            }
        }

        @media (max-width: 768px) {
            .podcast-card, .article-card {
                flex: 0 0 250px;
            }
        }

        @media (max-width: 576px) {
            .podcast-card, .article-card {
                flex: 0 0 220px;
            }
        }
       .hero-button {
    display: inline-block;
    padding: 0.75rem 1.5rem; /* Uniformiser le padding */
    border-radius: 0.25rem;
    text-decoration: none;
    font-weight: 500;
    transition: transform 0.2s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
    min-width: 150px; /* Largeur minimale identique */
    text-align: center; /* Centrer le texte */
}
.contact-button {
    background-color: var(--primary-color);
    color: #ffffff;
    margin-right: 1rem;
}

.register-button {
    background-color: #ffffff;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.contact-button span,
.register-button span {
    display: block;
}
 
   
    </style>
</head>
    <body>
        <div class="container">
            <!-- Inclusion de la barre latérale -->
            @include('components.sidebar')

            <!-- Contenu principal -->
            <div class="main-content">
                <!-- Inclusion de l'en-tête -->
                @include('components.header')

                <!-- Zone de contenu -->
                <div class="content-area">
                    <!-- Section héro -->
                    <div class="hero" style="position: relative; overflow: hidden; background: linear-gradient(45deg, #000000 0%, #4a4a4a 50%, var(--primary-color) 100%); background-size: 200%; animation: gradientShift 12s ease infinite; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                        <!-- Particle Effects -->
                        <div class="hero-particle"></div>
                        <div class="hero-particle"></div>
                        <div class="hero-particle"></div>
                        <div class="hero-particle"></div>
                        <!-- Hero Content -->
                        <div class="hero-content" style="position: relative; z-index: 1; color: #ffffff; padding: 2rem; text-align: center; display: flex; flex-direction: column; justify-content: center;">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);"><kbd>KNOW MORE , SHARE MORE</kbd></h1>
        <br>
        <div class="button-group">
            <a href="/contact" class="hero-button contact-button" style="background-color: var(--primary-color); color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 0.25rem; text-decoration: none; font-weight: 500; margin-right: 1rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); transition: transform 0.2s ease;"><span>Contactez-nous</span></a>
            @guest
                <a href="/register" class="hero-button register-button" style="background-color: #ffffff; color: var(--primary-color); padding: 0.75rem 1.5rem; border: 2px solid var(--primary-color); border-radius: 0.25rem; text-decoration: none; font-weight: 500; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); transition: transform 0.2s ease;"><span>s'inscrire</span></a>
            @endguest
        </div>
    </div>
                    </div>

                    <!-- Podcasts en vedette -->
                    <div class="section">
                        <div class="section-header">
                            <h2 class="section-title" >Podcasts</h2>
                            <a href="/podcasts" class="view-all">Voir tout <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="episode-scroll-container" id="podcast-scroll">
                            @if (isset($videos['error']))
                                <div class="error-message">
                                    {{ $videos['error'] }}
                                    <button onclick="window.location.reload()" class="btn btn-primary mt-4">Réessayer</button>
                                </div>
                            @else
                                @forelse ($videos as $video)
                                    <a href="/podcasts?videoId={{ $video['videoId'] }}&title={{ urlencode($video['title']) }}&description={{ urlencode($video['description']) }}&publishedAt={{ $video['publishedAt'] }}"
                                    class="podcast-card episode-card block no-underline" style="text-decoration: none;" aria-label="Écouter le podcast {{ $video['title'] }}">
                                        <div class="podcast-thumbnail">
                                            <img src="{{ $video['thumbnail'] }}" alt="Vignette du podcast {{ $video['title'] }}">
                                        </div>
                                        <div class="podcast-info">
                                            <div class="podcast-title-wrapper">
                                                <h3 class="podcast-title">{{ Str::limit($video['title'], 100) }}</h3>
                                            </div>
                                            <div class="podcast-meta">
                                                <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($video['publishedAt'])->translatedFormat('j M Y') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="error-message">
                                        Aucun podcast disponible pour le moment.
                                        <button onclick="window.location.reload()" class="btn btn-primary mt-4">Réessayer</button>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>

                    <!-- Derniers épisodes -->
                    <div class="section">
                        <div class="section-header">
                            <h2 class="section-title"> Épisodes</h2>
                            <a href="{{ route('episodes.index') }}" class="view-all">Voir tout <i class="fas fa-arrow-right"></i></a>
                        </div>
                        @if (isset($error))
                            <div class="error-message">
                                {{ $error }}
                                <button onclick="window.location.reload()" class="btn btn-primary mt-4">Réessayer</button>
                            </div>
                        @else
                            <div class="episode-scroll-container" id="episode-scroll">
                                @forelse ($episodes as $episode)
                                    <a href="/episodes?selected_episode_id={{ $episode->id }}" class="podcast-card episode-card block no-underline" style="text-decoration: none;" aria-label="Écouter l'épisode {{ $episode->name }}">
                                        <div class="podcast-thumbnail">
                                            <img src="{{ $episode->images[0]->url ?? 'https://via.placeholder.com/400x225?text=Image+Indisponible' }}"
                                                alt="Vignette de l'épisode {{ $episode->name }}">
                                        </div>
                                        <div class="podcast-info">
                                            <div class="podcast-title-wrapper">
                                                <h3 class="podcast-title">{{ Str::limit($episode->name, 100) }}</h3>
                                            </div>
                                            <div class="podcast-meta">
                                                <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($episode->release_date)->translatedFormat('j M Y') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="error-message">
                                        Aucun épisode disponible pour le moment.
                                        <button onclick="window.location.reload()" class="btn btn-primary mt-4">Réessayer</button>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>

                    <!-- Articles en vedette -->
                    @if ($articles->isNotEmpty())
                        <div class="section">
                            <div class="section-header">
                                <h2 class="section-title">Articles</h2>
                                <a href="{{ route('articles.index') }}" class="view-all">Voir tout <i class="fas fa-arrow-right"></i></a>
                            </div>
                            <div class="episode-scroll-container" id="article-scroll">
                                @foreach ($articles as $article)
                                    <a href="{{ route('articles.show', $article->id) }}" class="podcast-card episode-card block no-underline" aria-label="Lire l'article {{ $article->titre }}">
                                        <div class="article-thumbnail">
                                            <img src="{{ $article->image ?? 'https://via.placeholder.com/400x225?text=Image+Indisponible' }}"
                                                alt="Vignette de l'article {{ $article->titre }}">
                                        </div>
                                        <div class="article-info">
                                            <span class="article-tag">
 @php
                                            $firstCategory = '';
                                            if (isset($article->categorie)) {
                                                if (is_array($article->categorie) && count($article->categorie) > 0) {
                                                    $firstCategory = $article->categorie[0];
                                                } elseif (is_string($article->categorie) && substr($article->categorie, 0, 1) === '[') {
                                                    $tempCategories = json_decode($article->categorie, true) ?: [];
                                                    if (count($tempCategories) > 0) {
                                                        $firstCategory = $tempCategories[0];
                                                    }
                                                } elseif (is_string($article->categorie) && !empty($article->categorie)) {
                                                    $firstCategory = $article->categorie;
                                                }
                                            }
                                            $firstCategory = trim($firstCategory, '"\'');
                                        @endphp
                                        {{ $firstCategory ? strtoupper($firstCategory) : 'N/A' }}                                            </span>
                                            <div class="article-title-wrapper">
                                                <h3 class="article-title">{{ Str::limit($article->titre, 60) }}</h3>
                                            </div>
                                            <p class="article-excerpt">{{ Str::limit($article->description, 100) }}</p>
                                            <div class="article-meta">
                                                <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('j M Y') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Chatbot toggle button -->
<!-- Chatbot toggle button -->
<div id="chat-toggle" class="fixed bottom-6 right-6 w-16 h-16 bg-[var(--primary-color)] rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:bg-[var(--gray-text)] transition duration-300 ease-in-out z-[1002]">
    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12z"/>
    </svg>
</div>

<!-- Chatbot container -->
<main id="chat-container" class="hidden fixed bottom-24 right-4 w-full max-w-md bg-[var(--dark-bg)] rounded-2xl shadow-2xl p-6 transform transition-all duration-300 ease-in-out md:max-w-lg z-[1002]">    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-[var(--light-text)]">Business, Entrepreneuriat, Finance & Économie</h2>
        <button id="close-chat" class="text-[var(--gray-text)] hover:text-[var(--light-text)]">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
            </svg>
        </button>
    </div>
    <div class="chat-box h-[250px] overflow-y-auto mb-4 bg-[var(--darker-bg)] rounded-lg p-4" id="chat-box">
        <div class="flex items-start space-x-3 mb-4">
            <div class="w-10 h-10 bg-[var(--primary-color)] rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-[var(--light-text)]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
            </div>
            <div>
                <p class="text-[var(--light-text)] font-medium">Bonjour, je suis votre assistant !</p>
                <p class="text-[var(--gray-text)] text-sm">Je peux vous aider avec des questions sur le business, l'entrepreneuriat, la finance et l'économie. Comment puis-je vous aider aujourd'hui ?</p>
            </div>
        </div>
    </div>
    <div class="suggestion-container mb-4">
        <div class="suggestion-row">
            <button class="predefined-btn bg-[var(--primary-color)] text-[var(--light-text)] px-4 py-2 rounded-full transition text-sm font-medium" data-question="Créer un business plan">Créer un business plan</button>
            <button class="predefined-btn bg-[var(--primary-color)] text-[var(--light-text)] px-4 py-2 rounded-full transition text-sm font-medium" data-question="Gérer mes finances">Gérer mes finances</button>
        </div>
        <div class="suggestion-row">
            <button class="predefined-btn bg-[var(--primary-color)] text-[var(--light-text)] px-4 py-2 rounded-full transition text-sm font-medium" data-question="Trouver des investisseurs">Trouver des investisseurs</button>
            <button class="predefined-btn bg-[var(--primary-color)] text-[var(--light-text)] px-4 py-2 rounded-full transition text-sm font-medium" data-question="Autre chose...">Autre chose...</button>
        </div>
    </div>
    <div class="flex gap-3">
        <input type="text" id="question" placeholder="Posez votre question sur le business, la finance ou l'économie..." class="flex-1 p-3 bg-[var(--gray-bg)] border border-gray-600 rounded-lg text-[var(--light-text)] placeholder-[var(--gray-text)] focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] transition duration-300 ease-in-out">
        <button id="send-button" class="bg-[var(--primary-color)] text-[var(--light-text)] px-6 py-3 rounded-lg hover:bg-[var(--gray-text)] transition duration-300 ease-in-out font-semibold">Envoyer</button>
    </div>
</main>

<!-- Inclusion du pied de page -->
@include('components.footer')
</div>

<script>
jQuery.noConflict();
jQuery(document).ready(function($) {
    console.log('jQuery chargé :', typeof $);

    // Gérer le défilement pour les conteneurs horizontaux
    const scrollContainers = document.querySelectorAll('.episode-scroll-container');
    scrollContainers.forEach(scrollContainer => {
        let touchStartX = 0;
        let touchActive = false;
        let isMouseMoving = false;
        let lastMouseX = 0;
        let scrollSpeed = 2;

        scrollContainer.addEventListener('touchstart', function(e) {
            if (e.target.closest('#chat-container') || e.target.closest('#chat-toggle')) return;
            if (e.touches.length === 2) {
                touchStartX = (e.touches[0].clientX + e.touches[1].clientX) / 2;
                touchActive = true;
            }
        });

        scrollContainer.addEventListener('touchmove', function(e) {
            if (e.target.closest('#chat-container') || e.target.closest('#chat-toggle')) return;
            if (e.touches.length === 2 && touchActive) {
                const touchCurrentX = (e.touches[0].clientX + e.touches[1].clientX) / 2;
                const deltaX = touchStartX - touchCurrentX;
                scrollContainer.scrollLeft += deltaX * 1.5;
                touchStartX = touchCurrentX;
                e.preventDefault();
            }
        });

        scrollContainer.addEventListener('touchend', function() {
            touchActive = false;
        });

        scrollContainer.addEventListener('mousemove', function(e) {
            if (e.target.closest('#chat-container') || e.target.closest('#chat-toggle')) return;
            if (!isMouseMoving) return;
            const rect = scrollContainer.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const deltaX = mouseX - lastMouseX;
            const direction = deltaX > 0 ? 1 : -1;
            const speedFactor = Math.abs(deltaX) / 50;
            scrollContainer.scrollLeft -= direction * scrollSpeed * speedFactor;
            lastMouseX = mouseX;
        });

        scrollContainer.addEventListener('mousedown', function(e) {
            if (e.target.closest('#chat-container') || e.target.closest('#chat-toggle')) return;
            isMouseMoving = true;
            lastMouseX = e.clientX - scrollContainer.getBoundingClientRect().left;
        });

        scrollContainer.addEventListener('mouseup', function() {
            isMouseMoving = false;
        });

        scrollContainer.addEventListener('mouseleave', function() {
            isMouseMoving = false;
        });
    });

    // Chatbot functionality
    function sendQuestion(predefinedQuestion) {
        console.log('sendQuestion appelée');
        console.log('chat-box existe :', !!document.getElementById('chat-box'));
        let question = predefinedQuestion || $('#question').val().trim();
        console.log('Question :', question);
        if (!question) {
            console.log('Aucune question entrée');
            return;
        }

        console.log('Ajout du message utilisateur');
        $('#chat-box').append('<div class="message user animate-fade-in">Vous : ' + question + '</div>');
        $('#question').val('');

        console.log('Envoi de la requête AJAX');
        $.ajax({
            url: '/chatbot/ask',
            method: 'POST',
            data: { question: question, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                console.log('Réponse AJAX :', response);
                let botMessage = response.error ? 'Erreur : ' + response.error : 'Bot : ' + response.answer;
                $('#chat-box').append('<div class="message bot animate-fade-in">' + botMessage + '</div>');
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX :', status, error);
                $('#chat-box').append('<div class="message bot animate-fade-in">Erreur : Impossible de contacter le serveur. Détail : ' + error + '</div>');
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            }
        });
    }

    // Gestionnaire pour le bouton Envoyer
    $('#send-button').on('click', function() {
        console.log('Bouton Envoyer cliqué');
        sendQuestion();
    });

    // Gestionnaire pour les boutons prédéfinis
    $('.predefined-btn').on('click', function() {
        console.log('Bouton prédéfini cliqué');
        const question = $(this).data('question');
        sendQuestion(question);
    });

    // Activer l'envoi avec la touche Entrée
    $('#question').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            console.log('Touche Entrée pressée');
            e.preventDefault();
            sendQuestion();
        }
    });

    // Toggle chat visibility
    $('#chat-toggle').on('click', function() {
        console.log('Toggle chat cliqué');
        $('#chat-container').toggleClass('hidden');
        if (!$('#chat-container').hasClass('hidden')) {
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        }
    });

    $('#close-chat').on('click', function() {
        console.log('Bouton Fermer cliqué');
        $('#chat-container').addClass('hidden');
    });
});

    </script>
</body>
</html>