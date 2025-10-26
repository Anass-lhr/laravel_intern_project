<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>404 - Page non trouvée | Business+ Talk</title>
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

        /* Style global pour les images */
        img {
            max-width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        /* Barre latérale */
        .sidebar {
            width: 280px;
            background-color: var(--darker-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease, height 0.3s ease;
            z-index: 1000;
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

        /* Conteneur principal */
        .container {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: calc(100vh - 120px);
            background: linear-gradient(45deg, var(--darker-bg), var(--gray-bg));
            position: relative;
            overflow: hidden;
        }

        /* Style de la section 404 */
        .error-section {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .error-icon {
            font-size: 8rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            animation: pulse 2s ease-in-out infinite;
        }

        .error-title {
            font-size: 4.5rem;
            font-weight: 700;
            color: var(--light-text);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
        }

        .error-message {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--gray-text);
            margin-bottom: 1.5rem;
        }

        .error-description {
            font-size: 1.1rem;
            color: var(--gray-text);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .action-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }






        /* Animation de pulsation pour l'icône */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Particules d'arrière-plan */
        .error-particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .error-particle:nth-child(1) { width: 30px; height: 30px; top: 10%; left: 15%; animation-delay: 0s; }
        .error-particle:nth-child(2) { width: 20px; height: 20px; top: 80%; left: 80%; animation-delay: 2s; }
        .error-particle:nth-child(3) { width: 25px; height: 25px; top: 50%; left: 30%; animation-delay: 4s; }
        .error-particle:nth-child(4) { width: 15px; height: 15px; top: 20%; left: 70%; animation-delay: 6s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Ajustements responsifs */
        @media (max-width: 992px) and (min-width: 769px) {
            .main-content {
                margin-left: 15px;
                margin-right:15px;
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
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: 60px;
                position: fixed;
                bottom: 0;
                left: 0;
                top: auto;
                padding: 0;
                border-right: none;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.4);
                flex-direction: row;
                justify-content: space-around;
                align-items: center;
                background-color: var(--darker-bg);
            }

            .logo-container {
                display: none;
            }

            .logo {
                max-width: 50px;
            }

            .sidebar-menu {
                display: flex;
                flex-direction: row;
                width: 100%;
                padding: 0;
                justify-content: space-around;
            }

            .sidebar-menu li {
                margin-bottom: 0;
                flex: 1;
                text-align: center;
            }

            .sidebar-menu a {
                padding: 0.75rem;
                justify-content: center;
                border-radius: 0;
                transform: none;
                font-size: 0;
            }

            .sidebar-menu a span {
                display: none;
            }

            .sidebar-menu a i {
                margin-right: 0;
                font-size: 1.5rem;
            }

            .sidebar-menu a:hover {
                transform: none;
                background-color: transparent;
                box-shadow: none;
            }

            .sidebar-menu a.active {
                border-left: none;
                border-top: 4px solid var(--primary-color);
                background: none;
                transform: none;
            }

            .sidebar-menu a:hover i {
                transform: none;
            }

            .main-content {
                margin-left: 15px;
                margin-right:15px;
                margin-bottom: 60px;
            }

            .error-icon {
                font-size: 6rem;
            }

            .error-title {
                font-size: 3.5rem;
            }

            .error-message {
                font-size: 1.5rem;
            }

            .error-description {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .content-area {
                padding: 1rem;
            }

            .error-icon {
                font-size: 5rem;
            }

            .error-title {
                font-size: 2.5rem;
            }

            .error-message {
                font-size: 1.25rem;
            }

            .error-description {
                font-size: 0.875rem;
            }

            .action-btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 400px) {
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
                margin-left: 15px;
                margin-right:15px;
                margin-bottom: 50px;
            }

            .error-icon {
                font-size: 4rem;
            }

            .error-title {
                font-size: 2rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-description {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Inclusion de la barre latérale -->
        @include('components.sidebar')

        <!-- Contenu principal -->
        <div class="main-content">
            <!-- Zone de contenu -->
            <div class="content-area">
                <div class="error-section">
                    <i class="fas fa-exclamation-circle error-icon"></i>
                    <h1 class="error-title">404 - Oups !</h1>
                    <h2 class="error-message">Page Introuvable</h2>
                    <p class="error-description">
                        Il semble que la page que vous cherchez s'est égarée ou n'existe plus. Pas de panique ! Vous pouvez retourner à l'accueil ou essayer une recherche.
                    </p>

                </div>
                <!-- Particules d'arrière-plan -->
                <div class="error-particle"></div>
                <div class="error-particle"></div>
                <div class="error-particle"></div>
                <div class="error-particle"></div>
            </div>
        </div>
    </div>
</body>
</html>