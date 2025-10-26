<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - BUSINESS+ Talk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> <!-- Ajout pour l'animation fadeIn -->
    <style>
        /* Variables CSS pour les couleurs */
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

        /* Conteneur principal */
        .container {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            margin-right:0;
            margin-left: 280px;
            padding: 0;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* Zone de contenu */
        .content-area {
            padding: 2rem;
            flex: 1;
        }

        /* Style pour les messages de succès ou d'erreur */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: rgba(0, 0, 0, 0.2);
            color: rgb(0, 255, 94);
            border: 1px solid rgb(0, 255, 94);
        }

        .alert-error {
            background-color: rgba(0, 0, 0, 0.2);
            color: rgb(255, 0, 0);
            border: 1px solid rgb(255, 0, 0);
        }

        /* NOUVEAU : Style pour le message d'erreur de blocage (copié de l'exemple précédent) */
        .error-message {
            color: #E50914;
            text-align: center;
            padding: 20px;
            background-color: #1A1A1A;
            border: 1px solid #E50914;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
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

        /* NOUVEAU : Style pour les boutons désactivés */
        .disabled-btn {
            background-color: #2a2a2a !important;
            cursor: not-allowed !important;
            opacity: 0.6;
        }

        /* Bouton pour créer un post */
        .create-post-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: var(--light-text);
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .create-post-btn:hover {
            background-color: color-mix(in srgb, var(--primary-color) 80%, #000000);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 181, 173, 0.3);
        }

        /* Liste des posts */
        .post-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }


        .post-card:hover {
            transform: translateY(-3px);
            border: 1px solid var(--primary-color);
        }

        /* En-tête du post */
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

        .report-form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
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

        /* Titre et contenu du post */
        .post-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 0.5rem;
            transition: color 0.2s;
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

        /* Médias */
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

        /* Sondage */
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

        /* Interactions (Votes et Commentaires) */
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

        .comments-link {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--gray-text);
            text-decoration: none;
        }

        .comments-link:hover {
            color: var(--primary-color);
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

        /* Ajustements responsifs */
        @media (max-width: 992px) and (min-width: 769px) {
                .sidebar {
                width: 80px;
                z-index: 1050; /* Maintenir le z-index élevé */
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
                z-index: 1050; /* Maintenir le z-index élevé */
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
        }

        @media (max-width: 576px) {
            .post-title {
                font-size: 1rem;
            }

            .user-avatar,
            .initial-avatar {
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
        }

        @media (max-width: 400px) {
                    .sidebar {
                width: 40px;
                z-index: 1050; /* Maintenir le z-index élevé */
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

            .poll-option button {
                font-size: 0.85rem;
                padding: 0.5rem;
            }
        }

         /* Barre latérale */
        .sidebar {
            width: 280px;
            background-color: var(--darker-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease;
        }

        .logo-container {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
            text-align: center;
        }

        .logo {
            max-width: 200px;
            height: auto;
            margin: 0 auto;
        }

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

        /* En-tête */
        .header {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            background-color: var(--darker-bg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-logo-container {
            flex: 0 0 auto;
            display: none;
        }

        .header-logo {
            max-height: 50px;
            width: auto;
            margin: 0 auto;
        }

        .header-center {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 0 0 auto;
        }

        .search-container {
            position: relative;
            width: 400px;
            max-width: 100%;
            transition: width 0.3s ease-in-out, transform 0.2s ease;
        }

        .search-container:hover {
            width: 420px;
            transform: scale(1.02);
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 1.2rem;
            border: none;
            border-radius: 1rem;
            background-color: var(--gray-bg);
            color: var(--light-text);
            font-size: 1rem;
            outline: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }

        .search-input:focus {
            background-color: var(--darker-bg);
            box-shadow: 0 0 12px rgba(30, 181, 173, 0.5);
            transform: scale(1.01);
        }

        .search-input::placeholder {
            color: var(--gray-text);
            opacity: 0.7;
            font-style: italic;
        }

        .search-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-text);
            font-size: 1.2rem;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .search-container:hover .search-icon {
            color: var(--primary-color);
            transform: translateY(-50%) scale(1.1);
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px; /* Taille tactile minimum */
            touch-action: manipulation;
            white-space: nowrap;
        }

        .btn-outline {
            background: transparent;
            color: var(--light-text);
            border: 2px solid rgba(255, 255, 255, 0.15);
        }

        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 181, 173, 0.2);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 181, 173, 0.3);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
            transition: transform 0.3s ease;
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
            font-size: 18px;
            font-weight: bold;
            color: var(--light-text);
            text-transform: uppercase;
        }

        .user-avatar:hover, .initial-avatar:hover {
            transform: scale(1.1);
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--light-text);
            transition: color 0.3s ease;
        }

        .user-profile:hover .user-name {
            color: var(--primary-color);
        }

        /* Pied de page */
        .footer {
            background-color: var(--darker-bg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            text-align: center;
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .footer-social .social-link {
            color: var(--light-text);
            font-size: 1.5rem;
            transition: color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .footer-social .social-link:hover {
            color: var(--primary-color);
            transform: scale(1.2);
        }

        .footer-text {
            color: var(--gray-text);
            font-size: 0.875rem;
            margin-top: 1rem;
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

                <!-- Affichage des messages de succès ou d'erreur -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- MODIFIÉ : Gestion du blocage pour la création de posts -->
                @auth
                    @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                        <div class="error-message animate__animated animate__fadeIn">
                            Vous êtes bloqué et ne pouvez pas interagir avec le contenu. Si vous avez des questions, veuillez nous contacter : 
                            <a href="mailto:businessplus@gmail.com" class="text-accent-teal underline">businessplus@gmail.com</a>.
                        </div>
                    @else
                        <a href="{{ route('post.createForm') }}" class="create-post-btn">
                            <strong>+</strong> Créer un Post
                        </a>
                    @endif
                @endauth

                <!-- Liste des posts -->
                <div class="post-list">
                    @foreach ($posts as $post)
                        <div class="post-card">
                            <!-- Contenu du post -->
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
                                <!-- MODIFIÉ : Menu à trois points désactivé pour les utilisateurs bloqués -->
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

                            <!-- Titre et contenu du post -->
                            <a href="{{ route('post.show', $post) }}" class="block">
                                <h2 class="post-title">{{ $post->title }}</h2>
                            </a>
                            @if ($post->content)
                                <p class="post-content">{{ $post->content }}</p>
                            @endif

                            <!-- Médias -->
                            <div class="post-media">
                                @if ($post->media_type === 'image')
                                    <img src="{{ $post->media_url }}" alt="Media">
                                @elseif ($post->media_type === 'youtube')
                                    <iframe class="w-full" src="https://www.youtube.com/embed/{{ preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $post->media_url, $matches) ? $matches[1] : (preg_match('/youtu\.be\/([^\&\?\/]+)/', $post->media_url, $matches) ? $matches[1] : '') }}" frameborder="0" allowfullscreen></iframe>
                                @elseif ($post->media_type === 'link')
                                    <a href="{{ $post->media_url }}" target="_blank">{{ $post->media_url }}</a>
                                @endif
                            </div>

                            <!-- Affichage du sondage -->
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
                                                <!-- MODIFIÉ : Désactiver les boutons de vote pour les utilisateurs bloqués -->
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

                            <!-- Interactions -->
                            <div class="post-interactions">
                                <div class="vote-buttons">
                                    <!-- MODIFIÉ : Désactiver les boutons de vote pour les utilisateurs bloqués -->
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
                                <!-- MODIFIÉ : Désactiver le lien des commentaires pour les utilisateurs bloqués -->
                                @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                                    <span class="comments-link" style="cursor: not-allowed; opacity: 0.6;">
                                        <i class="far fa-comment"></i>
                                        <span>{{ $post->comments->count() }} Commentaires</span>
                                    </span>
                                @else
                                    <a href="{{ route('post.show', $post) }}" class="comments-link">
                                        <i class="far fa-comment"></i>
                                        <span>{{ $post->comments->count() }} Commentaires</span>
                                    </a>
                                @endif
                            </div>

                            <!-- MODIFIÉ : Formulaire de signalement DÉPLACÉ À L'INTÉRIEUR DE LA BOUCLE -->
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
                    @endforeach
                </div>
                
            </div>
        </div>

        <!-- Inclusion du pied de page -->
        @include('components.footer')
    </div>

    <script>
        function showConfirmation(message, onConfirm) {
            // Supprimer toute boîte de dialogue existante
            const existingDialog = document.getElementById('confirmation-dialog');
            if (existingDialog) existingDialog.remove();
            const existingBackdrop = document.getElementById('confirmation-backdrop');
            if (existingBackdrop) existingBackdrop.remove();

            // Créer le fond (backdrop)
            const backdrop = document.createElement('div');
            backdrop.id = 'confirmation-backdrop';
            backdrop.className = 'confirm-modal-backdrop';
            document.body.appendChild(backdrop);

            // Créer la boîte de dialogue
            const dialog = document.createElement('div');
            dialog.id = 'confirmation-dialog';
            dialog.className = 'confirm-modal';

            // Créer le titre
            const title = document.createElement('div');
            title.className = 'confirm-modal-title';
            title.textContent = 'Confirmation';
            dialog.appendChild(title);

            // Créer le message
            const messageDiv = document.createElement('p');
            messageDiv.textContent = message;
            messageDiv.style.marginBottom = '20px';
            messageDiv.style.textAlign = 'center';
            dialog.appendChild(messageDiv);

            // Créer le conteneur des boutons
            const buttonsDiv = document.createElement('div');
            buttonsDiv.className = 'confirm-modal-buttons';

            // Créer le bouton Confirmer
            const confirmBtn = document.createElement('button');
            confirmBtn.textContent = 'Confirmer';
            confirmBtn.className = 'confirm-modal-confirm';
            confirmBtn.onclick = () => {
                onConfirm();
                dialog.remove();
                backdrop.remove();
            };
            buttonsDiv.appendChild(confirmBtn);

            // Créer le bouton Annuler
            const cancelBtn = document.createElement('button');
            cancelBtn.textContent = 'Annuler';
            cancelBtn.className = 'confirm-modal-cancel';
            cancelBtn.onclick = () => {
                dialog.remove();
                backdrop.remove();
            };
            buttonsDiv.appendChild(cancelBtn);

            // Ajouter les éléments au DOM
            dialog.appendChild(buttonsDiv);
            document.body.appendChild(dialog);
        }

        function confirmAction(event, form, message, actionText) {
            event.preventDefault();
            showConfirmation(message, () => {
                form.submit();
            });
        }

        // Gestion du menu déroulant
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            // Fermer les autres menus ouverts
            document.querySelectorAll('.dropdown-menu').forEach(d => {
                if (d.id !== menuId && d.style.display === 'block') {
                    d.style.display = 'none';
                }
            });
            // Fermer les formulaires de signalement ouverts
            document.querySelectorAll('.report-form-container').forEach(form => {
                if (form.style.display === 'block') {
                    form.style.display = 'none';
                }
            });
        }

        // Gestion du formulaire de signalement
        function toggleReportForm(formId) {
            const form = document.getElementById(formId);
            const isVisible = form.style.display === 'block';
            form.style.display = isVisible ? 'none' : 'block';
            // Fermer le menu déroulant après ouverture du formulaire
            if (!isVisible) {
                document.querySelectorAll('.dropdown-menu').forEach(d => {
                    d.style.display = 'none';
                });
            }
        }

        // NOUVEAU : Désactiver les interactions pour les utilisateurs bloqués
        function updateBlockedUserInteractions() {
            @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                // Désactiver les boutons de vote
                document.querySelectorAll('.vote-buttons button').forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('disabled-btn');
                });

                // Désactiver les liens de commentaires
                document.querySelectorAll('.comments-link').forEach(link => {
                    link.style.cursor = 'not-allowed';
                    link.style.opacity = '0.6';
                    link.removeAttribute('href');
                });

                // Désactiver les boutons de sondage
                document.querySelectorAll('.poll-option button').forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('disabled-btn');
                });
            @endif
        }

        // Appeler la fonction au chargement de la page
        document.addEventListener('DOMContentLoaded', updateBlockedUserInteractions);

        // Fermer le menu déroulant et le formulaire si on clique ailleurs
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