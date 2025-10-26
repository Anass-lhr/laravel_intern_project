<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->titre }} - Business+ Talk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
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
                $primaryColor = $settings->primary_color ?? '#1a9e9e';
            @endphp
            --primary-color: {{ $primaryColor }};
            --dark-bg: #1A1D21;
            --darker-bg: #121212;
            --light-text: #ffffff;
            --light-color: #ffffff;
            --gray-text: #9CA3AF;
            --gray-bg: #2A2D35;
            /* Variables spécifiques au premier fichier */
            --article-bg: #1a1a1a;
            --article-shadow: rgba(0, 240, 255, 0.05);
            --highlight-color: #00f0ff;
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
            margin: 0;
            padding: 0;
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
            margin: 0;
            padding: 0;
            width: 100%;
            max-width: 100vw;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 0;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
            margin-right: 0;
            width: calc(100% - 280px);
            max-width: calc(100vw - 280px);
            width: 100%;
        }

        /* Zone de contenu */
        .content-area {
            padding: 1rem 2rem;
            flex: 1;
            max-width: 100%;
            margin: 0;
            box-sizing: border-box;
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

        .search-container:hover {
            width: 420px;
            transform: scale(1.02);
            max-width: calc(100% - 40px); /* Limiter la largeur */
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
            background-color: #25c4c4; /* Utilisation de primary-hover de Tailwind */
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
        .error-message {
            color: #E50914;
            text-align: center;
            padding: 20px;
            font-size: 1.1rem;
            background-color: #1A1A1A;
            border: 1px solid #E50914;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            margin: 20px auto;
            max-width: 1280px;
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .error-message.temporary {
            animation: pulse-slow 1.8s ease-in-out infinite;
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

        /* Styles spécifiques à l'article */
        .article-container {
        max-width: 900px; /* Réduit pour une meilleure lisibilité */
        margin: 40px auto; /* Centré avec marge verticale */
        background-color: var(--article-bg);
        padding: 50px; /* Augmenté pour plus d'espace */
        border-radius: 16px; /* Plus arrondi */
        width: 90%; /* Réduit les marges latérales */
        box-sizing: border-box;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* Ombre plus prononcée */
    }

        .article-meta {
        font-size: 0.95rem;
        color: var(--gray-text);
        display: flex;
        gap: 25px;
        align-items: center;
        margin-top: 15px;
        flex-wrap: wrap;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Amélioration de l'image de l'article */
    .article-image-container {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        width: 100%;
    }
    .article-image:hover {
        transform: scale(1.02);
    }

    .article-image {
        max-height: 400px; /* Augmenté */
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
    }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
        }
    
        .btn-share {
            background-color: var(--primary-color);
            color: #000;
            border: none;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
        }

        .btn-back {
            background-color: var(--primary-color);
            border: none;
            color: #000;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
        }

        .article-body {
        margin-top: 40px;
        line-height: 1.8; /* Excellent pour la lisibilité */
        max-width: 100%;
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
        overflow-x: hidden;
        font-size: 1.125rem; /* Augmenté à 18px */
        color: #f5f5f5; /* Blanc plus doux pour les yeux */
        letter-spacing: 0.025em; /* Espacement des lettres pour la lisibilité */
    }

        .article-body ul {
            list-style-type: disc !important;
            padding-left: 1.5em !important;
            margin-bottom: 1em !important;
        }

        .article-body h1,
    .article-body h2,
    .article-body h3,
    .article-body h4,
    .article-body h5,
    .article-body h6 {
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        line-height: 1.3;
        color: var(--light-text);
        font-weight: 700;
    }

    .article-body h1 { font-size: 2.25rem; }
    .article-body h2 { font-size: 1.875rem; }
    .article-body h3 { font-size: 1.5rem; }
    .article-body h4 { font-size: 1.25rem; }

    /* Paragraphes */
    .article-body p {
        margin-bottom: 1.5rem;
        text-align: justify; /* Justification pour une apparence professionnelle */
    }

        .article-body ol {
            list-style-type: decimal !important;
            padding-left: 1.5em !important;
            margin-bottom: 1em !important;
        }

        .article-body li {
            display: list-item !important;
            margin-bottom: 0.5em !important;
        }

        .article-body table {
            border-collapse: collapse !important;
            width: 100% !important;
            margin-bottom: 1em !important;
        }

        .article-body th,
        .article-body td {
            border: 1px solid #333 !important;
            padding: 8px !important;
        }

        .article-body th {
            background-color: #222 !important;
        }

        .article-body img {
            max-width: 100% !important;
            height: auto !important;
            margin: 10px 0 !important;
            border-radius: 5px !important;
        }

        .article-body a {
            color: var(--highlight-color) !important;
            text-decoration: underline !important;
        }

        .article-body blockquote {
            border-left: 3px solid var(--primary-color) !important;
            padding-left: 1em !important;
            margin-left: 0 !important;
            color: var(--gray-text) !important;
        }

        .article-container h1 {
        font-size: 2.5rem; /* Plus grand sur desktop */
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    

        [align="center"], [style*="text-align: center"] {
            text-align: center !important;
        }

        [align="right"], [style*="text-align: right"] {
            text-align: right !important;
        }

        [align="left"], [style*="text-align: left"] {
            text-align: left !important;
        }

        /* Support pour les textes colorés */
        [style*="color"] {
            color: inherit;
        }

        [style*="background"] {
            background: inherit;
        }

        /* Support pour les attributs de direction (RTL/LTR) */
        [dir="rtl"] {
            direction: rtl !important;
            text-align: right !important;
        }

        #comment-form {
            max-width: 900px; 
            margin: 30px auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: var(--article-bg);
            padding: 40px; 
            border-radius: 16px;
            width: 90%; 
            box-sizing: border-box;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        #comment-form textarea,
        .reply-form textarea {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--dark-bg);
            color: var(--light-text);
            border: 1px solid #333333; /* Utilisation de dark.border */
            border-radius: 0.5rem;
            font-size: 0.9rem;
            resize: vertical;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }

        #comment-form textarea:focus,
        .reply-form textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(30, 181, 173, 0.3); /* Aligné avec Tailwind */
            outline: none;
            transform: scale(1.01);
        }

        #comment-form textarea::placeholder,
        .reply-form textarea::placeholder {
            color: var(--gray-text);
            opacity: 0.7;
            font-style: italic;
        }

        #comment-form textarea:hover,
        .reply-form textarea:hover {
            border-color:var(--primary-color); /* Utilisation de primary-hover */
        }

        #comments-container {
            max-width: 900px; /* Aligné avec l'article */
            margin: 30px auto;
            padding: 40px; /* Augmenté */
            border-top: 3px solid var(--primary-color);
            width: 90%; /* Réduit les marges latérales */
            box-sizing: border-box;
        }


            .comment {
            background: linear-gradient(145deg, var(--article-bg), rgba(26, 26, 26, 0.8));
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .comment:hover {
            transform: translateY(-2px);
        }

        .comment.reply {
            border-left: 2px solid var(--primary-color);
            padding-left: 15px;
            background-color: rgba(26, 158, 158, 0.05);
            margin-top: 10px;
            margin-left: 0 !important; /* Annuler la marge gauche */
            max-width: 100%; /* Limiter la largeur */
            box-sizing: border-box; /* Inclure padding et border dans la largeur */
        }

        .replies-container {
            margin-top: 10px;
            margin-left: 20px; /* Indentation contrôlée */
            max-width: calc(100% - 20px); /* Largeur limitée */
            overflow: hidden; /* Empêcher le débordement */
            box-sizing: border-box;
        }

        .comment {
            max-width: 100%;
            box-sizing: border-box;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .comment-content {
            flex: 1;
            min-width: 0; /* Permettre la réduction */
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .comment-text {
            margin-top: 5px;
            color: var(--light-text);
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }

        .comment {
            transition: all 0.3s ease;
        }

        .comment-content {
            flex: 1;
        }

        .comment-author {
            font-weight: 600;
            color: var(--light-color);
        }

        .comment-timestamp {
            font-size: 0.8rem;
            color: var(--gray-text);
            margin-left: 10px;
        }

        .comment-text {
            margin-top: 5px;
            color: var(--light-text);
        }

        .comment-actions {
            margin-top: 5px;
            display: flex;
            gap: 10px;
        }

        .reply-btn {
            cursor: pointer;
            color: #007bff;
            font-size: 0.85rem;
        }

        .delete-btn {
            cursor: pointer;
            color: #b91c1c; /* Utilisation de danger */
            font-size: 0.85rem;
        }

        .reply-form {
            background-color: var(--gray-bg);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
        }

        .reply-form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .reply-form-buttons .cancel-reply-btn {
            @apply bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-all duration-300;
        }

        .reply-form-buttons button:last-child {
            @apply bg-primary text-white px-4 py-2 rounded hover:bg-primary-hover transition-all duration-300;
        }

        .replies-container {
            display: none;
        }

        .replies-toggle {
            cursor: pointer;
            color: #007bff;
            margin-top: 5px;
            font-size: 0.9rem;
        }

        .replies-toggle.active {
            color: var(--primary-color);
        }

        .no-comments {
            text-align: center;
            color: var(--gray-text);
            font-style: italic;
        }

        .error-message {
            color: #b91c1c; /* Utilisation de danger */
            text-align: center;
        }

        .comment-deleted {
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .comment-form-buttons button,
        .reply-form-buttons button {
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: 600;
        }

        .comment-form-buttons .cancel-btn,
        .reply-form-buttons .cancel-reply-btn {
            background-color: #6c757d;
            color: var(--light-text);
        }

        .comment-form-buttons button:last-child,
        .reply-form-buttons button:last-child {
            background-color:var(--primary-color);
            color: #000;
        }

        /* Styles pour le signalement */
        .report-btn {
            cursor: pointer;
            color: #ff9800;
            font-size: 0.85rem;
            transition: color 0.2s ease;
        }

        .report-btn:hover {
            color: #ff5722;
        }

        .report-btn:disabled {
            cursor: default;
            opacity: 0.6;
        }

        #reportModal select,
        #reportModal textarea {
            width: 100%;
            padding: 10px;
            background-color: #252525; /* Utilisation de dark.element */
            border: 1px solid #333333; /* Utilisation de dark.border */
            color: var(--light-text);
            resize: none;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        #reportModal select:focus,
        #reportModal textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        /* Animations */
        .animate__animated {
            animation-duration: 0.3s;
        }

        .animate__fadeInDown {
            animation-name: fadeInDown;
        }

        .animate__fadeOutUp {
            animation-name: fadeOutUp;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes fadeOutUp {
            from {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
            to {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
        }

        .animate__fadeIn {
            animation-name: fadeIn;
        }

        .animate__fadeOut {
            animation-name: fadeOut;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        /* Modale */
        .modal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .modal-content {
            background-color: var(--gray-bg);
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }

        @media (max-width: 992px) and (min-width: 769px) {
            .main-content {
                    margin-left: 60px;
                    width: calc(100% - 60px);
                    max-width: calc(100vw - 60px);
                }

            .sidebar {
                width: 60px;
            }

            .logo-container {
                display: none;
            }

            .sidebar-menu a span {
                display: none;
            }

            .sidebar-menu a {
                padding: 0.75rem;
                justify-content: center;
            }

            .sidebar-menu a i {
                margin-right: 0;
                font-size: 1.5rem;
            }

            .article-container, #comment-form, #comments-container {
                width: 98%;
                padding: 1rem;
            }

            .article-body {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                    margin-left: 0;
                    width: 100%;
                    max-width: 100vw;
                }

            .header {
                flex-direction: column;
                height: auto;
                padding: 0.75rem;
                gap: 0.75rem;
            }

            .header-center {
                width: 100%;
            }

            .header-logo-container {
                display: block;
            }

            .header-logo {
                max-height: 40px;
            }

            .search-container {
                width: 100%;
            }

            .search-container:hover {
                width: 100%;
                transform: scale(1);
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .user-profile {
                width: 100%;
                justify-content: center;
            }

            .article-container, #comment-form, #comments-container {
                width: 100%;
                padding: 0.75rem;
                margin: 10px auto;
            }

            .article-body {
                font-size: 0.9rem;
                line-height: 1.6;
            }

            .article-container h1 {
                font-size: 1.5rem;
            }

            .modal-content {
                width: 98%;
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .sidebar {
                    width: 50px;
                }

            .header-logo {
                max-height: 35px;
            }

            .search-input {
                padding: 0.5rem 1.5rem 0.5rem 0.75rem;
                font-size: 0.85rem;
            }

            .search-icon {
                font-size: 0.9rem;
                right: 0.6rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }

            .user-name {
                font-size: 0.8rem;
            }

            .user-avatar, .initial-avatar {
                width: 30px;
                height: 30px;
            }

            .initial-avatar {
                font-size: 14px;
            }

            .footer-social {
                gap: 0.5rem;
            }

            .footer-social .social-link {
                font-size: 1rem;
            }

            .footer-text {
                font-size: 0.7rem;
            }

            .article-meta {
                font-size: 0.85rem;
                gap: 10px;
            }

            .article-container, #comment-form, #comments-container {
                width: 100%;
                padding: 0.5rem;
                margin: 5px auto;
                border-radius: 8px;
            }

            .article-body {
                font-size: 0.85rem;
                line-height: 1.5;
            }

            .article-container h1 {
                font-size: 1.25rem;
            }

            .replies-container {
                max-width: calc(100% - 0.5rem);
            }

            .comment.reply {
                padding-left: 0.5rem;
            }

            .comment {
                padding: 0.5rem;
            }

            .modal-content {
                width: 100%;
                padding: 0.75rem;
            }

            .modal-content h3 {
                font-size: 0.9rem;
            }

            .modal-content p {
                font-size: 0.75rem;
            }

            .modal-content button {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            .sidebar {
                width: 40px;
            }

            

            .article-container {
                margin: 10px;
                padding: 15px;
            }
        }
        @media (max-width: 768px) {
            .article-container h1 {
                font-size: 2rem; /* Ajusté pour mobile */
            }
        }

        @media (max-width: 576px) {
            .article-container h1 {
                font-size: 1.75rem; 
            }
        }

        #repondre{
            color:var(--gray-text);
        }

        @media (max-width: 768px) {
            .replies-container {
                max-width: calc(100% - 10px);
            }
        
            .comment.reply {
                padding-left: 10px;
            }
        
            .comment {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .replies-container {
                max-width: calc(100% - 5px);
            }
        
            .comment.reply {
                padding-left: 8px;
            }
        
            .comment {
                padding: 8px;
                    gap: 10px;
            }
            .article-container,
            #comment-form,
            #comments-container {
                width: 98%;
                padding: 20px;
                margin: 15px auto;
                border-radius: 12px;
            }
            
            .article-body {
                font-size: 1rem;
                line-height: 1.6;
            }
            
            .article-container h1 {
                font-size: 1.75rem;
            }
        }

        /* Animation d'apparition */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes modalFadeOut {
            from {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            to {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
        }

        .modal-enter {
            animation: modalFadeIn 0.3s ease forwards;
        }

        .modal-exit {
            animation: modalFadeOut 0.3s ease forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modal {
                padding: 0.75rem;
            }
            
            .modal-content {
                width: 95%;
                max-width: none;
                padding: 1.5rem;
                border-radius: 0.75rem;
            }
            
            .modal-content h3 {
                font-size: 1.125rem;
            }
            
            .modal-content p {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .modal {
                padding: 0.5rem;
            }
            
            .modal-content {
                width: 98%;
                padding: 1.25rem;
                border-radius: 0.5rem;
            }
            
            .modal-content h3 {
                font-size: 1rem;
            }
            
            .modal-content p {
                font-size: 0.8rem;
            }
            
            .modal-content .flex.flex-col.sm\\:flex-row {
                flex-direction: column;
            }
            
            .modal-content button {
                width: 100%;
                justify-content: center;
            }
        } 
        /* Assurer que la modale est toujours au-dessus */
        #deleteCommentModal {
            z-index: 9999 !important;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 1rem;
            overflow: auto;
        }

        .modal-content {
            background: linear-gradient(145deg, #2a2d35, #1e1e1e);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.5),
                0 10px 10px -5px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            max-width: 420px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s ease;
            /* SUPPRESSION des propriétés problématiques */
            /* margin: auto; position: relative; left: 50%; top: 50%; */
        }

        .modal:not(.hidden) .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .modal.hidden .modal-content {
            transform: scale(0.9);
            opacity: 0;
        }

        /* Assurer que la modale de suppression utilise les styles généraux */
        #deleteCommentModal {
            z-index: 9999 !important;
        }

        /* Éviter le débordement horizontal */
        body.modal-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
            height: 100%;
        }
        /* Styles spécifiques pour la modal de signalement */
#reportModal {
    backdrop-filter: blur(8px);
}

#reportModal .modal-content {
    max-width: 500px;
    width: 95%;
    max-height: 90vh;
    overflow-y: auto;
}

#reportModal select:focus,
#reportModal textarea:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
}

#reportModal button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

#reportModal button:disabled:hover {
    background-color: inherit;
}

/* Animation pour les erreurs */
#reportErrorContainer.show {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        transform: translateY(-10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive pour très petits écrans */
@media (max-width: 480px) {
    #reportModal .modal-content {
        width: 98%;
        margin: 1rem;
        padding: 1rem;
    }
    
    #reportModal h3 {
        font-size: 1.1rem;
    }
    
    #reportModal .flex.justify-end {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    #reportModal button {
        width: 100%;
    }
}

        /* Style pour les très petits écrans */
        @media (max-width: 360px) {
            #deleteCommentModal .modal-content {
                width: 95vw;
                padding: 1rem;
                font-size: 0.875rem;
            }
            
            #deleteCommentModal .modal-content h3 {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }
            
            #deleteCommentModal .modal-content p {
                font-size: 0.75rem;
                margin-bottom: 1rem;
            }
            
            #deleteCommentModal .modal-content button {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
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
            <!-- Inclusion de l'en-tête -->
            @include('components.header')

            @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                <div class="error-message">
                    Vous êtes bloqué et ne pouvez pas interagir avec le contenu. Si vous avez des questions, veuillez nous contacter : <a href="mailto:businessplus@gmail.com" class="text-accent-teal underline ">businessplus@gmail.com</a>.
                </div>
            @endif
            
            <!-- Zone de contenu -->
            <div class="content-area">
                <div class="article-container">
                    <!-- Modale de signalement améliorée -->
                        <div id="reportModal" class="modal hidden">
                            <div class="modal-content">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-bold text-white">Signaler un commentaire</h3>
                                    <button onclick="closeReportModal()" class="text-gray-400 hover:text-white transition-colors">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </div>
                                
                                <!-- Zone d'erreur pour les messages d'erreur spécifiques -->
                                <div id="reportErrorContainer" class="hidden mb-4 p-3 bg-red-600 text-white rounded border-l-4 border-red-800">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <span id="reportErrorMessage"></span>
                                        <button onclick="document.getElementById('reportErrorContainer').classList.add('hidden')" class="ml-auto text-white hover:text-gray-200">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <form id="reportForm" onsubmit="event.preventDefault(); submitReport();">
                                    <div class="mb-4">
                                        <label for="reportReason" class="block text-gray-300 mb-2 font-medium">
                                            Veuillez indiquer la raison de ce signalement :
                                        </label>
                                        <select id="reportReason" class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white focus:border-blue-500 focus:outline-none transition-colors" required>
                                            <option value="">-- Sélectionnez une raison --</option>
                                            <option value="inappropriate">Contenu inapproprié</option>
                                            <option value="spam">Spam ou publicité</option>
                                            <option value="harassment">Harcèlement</option>
                                            <option value="hate_speech">Discours haineux</option>
                                            <option value="false_information">Fausses informations</option>
                                            <option value="violence">Incitation à la violence</option>
                                            <option value="other">Autre</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label for="reportDescription" class="block text-gray-300 mb-2 font-medium">
                                            Description détaillée (optionnelle) :
                                        </label>
                                        <textarea 
                                            id="reportDescription" 
                                            placeholder="Décrivez plus précisément le problème (optionnel)..." 
                                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white focus:border-blue-500 focus:outline-none transition-colors resize-vertical" 
                                            rows="4"
                                            maxlength="500"></textarea>
                                        <div class="text-xs text-gray-400 mt-1">
                                            <span id="charCount">0</span>/500 caractères
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" id="reportedCommentId" value="">
                                    
                                    <div class="flex justify-end space-x-3">
                                        <button 
                                            type="button" 
                                            onclick="closeReportModal()" 
                                            class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-all duration-200 font-medium">
                                            Annuler
                                        </button>
                                        <button 
                                            type="submit" 
                                            id="submitReportBtn" 
                                            class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-all duration-200 font-medium">
                                            <i class="fas fa-flag mr-2"></i>
                                            Envoyer le signalement
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    <!-- Modal de confirmation de suppression -->
                    <div id="deleteModal" class="modal hidden">
                        <div class="modal-content">
                            <h3 class="text-xl font-bold text-white mb-4">Confirmation</h3>
                            <p class="text-gray-300 mb-6">Voulez-vous vraiment supprimer cet article ?</p>
                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('deleteModal').classList.add('hidden')">Annuler</button>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Confirmer</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de confirmation pour mettre en brouillon -->
                    <div id="draftModal" class="modal hidden">
                        <div class="modal-content">
                            <h3 class="text-xl font-bold text-white mb-4">Confirmation</h3>
                            <p class="text-gray-300 mb-6">Êtes-vous sûr de vouloir déplacer cet article vers les brouillons ?</p>
                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('draftModal').classList.add('hidden')">Annuler</button>
                                <form action="{{ route('articles.update', $article->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="draft">
                                    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Confirmer</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de confirmation pour publier -->
                    <div id="publishModal" class="modal hidden">
                        <div class="modal-content">
                            <h3 class="text-xl font-bold text-white mb-4">Confirmation</h3>
                            <p class="text-gray-300 mb-6">Êtes-vous sûr de vouloir publier cet article ?</p>
                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('publishModal').classList.add('hidden')">Annuler</button>
                                <form action="{{ route('articles.publish', $article->id) }}" method="POST" id="publishForm">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Confirmer</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modale de connexion requise -->
                    <div id="login-modal" class="modal hidden">
                        <div class="modal-content">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold text-white">Connexion requise</h3>
                                <button onclick="toggleLoginModal(false)" class="text-[#9ca3af] hover:text-white">✕</button>
                            </div>
                            <div class="mb-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-[#252525] p-3 rounded-full mr-4">
                                        <svg class="w-6 h-6 text-[#00f0ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-[#f1f1f1]">Vous devez être connecté pour participer à la discussion.</p>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <button onclick="toggleLoginModal(false)" class="flex-1 px-4 py-2 bg-[#333333] text-white rounded-md hover:bg-[#444444] transition duration-200">Annuler</button>
                                <a href="{{ route('login') }}" class="flex-1 px-4 py-2 bg-[#00f0ff] text-black font-medium rounded-md hover:bg-[#00d5e0] transition duration-200 text-center">Se connecter</a>
                            </div>
                        </div>
                    </div>

                    <!-- Si c'est un article supprimé, afficher une alerte -->
                    @if($article->is_deleted)
                        <div class="bg-yellow-800 text-yellow-100 px-4 py-3 rounded mb-6">
                            <strong>Note:</strong> Cet article a été supprimé le {{ $article->updated_at->format('d/m/Y à H:i') }}.
                            @if(Auth::check() && Auth::user()->role !== 'user')
                                <form action="{{ route('articles.restore', $article->id) }}" method="POST" class="inline-block mt-2">
                                    @csrf
                                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white py-1 px-3 rounded text-sm">Restaurer cet article</button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <!-- Si c'est un brouillon, afficher une alerte -->
                    @if($article->status === 'draft')
                        <div class="bg-yellow-800 text-yellow-100 px-4 py-3 rounded mb-6">
                            <strong>Brouillon :</strong> Cet article est actuellement en mode brouillon et n'est visible que par les administrateurs.
                            @if(Auth::check() && (Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && $article->created_by === Auth::id())))
                                <form action="{{ route('articles.publish', $article->id) }}" method="POST" class="inline-block mt-2">
                                    @csrf
                                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white py-1 px-3 rounded text-sm">Publier cet article</button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <!-- Image de l'article -->
                    @if($article->image)
                        <div class="article-image-container">
                            @php
                                $extension = pathinfo($article->image, PATHINFO_EXTENSION);
                            @endphp
                                <img src="{{ $article->image }}" alt="{{ $article->titre }}" class="article-image">
                        </div>
                    @endif

                    <!-- Titre de l'article -->
                    <h1 class="text-3xl font-bold mb-4" dir="{{ $article->text_direction ?? 'auto' }}">{{ $article->titre }}</h1>

                    <!-- Métadonnées de l'article -->
                    <div class="article-meta" dir="{{ $article->text_direction ?? 'auto' }}">
                        <span>📅 {{ $article->created_at->format('d M, Y') }}</span>
                        @if(is_array($article->categorie) && count($article->categorie) > 0)
                            <span>Catégorie: {{ implode(', ', $article->categorie) }}</span>
                        @endif
                        <span dir="ltr">Auteur: {{ $article->auteur ?? 'Non spécifié' }}</span>
                        <!-- Remplacez la section des boutons d'action dans votre fichier -->
                        <div class="flex items-center gap-3 ml-auto">
                            <button onclick="sharePodcast(window.location.href, '{{ $article->titre }}')" class="btn-share">
                                <i class="fas fa-share-alt mr-2"></i>Partager
                            </button>
                            @if(Auth::check() && Auth::user()->is_active && (Auth::user()->role == 'superadmin' || (Auth::user()->role === 'admin' && $article->created_by === Auth::id())))
                                <div class="relative">
                                    <!-- Bouton kebab corrigé -->
                                    <button onclick="toggleKebabMenu()" id="kebab-button" class="btn btn-secondary btn-sm px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <!-- Menu déroulant corrigé -->
                                    <div id="kebab-menu" class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-lg shadow-xl z-50 hidden border border-gray-700">
                                        <div class="py-2">
                                            @if(Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && $article->created_by === Auth::id()))
                                                @if($article->is_deleted)
                                                    {{-- Article supprimé: Éditer, Restaurer, Publier --}}
                                                    <a href="{{ route('articles.edit', $article->id) }}" 
                                                       class="flex items-center px-4 py-2 text-sm text-blue-400 hover:bg-gray-700 transition-colors">
                                                        <i class="fas fa-edit mr-3 w-4"></i>Éditer
                                                    </a>
                                                    <button onclick="showRestoreModal()" 
                                                        class="w-full flex items-center px-4 py-2 text-sm text-green-400 hover:bg-gray-700 transition-colors text-left">
                                                        <i class="fas fa-undo mr-3 w-4"></i>Restaurer
                                                    </button>
                                                    <button onclick="showPublishModal()" 
                                                        class="w-full flex items-center px-4 py-2 text-sm text-emerald-400 hover:bg-gray-700 transition-colors text-left">
                                                        <i class="fas fa-paper-plane mr-3 w-4"></i>Publier
                                                    </button>
                                                @elseif($article->status === 'draft')
                                                    {{-- Brouillon: Supprimer, Publier, Éditer --}}
                                                    <button onclick="showDeleteModal()" 
                                                        class="w-full flex items-center px-4 py-2 text-sm text-red-400 hover:bg-gray-700 transition-colors text-left">
                                                        <i class="fas fa-trash mr-3 w-4"></i>Supprimer
                                                    </button>
                                                    <button onclick="showPublishModal()" 
                                                        class="w-full flex items-center px-4 py-2 text-sm text-green-400 hover:bg-gray-700 transition-colors text-left">
                                                        <i class="fas fa-paper-plane mr-3 w-4"></i>Publier
                                                    </button>
                                                    <a href="{{ route('articles.edit', $article->id) }}" 
                                                       class="flex items-center px-4 py-2 text-sm text-blue-400 hover:bg-gray-700 transition-colors">
                                                        <i class="fas fa-edit mr-3 w-4"></i>Éditer
                                                    </a>
                                                @else
                                                    {{-- Article publié: Supprimer, Éditer, Mettre en brouillon --}}
                                                    <button onclick="showDeleteModal()" 
                                                        class="w-full flex items-center px-4 py-2 text-sm text-red-400 hover:bg-gray-700 transition-colors text-left">
                                                        <i class="fas fa-trash mr-3 w-4"></i>Supprimer
                                                    </button>
                                                    <a href="{{ route('articles.edit', $article->id) }}" 
                                                        class="flex items-center px-4 py-2 text-sm text-blue-400 hover:bg-gray-700 transition-colors">
                                                        <i class="fas fa-edit mr-3 w-4"></i>Éditer
                                                    </a>
                                                    <button onclick="showToDraftModal()" 
                                                        class="w-full flex items-center px-4 py-2 text-sm text-yellow-400 hover:bg-gray-700 transition-colors text-left">
                                                        <i class="fas fa-file-alt mr-3 w-4"></i>Mettre en brouillon
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Corps de l'article -->
                    <div class="article-body" dir="{{ $article->text_direction ?? 'auto' }}">
                        {!! $article->corps !!}
                    </div>

                    <!-- Section des commentaires -->
                    <div id="comment-form">
                        @if($article->is_deleted)
                            <div class="bg-yellow-800 text-yellow-100 px-4 py-3 rounded mb-6">
                                <p class="text-center font-semibold">Les commentaires sont désactivés pour cet article supprimé.</p>
                                @if(Auth::check() && Auth::user()->role !== 'user')
                                    <p class="text-center mt-2">Veuillez d'abord restaurer cet article pour activer les commentaires.</p>
                                @endif
                            </div>
                        @elseif($article->status === 'draft')
                            <div class="bg-yellow-800 text-yellow-100 px-4 py-3 rounded mb-6">
                                <p class="text-center font-semibold">Les commentaires sont désactivés pour cet article en brouillon.</p>
                                @if(Auth::check() && (Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && $article->created_by === Auth::id())))
                                    <p class="text-center mt-2">Veuillez d'abord publier cet article pour activer les commentaires.</p>
                                @endif
                            </div>
                        @elseif(Auth::check() && auth()->user()->is_active)
                            <textarea id="comment-input" placeholder="Ajouter un commentaire..." rows="4"></textarea>
                            <div class="comment-form-buttons">
                                <button class="cancel-btn" onclick="document.getElementById('comment-input').value = '';">Annuler</button>
                                <button id="comment-submit-btn" onclick="addComment('{{ $article->id }}', null, null)">Commenter</button>
                            </div>
                        @else
                            @if(Auth::check() && !auth()->user()->is_active) Votre compte est inactif. Veuillez contacter l'administrateur pour activer votre compte. @else Vous devez être connecté pour laisser un commentaire. @endif
                            @if(!Auth::check())
                                <div class="text-center text-gray-400">
                                    <p class="mb-4">Vous devez être connecté pour laisser un commentaire.</p>
                                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Se connecter</a>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div id="comments-container">
                        <!-- Les commentaires seront insérés ici via JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Inclusion du pied de page -->
            @include('components.footer')
        </div>
    </div>
    <!-- Modal de restauration -->
    <div id="restoreModal" class="modal hidden">
        <div class="modal-content">
            <h3 class="text-xl font-bold text-white mb-4">Restaurer l'article</h3>
            <p class="text-gray-300 mb-6">Comment souhaitez-vous restaurer cet article ?</p>
            <div class="flex flex-col gap-3">
                <form action="{{ route('articles.restore', $article->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="publish" value="1">
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Restaurer et publier
                    </button>
                </form>
                <form action="{{ route('articles.restore', $article->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="publish" value="0">
                    <button type="submit" class="w-full bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                        Restaurer comme brouillon
                    </button>
                </form>
                <button type="button" class="w-full bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" 
                        onclick="document.getElementById('restoreModal').classList.add('hidden')">
                    Annuler
                </button>
            </div>
        </div>
    </div>



<!-- Modal de confirmation de suppression de commentaire -->
<div id="deleteCommentModal" class="modal hidden">
    <div class="modal-content relative">
        <!-- Icône de fermeture -->
        <button onclick="closeDeleteCommentModal()" class="absolute top-3 right-3 text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <!-- Icône d'avertissement -->
        <div class="flex justify-center mb-4">
            <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
        
        <!-- Titre -->
        <h3 class="text-xl font-bold text-white mb-2 text-center">
            Supprimer le commentaire
        </h3>
        
        <!-- Message -->
        <p class="text-gray-300 mb-6 text-center leading-relaxed">
            Êtes-vous sûr de vouloir supprimer ce commentaire ?<br>
            <span class="text-sm text-gray-400">Cette action est irréversible.</span>
        </p>
        
        <!-- Boutons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button 
                type="button" 
                onclick="closeDeleteCommentModal()" 
                class="flex-1 sm:flex-none px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200 hover:scale-105">
                <i class="fas fa-times mr-2"></i>
                Annuler
            </button>
            <button 
                type="button" 
                id="confirmDeleteCommentBtn"
                onclick="confirmDeleteComment()" 
                class="flex-1 sm:flex-none px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-all duration-200 hover:scale-105">
                <i class="fas fa-trash mr-2"></i>
                Supprimer
            </button>
        </div>
    </div>
</div>

    <script>
    // Variable pour stocker tous les commentaires
    let allComments = [];

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    // Informations sur l'utilisateur actuel et l'article
    const currentUser = {
        name: '{{ Auth::check() ? Auth::user()->name : '' }}',
        role: '{{ Auth::check() ? Auth::user()->role : '' }}', 
        hasArticleModule: @if(isset($userHasArticleModule)) {{ $userHasArticleModule ? 'true' : 'false' }} @else false @endif,
        isAuthenticated: {{ Auth::check() ? 'true' : 'false' }}
    };
    const currentArticle = {
        id: '{{ $article->id }}',
        isDeleted: {{ $article->is_deleted ? 'true' : 'false' }},
        isDraft: {{ $article->status === 'draft' ? 'true' : 'false' }}
    };

    // ===== SECTION MENU KEBAB =====
    
    // Fonction principale pour le menu kebab
    function toggleKebabMenu() {
        const menu = document.getElementById('kebab-menu');
        const button = document.getElementById('kebab-button');
        
        console.log('toggleKebabMenu appelée');
        console.log('Menu trouvé:', !!menu);
        console.log('Bouton trouvé:', !!button);
        
        if (!menu) {
            console.error('Menu kebab (#kebab-menu) non trouvé dans le DOM');
            return;
        }
        
        if (!button) {
            console.error('Bouton kebab (#kebab-button) non trouvé dans le DOM');
            return;
        }
        
        // Basculer la visibilité du menu
        const isCurrentlyHidden = menu.classList.contains('hidden');
        
        if (isCurrentlyHidden) {
            menu.classList.remove('hidden');
            button.classList.add('bg-gray-700');
            console.log('Menu kebab ouvert');
        } else {
            menu.classList.add('hidden');
            button.classList.remove('bg-gray-700');
            console.log('Menu kebab fermé');
        }
    }

    // Fonction pour fermer le menu
    function closeKebabMenu() {
        const menu = document.getElementById('kebab-menu');
        const button = document.getElementById('kebab-button');
        
        if (menu && button) {
            menu.classList.add('hidden');
            button.classList.remove('bg-gray-700');
            console.log('Menu kebab fermé par closeKebabMenu()');
        }
    }

    // Fonctions pour les modales
    function showDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.classList.remove('hidden');
            console.log('Modal de suppression ouverte');
        } else {
            console.error('Modal deleteModal non trouvée');
        }
        closeKebabMenu();
    }

    function showPublishModal() {
        const modal = document.getElementById('publishModal');
        if (modal) {
            modal.classList.remove('hidden');
            console.log('Modal de publication ouverte');
        } else {
            console.error('Modal publishModal non trouvée');
        }
        closeKebabMenu();
    }

    function showToDraftModal() {
        const modal = document.getElementById('draftModal');
        if (modal) {
            modal.classList.remove('hidden');
            console.log('Modal de brouillon ouverte');
        } else {
            console.error('Modal draftModal non trouvée');
        }
        closeKebabMenu();
    }

    function showRestoreModal() {
        const modal = document.getElementById('restoreModal');
        if (modal) {
            modal.classList.remove('hidden');
            console.log('Modal de restauration ouverte');
        } else {
            console.error('Modal restoreModal non trouvée');
        }
        closeKebabMenu();
    }

    // ===== SECTION COMMENTAIRES =====
    
    // Récupérer les commentaires
    async function fetchComments(articleId, retryCount = 3) {
        console.log(`Récupération des commentaires pour l'article ID: ${articleId}`);
        const commentsContainer = document.getElementById('comments-container');
        if (currentArticle.isDeleted || currentArticle.isDraft) {
            commentsContainer.innerHTML = `<div class="bg-yellow-800 text-yellow-100 px-4 py-3 rounded mb-6"><p class="text-center font-semibold">Les commentaires sont désactivés pour cet article.</p></div>`;
            return;
        }
        if (currentUser.isAuthenticated && !{{ Auth::check() && auth()->user()->is_active ? 'true' : 'false' }}) {
            commentsContainer.innerHTML = `<div class="bg-yellow-800 text-yellow-100 px-4 py-3 rounded mb-6"><p class="text-center font-semibold">Votre compte est inactif. Veuillez contacter l'administrateur.</p></div>`;
            return;
        }
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000);
        try {
        const response = await fetch(`/articles/comments/${articleId}`, {                headers: { 'Accept': 'application/json' },
                signal: controller.signal
            });
            clearTimeout(timeoutId);
            if (!response.ok) throw new Error(`Erreur HTTP ${response.status}`);
            const data = await response.json();
            if (data.error) throw new Error(data.error);
            allComments = normalizeComments(data.comments || []);
            allComments.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
            displayComments(allComments);
        } catch (error) {
            console.error('Erreur dans fetchComments:', error);
            commentsContainer.innerHTML = `<div class="error-message">Erreur lors du chargement des commentaires : ${error.message}<button onclick="fetchComments('${articleId}')" class="retry-btn">Réessayer</button></div>`;
        }
    }

    // Fonction de normalisation des commentaires
    function normalizeComments(comments) {
    console.log('[normalizeComments] Normalisation des commentaires:', comments);
    if (!Array.isArray(comments)) {
        console.warn('[normalizeComments] Les commentaires ne sont pas un tableau:', comments);
        return [];
    }

    return comments.map(comment => {
        if (!comment || !comment.id) {
            console.warn('[normalizeComments] Commentaire invalide:', comment);
            return null;
        }

        return {
            id: String(comment.id),
            author: comment.author || 'Anonyme',
            content: comment.content || '',
            timestamp: comment.timestamp || new Date().toISOString(),
            reported: comment.reported || false,
            replies: Array.isArray(comment.replies) ? comment.replies.map(reply => ({
                id: String(reply.id),
                author: reply.author || 'Anonyme',
                content: reply.content || '',
                timestamp: reply.timestamp || new Date().toISOString(),
                parentId: String(reply.parentId),
                parentReplyId: reply.parentReplyId ? String(reply.parentReplyId) : null,
                reported: reply.reported || false,
                replies: reply.replies || []
            })) : []
        };
    }).filter(comment => comment !== null);
}

    // Afficher les commentaires
function displayComments(comments) {
    console.log('[displayComments] Affichage des commentaires:', comments);
    const commentsContainer = document.getElementById('comments-container');
    if (!commentsContainer) {
        console.error('[displayComments] Conteneur #comments-container introuvable');
        return;
    }

    commentsContainer.innerHTML = '';
    const validComments = comments.filter(c => !c.is_deleted && !c.reported);
    if (!validComments || validComments.length === 0) {
        console.log('[displayComments] Aucun commentaire à afficher');
        commentsContainer.innerHTML = '<div class="no-comments">Aucun commentaire pour le moment. Soyez le premier à commenter!</div>';
        return;
    }
    
    console.log('Affichage des commentaires avec:', JSON.parse(JSON.stringify(comments)));
    
    const renderComment = (comment, level = 0, parentChain = []) => {
        const commentId = String(comment.id);
        const isOwnComment = comment.author === currentUser.name;
        const isSuperAdmin = currentUser.role === 'superadmin';
        const isAdminWithModule = currentUser.role === 'admin' && currentUser.hasArticleModule;
        const canDeleteComment = isOwnComment || isSuperAdmin || isAdminWithModule; 
        const commentContent = comment.content || '';
        const isReported = comment.reported || false;
        
        const commentElement = document.createElement('div');
        commentElement.className = `comment ${level > 0 ? 'reply' : ''}`;
        commentElement.id = `comment-${commentId}`;
        commentElement.dataset.level = level;
        
        commentElement.innerHTML = `
            <div class="comment-content">
                <span class="comment-author">${comment.author}</span>
                <span class="comment-timestamp">${new Date(comment.timestamp).toLocaleString('fr-FR')}</span>
                <div class="comment-text">${commentContent}</div>
                <div class="comment-actions">
                    <button class="reply-btn" data-comment-id="${commentId}" 
                        onclick="toggleReplyForm('${commentId}', '${parentChain[0] || commentId}', ${level > 0 ? `'${commentId}'` : 'null'})">
                        Répondre
                    </button>
                    ${canDeleteComment ? 
                    `<button class="delete-btn" data-comment-id="${commentId}" 
                       onclick="deleteComment('${commentId}', '${parentChain[0] || ''}', '${level > 1 ? parentChain[1] || commentId : ''}')">
                       Supprimer
                    </button>` : 
                    `<button class="report-btn" data-comment-id="${commentId}"
                       onclick="showReportForm('${commentId}')"
                       ${isReported ? 'disabled' : ''}>
                       ${isReported ? 'Signalé' : 'Signaler'}
                    </button>`}
                </div>
                <div id="reply-form-${commentId}" class="reply-form" style="display: none;">
                    <textarea id="reply-input-${commentId}" placeholder="Répondre à ${comment.author}..." rows="3"></textarea>
                    <div class="reply-form-buttons">
                        <button class="cancel-reply-btn" 
                            onclick="toggleReplyForm('${commentId}', '${parentChain[0] || commentId}', ${level > 0 ? `'${commentId}'` : 'null'})">
                            Annuler
                        </button>
                        <button onclick="addComment('${currentArticle.id}', '${parentChain[0] || commentId}', '${level > 0 ? commentId : ''}')">
                            Répondre
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Gestion des réponses
        if (comment.replies && Array.isArray(comment.replies) && comment.replies.length > 0) {
            const replyCount = countTotalReplies(comment.replies);
            
            const repliesToggle = document.createElement('button');
            repliesToggle.className = 'replies-toggle';
            repliesToggle.id = `replies-toggle-${commentId}`;
            repliesToggle.innerHTML = `${replyCount} réponse${replyCount !== 1 ? 's' : ''}`;
            repliesToggle.onclick = function() { toggleReplies(commentId); };
            
            const repliesContainer = document.createElement('div');
            repliesContainer.className = 'replies-container';
            repliesContainer.id = `replies-container-${commentId}`;
            repliesContainer.style.display = 'block';
            repliesContainer.style.maxWidth = '100%';
            repliesContainer.style.overflow = 'hidden';
            
            const newParentChain = [parentChain[0] || commentId, commentId];
            const sortedReplies = [...comment.replies].sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
            
            sortedReplies.forEach(reply => {
                repliesContainer.appendChild(renderComment(reply, level + 1, newParentChain));
            });
            
            commentElement.querySelector('.comment-content').appendChild(repliesToggle);
            commentElement.querySelector('.comment-content').appendChild(repliesContainer);
        }
        
        return commentElement;
    };
    
    const mainComments = comments.filter(comment => !comment.parentId);
    mainComments.forEach(comment => {
        commentsContainer.appendChild(renderComment(comment));
    });
}

    // Compter les réponses
    function countTotalReplies(replies) {
        if (!Array.isArray(replies)) return 0;
        return replies.reduce((count, reply) => count + 1 + countTotalReplies(reply.replies || []), 0);
    }

    // Basculer le formulaire de réponse
    function toggleReplyForm(commentId, parentCommentId, parentReplyId) {
        console.log(`Toggle reply form: commentId=${commentId}, parentCommentId=${parentCommentId}, parentReplyId=${parentReplyId}`);
        
        // Vérifier si l'article est supprimé ou en brouillon
        if (currentArticle.isDeleted || currentArticle.isDraft) {
            alert('Les commentaires sont désactivés pour cet article.');
            return;
        }

        if (!currentUser.name) {
            console.error('Utilisateur non connecté');
            toggleLoginModal(true);
            return;
        }
        const replyForm = document.getElementById(`reply-form-${commentId}`);
        const replyBtn = document.querySelector(`button.reply-btn[data-comment-id="${commentId}"]`);
        if (!replyForm || !replyBtn) return;
        const isHidden = replyForm.style.display === 'none' || replyForm.style.display === '';
        replyForm.style.display = isHidden ? 'block' : 'none';
        replyBtn.classList.toggle('active', isHidden);
        if (!isHidden) {
            document.getElementById(`reply-input-${commentId}`).value = '';
        }
    }

    // Basculer l'affichage des réponses
    function toggleReplies(commentId) {
        const repliesContainer = document.getElementById(`replies-container-${commentId}`);
        const toggleButton = document.getElementById(`replies-toggle-${commentId}`);
        if (!repliesContainer || !toggleButton) return;

        const isHidden = repliesContainer.style.display === 'none';
        repliesContainer.style.display = isHidden ? 'block' : 'none';
        toggleButton.classList.toggle('active', !isHidden);

        // Changer le texte du bouton
        const replyCount = toggleButton.textContent.match(/\d+/)[0];
        toggleButton.innerHTML = isHidden ? 
            `Masquer les ${replyCount} réponse${replyCount !== '1' ? 's' : ''}` : 
            `${replyCount} réponse${replyCount !== '1' ? 's' : ''}`;
    }

    // Ajouter un commentaire
    async function addComment(articleId, parentCommentId = null, parentReplyId = null) {
        console.log('addComment appelé avec:', { articleId, parentCommentId, parentReplyId });
        
        // Vérifier si l'article est supprimé ou en brouillon
        if (currentArticle.isDeleted || currentArticle.isDraft) {
            alert('Les commentaires sont désactivés pour cet article.');
            return;
        }
        if (!currentUser.name) {
            toggleLoginModal(true);
            return;
        }
        const inputId = parentCommentId ? (parentReplyId ? `reply-input-${parentReplyId}` : `reply-input-${parentCommentId}`) : 'comment-input';
        const commentInput = document.getElementById(inputId);
        if (!commentInput) {
            alert('Erreur : champ de saisie introuvable.');
            return;
        }
        const commentText = commentInput.value.trim();
        if (commentText === '') {
            alert('Veuillez entrer un commentaire.');
            return;
        }
        const submitButton = parentCommentId ? commentInput.parentElement.querySelector('button:last-child') : document.getElementById('comment-submit-btn');
        try {
            commentInput.disabled = true;
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Envoi...';
            }
            const endpoint = parentCommentId ? '/articles/reply' : '/articles/comment';
            const body = parentCommentId 
                ? { comment_id: parentCommentId, parent_reply_id: parentReplyId || null, content: commentText }
                : { article_id: articleId, content: commentText };
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(body),
            });
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || `Erreur HTTP ${response.status}`);
            }
            const result = await response.json();
            if (result.error) {
                throw new Error(result.error);
            }
            const newComment = {
                ...result,
                id: String(result.id),
                parentId: result.parentId ? String(result.parentId) : null,
                parentReplyId: result.parentReplyId ? String(result.parentReplyId) : null,
                replies: []
            };
            if (parentCommentId) {
                integrateReply(allComments, newComment, String(parentCommentId), parentReplyId ? String(parentReplyId) : null);
            } else {
                allComments.unshift(newComment);
                allComments.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
            }
            displayComments(allComments);
            commentInput.value = '';
            if (parentCommentId || parentReplyId) {
                const targetId = parentReplyId || parentCommentId;
                const replyForm = document.getElementById(`reply-form-${targetId}`);
                if (replyForm) replyForm.style.display = 'none';
                const replyBtn = document.querySelector(`button.reply-btn[data-comment-id="${targetId}"]`);
                if (replyBtn) replyBtn.classList.remove('active');
                const repliesContainer = document.getElementById(`replies-container-${parentCommentId}`);
                const toggleButton = document.getElementById(`replies-toggle-${parentCommentId}`);
                if (repliesContainer && toggleButton) {
                    repliesContainer.style.display = 'block';
                    toggleButton.classList.add('active');
                    const replyCount = countTotalReplies(findCommentById(allComments, parentCommentId).replies);
                    toggleButton.innerHTML = `<span>${replyCount}</span> réponse${replyCount !== 1 ? 's' : ''}`;
                }
            }
        } catch (error) {
            alert('Erreur lors de l\'ajout du commentaire: ' + error.message);
        } finally {
            commentInput.disabled = false;
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = (parentCommentId || parentReplyId) ? 'Répondre' : 'Commenter';
            }
        }
    }

    // Intégrer une réponse
    function integrateReply(comments, newReply, parentCommentId, parentReplyId = null) {
    const integrate = (reply, commentsList) => {
        commentsList.forEach(comment => {
            if (String(comment.id) === parentCommentId) {
                if (!parentReplyId) {
                    comment.replies = comment.replies || [];
                    comment.replies.push(reply);
                } else {
                    const integrateIntoReplies = (replies) => {
                        replies.forEach(r => {
                            if (String(r.id) === parentReplyId) {
                                r.replies = r.replies || [];
                                r.replies.push(reply);
                            } else if (r.replies && r.replies.length) {
                                integrateIntoReplies(r.replies);
                            }
                        });
                    };
                    integrateIntoReplies(comment.replies);
                }
            } else if (comment.replies && comment.replies.length) {
                integrate(reply, comment.replies);
            }
        });
    };
    integrate(newReply, comments);
}

    // Trouver un commentaire
    function findCommentById(comments, commentId) {
        if (!Array.isArray(comments)) return null;
        return comments.find(comment => String(comment.id) === String(commentId));
    }

    // Trouver une réponse
    function findReplyById(replies, replyId) {
        if (!Array.isArray(replies)) {
            console.warn('findReplyById: replies n\'est pas un tableau', replies);
            return null;
        }
        for (const reply of replies) {
            if (String(reply.id) === String(replyId)) {
                console.log('Réponse trouvée:', reply);
                return reply;
            }
            if (Array.isArray(reply.replies)) {
                const foundReply = findReplyById(reply.replies, replyId);
                if (foundReply) return foundReply;
            }
        }
        console.warn('Réponse non trouvée pour replyId:', replyId);
        return null;
    }

    // ===== SECTION SUPPRESSION DE COMMENTAIRES =====

    // Variables pour stocker les informations de suppression
    let deleteCommentData = {
        commentId: null,
        parentCommentId: null,
        parentReplyId: null
    };

    // Supprimer un commentaire
    async function deleteComment(commentId, parentCommentId = '', parentReplyId = '') {
        // Afficher la modale de confirmation au lieu de confirm()
        showDeleteCommentModal(commentId, parentCommentId, parentReplyId);
    }

    // Fonction pour ouvrir la modale de suppression
    function showDeleteCommentModal(commentId, parentCommentId = '', parentReplyId = '') {
        deleteCommentData = { commentId, parentCommentId, parentReplyId };
        const modal = document.getElementById('deleteCommentModal');
        document.body.classList.add('modal-open');
        modal.classList.remove('hidden');
        modal.querySelector('.modal-content').classList.add('modal-enter');
        setTimeout(() => modal.querySelector('button').focus(), 100);
    }

    function closeDeleteCommentModal() {
        const modal = document.getElementById('deleteCommentModal');
        const modalContent = modal.querySelector('.modal-content');
        
        modalContent.classList.remove('modal-enter');
        modalContent.classList.add('modal-exit');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modalContent.classList.remove('modal-exit');
            document.body.classList.remove('modal-open');
            deleteCommentData = {
                commentId: null,
                parentCommentId: null,
                parentReplyId: null
            };
        }, 300);
    }

    // Confirmer la suppression
    async function confirmDeleteComment() {
    const { commentId, parentCommentId, parentReplyId } = deleteCommentData;
    
    if (!commentId) {
        console.error('Aucun commentaire sélectionné pour suppression');
        return;
    }
    
    const confirmBtn = document.getElementById('confirmDeleteCommentBtn');
    const originalContent = confirmBtn.innerHTML;
    
    // Désactiver le bouton et afficher le loading
    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Suppression...';
    
    try {
        const endpoint = parentCommentId ? `/articles/reply/${commentId}` : `/articles/comment/${commentId}`;
        
        const response = await fetch(endpoint, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error || `Erreur HTTP ${response.status}`);
        }

        // Fermer la modale
        closeDeleteCommentModal();
        
        // Animation de suppression
        const commentElement = document.getElementById(`comment-${commentId}`);
        if (commentElement) {
            commentElement.style.transition = 'all 0.5s ease';
            commentElement.style.opacity = '0';
            commentElement.style.transform = 'translateX(-20px) scale(0.95)';
            
            setTimeout(() => {
                // Mettre à jour la structure des données
                if (parentCommentId) {
                    removeReplyFromComments(allComments, commentId, parentCommentId);
                } else {
                    allComments = allComments.filter(comment => String(comment.id) !== String(commentId));
                }
                
                // Réafficher les commentaires
                displayComments(allComments);
                
                // Afficher une notification de succès CENTRÉE
                showSuccessNotification('Commentaire supprimé avec succès');
            }, 500);
        }
    } catch (error) {
        console.error('Erreur lors de la suppression:', error);
        
        // Afficher une notification d'erreur CENTRÉE
        showErrorNotification(`Erreur lors de la suppression: ${error.message}`);
        
        // Fermer la modale en cas d'erreur
        closeDeleteCommentModal();
    } finally {
        // Restaurer le bouton
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = originalContent;
    }
}

    function removeReplyFromComments(comments, replyId, parentCommentId) {
        const parentComment = findCommentById(comments, parentCommentId);
        if (parentComment && parentComment.replies) {
            // Fonction récursive pour supprimer la réponse
            function removeReplyRecursive(replies) {
                for (let i = 0; i < replies.length; i++) {
                    if (String(replies[i].id) === String(replyId)) {
                        replies.splice(i, 1);
                        return true; 
                    }
                    if (replies[i].replies && replies[i].replies.length > 0) {
                        if (removeReplyRecursive(replies[i].replies)) {
                            return true;
                        }
                    }
                }
                return false;
            }
            
            removeReplyRecursive(parentComment.replies);
        }
    }

    // Mettre à jour le compteur de réponses
    function updateReplyCounter(elementId, replies) {
        const repliesToggle = document.getElementById(`replies-toggle-${elementId}`);
        if (repliesToggle) {
            const replyCount = countTotalReplies(replies);
            repliesToggle.innerHTML = `<span>${replyCount}</span> réponse${replyCount !== 1 ? 's' : ''}`;
            if (replyCount === 0) {
                repliesToggle.style.display = 'none';
                const repliesContainer = document.getElementById(`replies-container-${elementId}`);
                if (repliesContainer) repliesContainer.style.display = 'none';
            } else {
                repliesToggle.style.display = 'block';
            }
        }
    }

    // ===== SECTION PARTAGE =====
    
    // Partager l'article
    function sharePodcast(url, title) {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url,
            }).then(() => {
                console.log('Partage réussi');
            }).catch(err => {
                console.error('Erreur de partage:', err);
            });
        } else {
            const shareOptions = `
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
                        <h3 class="text-lg font-bold text-white mb-2">Partager "${title}"</h3>
                        <p class="mb-4 text-gray-300">Copiez ce lien :</p>
                        <input type="text" value="${url}" readonly class="w-full p-2 border rounded mb-4 bg-gray-700 text-white">
                        <div class="flex flex-wrap gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded">Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}" target="_blank" class="bg-sky-500 text-white px-4 py-2 rounded">Twitter</a>
                            <a href="https://www.linkedin.com/shareArticle?url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}" target="_blank" class="bg-blue-700 text-white px-4 py-2 rounded">LinkedIn</a>
                            <button onclick="navigator.clipboard.writeText('${url}'); alert('Lien copié !');" class="bg-gray-600 text-white px-4 py-2 rounded">Copier</button>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded w-full">Fermer</button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', shareOptions);
        }
    }

    // ===== SECTION SIGNALEMENT =====
    
    // Afficher le formulaire de signalement
    function showReportForm(commentId) {
    console.log('=== OUVERTURE MODAL SIGNALEMENT ===');
    console.log('Comment ID:', commentId);
    
    // Vérifier que l'ID du commentaire est valide
    if (!commentId || commentId === 'undefined' || commentId === 'null') {
        console.error('ID de commentaire invalide:', commentId);
        showErrorNotification('Erreur: ID de commentaire invalide');
        return;
    }
    
    // Vérifier que l'utilisateur est connecté
    if (!currentUser.isAuthenticated) {
        console.log('Utilisateur non connecté, ouverture modal de connexion');
        toggleLoginModal(true);
        return;
    }
    
    // Réinitialiser le formulaire
    document.getElementById('reportedCommentId').value = commentId;
    document.getElementById('reportReason').selectedIndex = 0;
    document.getElementById('reportDescription').value = '';
    
    // Afficher la modal
    const modal = document.getElementById('reportModal');
    modal.classList.remove('hidden');
    
    console.log('Modal de signalement ouverte pour le commentaire:', commentId);
}

// Fermer le modal de signalement
function closeReportModal() {
    const modal = document.getElementById('reportModal');
    modal.classList.add('hidden');
    
    // Réinitialiser les données
    document.getElementById('reportedCommentId').value = '';
    document.getElementById('reportReason').selectedIndex = 0;
    document.getElementById('reportDescription').value = '';
}

// Soumettre un signalement - VERSION AMÉLIORÉE
async function submitReport() {
    const commentId = document.getElementById('reportedCommentId').value;
    const reason = document.getElementById('reportReason').value;
    const description = document.getElementById('reportDescription').value;
    const submitBtn = document.getElementById('submitReportBtn');
    
    console.log('=== DÉBUT SIGNALEMENT ===');
    console.log('Comment ID:', commentId);
    console.log('Reason:', reason);
    console.log('Description:', description);
    console.log('URL actuelle:', window.location.href);
    
    // Vérifications préliminaires renforcées
    if (!commentId || commentId.trim() === '') {
        console.error('ID du commentaire manquant ou vide');
        showErrorNotification('Erreur: ID du commentaire manquant');
        return;
    }
    
    if (!reason || reason.trim() === '') {
        console.error('Raison du signalement manquante');
        showReportError('Veuillez sélectionner une raison pour le signalement');
        return;
    }
    
    // Désactiver le bouton pendant l'envoi
    submitBtn.disabled = true;
    const originalText = submitBtn.textContent;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Envoi en cours...';
    
    try {
        // Récupération du token CSRF avec validation renforcée
        const csrfToken = getCsrfToken();
        if (!csrfToken) {
            throw new Error('Impossible de récupérer le token CSRF. Veuillez actualiser la page.');
        }
        
        console.log('Token CSRF récupéré:', csrfToken.substring(0, 10) + '...');
        
        // Préparer les données à envoyer
        const requestData = {
            comment_id: parseInt(commentId, 10), // S'assurer que c'est un nombre
            reason_category: reason,
            reason_details: description.trim() || '',
            article_id: parseInt(currentArticle.id, 10), // Ajouter l'ID de l'article
            _token: csrfToken // Ajouter explicitement le token
        };
        
        console.log('Données à envoyer:', requestData);
        
        // Construire l'URL complète
        const baseUrl = window.location.origin;
        const endpoint = `${baseUrl}/articles/report-comment`;
        
        console.log('URL de la requête:', endpoint);
        
        // Effectuer la requête
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            },
            body: JSON.stringify(requestData),
            credentials: 'same-origin'
        });
        
        console.log('Réponse reçue - Status:', response.status);
        console.log('Content-Type:', response.headers.get('content-type'));
        
        // Gérer la réponse
        let responseData;
        const contentType = response.headers.get('content-type') || '';
        
        if (contentType.includes('application/json')) {
            responseData = await response.json();
            console.log('Données JSON reçues:', responseData);
        } else {
            // Si la réponse n'est pas JSON, récupérer le texte pour debug
            const responseText = await response.text();
            console.error('Réponse non-JSON reçue:', responseText.substring(0, 1000));
            
            // Essayer de détecter le type d'erreur
            if (responseText.includes('<!DOCTYPE html>')) {
                if (responseText.includes('419') || responseText.includes('csrf')) {
                    throw new Error('Session expirée. Veuillez actualiser la page et réessayer.');
                } else if (responseText.includes('500')) {
                    throw new Error('Erreur interne du serveur. Veuillez réessayer plus tard.');
                } else if (responseText.includes('404')) {
                    throw new Error('Route non trouvée. Veuillez vérifier la configuration.');
                } else {
                    throw new Error('Erreur du serveur. Veuillez actualiser la page et réessayer.');
                }
            } else {
                throw new Error('Réponse invalide du serveur. Format de réponse inattendu.');
            }
        }
        
        // Vérifier le statut de la réponse
        if (!response.ok) {
            console.error('Erreur HTTP:', response.status, response.statusText);
            
            // Gestion des erreurs spécifiques
            if (response.status === 419) {
                throw new Error('Session expirée. Veuillez actualiser la page et vous reconnecter.');
            } else if (response.status === 422) {
                // Erreur de validation
                const errors = responseData.errors || responseData.details || {};
                const errorMessages = Object.values(errors).flat();
                const errorMessage = errorMessages.length > 0 
                    ? errorMessages.join(', ') 
                    : responseData.message || responseData.error || 'Données de validation invalides';
                throw new Error(`Erreur de validation: ${errorMessage}`);
            } else if (response.status === 401) {
                throw new Error('Non autorisé. Veuillez vous connecter et réessayer.');
            } else if (response.status === 403) {
                throw new Error('Accès interdit. Vous n\'avez pas les permissions nécessaires.');
            } else if (response.status === 404) {
                throw new Error('Route non trouvée. Veuillez vérifier la configuration du serveur.');
            } else if (response.status >= 500) {
                throw new Error('Erreur interne du serveur. Veuillez réessayer plus tard.');
            } else {
                throw new Error(responseData.error || responseData.message || `Erreur HTTP ${response.status}`);
            }
        }
        
        // Succès
        console.log('Signalement envoyé avec succès');
        
        // Fermer la modal
        closeReportModal();
        
        // Mettre à jour l'interface utilisateur
        updateCommentReportStatus(commentId, true);
        
        // Mettre à jour le bouton de signalement dans le DOM
        const commentElement = document.getElementById(`comment-${commentId}`);
        if (commentElement) {
            const reportBtn = commentElement.querySelector('.report-btn');
            if (reportBtn) {
                reportBtn.disabled = true;
                reportBtn.classList.add('text-gray-500', 'cursor-not-allowed');
                reportBtn.classList.remove('text-orange-500', 'hover:text-red-500');
                reportBtn.textContent = 'Signalé';
                reportBtn.onclick = null; // Supprimer l'événement click
            }
        }
        
        // Afficher le message de succès
        showSuccessNotification('Merci pour votre signalement. Notre équipe va l\'examiner rapidement.');
        
    } catch (error) {
        console.error('Erreur lors du signalement:', error);
        showErrorNotification(error.message || 'Erreur lors du signalement. Veuillez réessayer.');
    } finally {
        // Restaurer le bouton dans tous les cas
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        
        console.log('=== FIN SIGNALEMENT ===');
    }
}

// Fonction utilitaire pour récupérer le token CSRF
function getCsrfToken() {
    // Méthode 1: Meta tag (recommandée)
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
        const token = metaTag.getAttribute('content');
        if (token && token.trim().length > 0) {
            console.log('Token CSRF trouvé via meta tag');
            return token.trim();
        }
    }
    console.error('Aucun token CSRF trouvé');
    return null;
}

    // Fonction pour mettre à jour le statut de signalement dans les données
function updateCommentReportStatus(commentId, reported) {
    console.log(`Mise à jour du statut de signalement pour le commentaire ${commentId}: ${reported}`);
    
    function updateInComments(comments) {
        for (const comment of comments) {
            if (String(comment.id) === String(commentId)) {
                comment.reported = reported;
                console.log(`Statut mis à jour pour le commentaire ${commentId}`);
                return true;
            }
            
            if (comment.replies && Array.isArray(comment.replies)) {
                if (updateInComments(comment.replies)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    return updateInComments(allComments);
}

    // ===== SECTION NOTIFICATIONS =====
    
    // Fonction pour afficher les notifications
    function showSuccessNotification(message) {
        showNotification(message, 'success');
    }

    function showErrorNotification(message) {
        showNotification(message, 'error');
    }

    function showNotification(message, type = 'success') {
    // Supprimer les notifications existantes
    const existingNotifications = document.querySelectorAll('.toast-notification');
    existingNotifications.forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    
    notification.className = `toast-notification fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-2xl z-[9999] max-w-md opacity-0 transform translate-x-full transition-all duration-300`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-3 text-lg flex-shrink-0"></i>
            <span class="flex-1 text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-gray-200 transition-colors flex-shrink-0">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animation d'apparition
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto-suppression après 5 secondes
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }
    }, 5000);
}

// Gestionnaire d'événements pour fermer la modal en cliquant en dehors
document.addEventListener('click', function(event) {
    const modal = document.getElementById('reportModal');
    if (event.target === modal) {
        closeReportModal();
    }
});

// Gestionnaire pour la touche Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('reportModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeReportModal();
        }
    }
});

    // ===== SECTION MODALE DE CONNEXION =====
    
    // Gérer la modale de connexion
    function toggleLoginModal(show = true) {
        const modal = document.getElementById('login-modal');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            const modalContent = modal.querySelector('div');
            modalContent.classList.add('animate__animated', 'animate__fadeInDown');
            document.body.style.overflow = 'hidden';
        } else {
            const modalContent = modal.querySelector('div');
            modalContent.classList.add('animate__animated', 'animate__fadeOutUp');
            setTimeout(() => {
                modal.classList.add('hidden');
                modalContent.classList.remove('animate__animated', 'animate__fadeOutUp');
                document.body.style.overflow = 'auto';
            }, 300);
        }
    }

    // ===== SECTION ÉVÉNEMENTS =====
    
    // Gestionnaire d'événements pour fermer le menu kebab en cliquant ailleurs
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('kebab-menu');
        const button = document.getElementById('kebab-button');
        
        // Vérifier si le menu existe et est visible
        if (menu && !menu.classList.contains('hidden')) {
            // Si le clic n'est ni sur le bouton ni dans le menu, fermer le menu
            if (button && !button.contains(event.target) && !menu.contains(event.target)) {
                closeKebabMenu();
            }
        }
    });

    // Fermer la modale de suppression en cliquant en dehors
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('deleteCommentModal');
        if (event.target === modal) {
            closeDeleteCommentModal();
        }
    });

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('deleteCommentModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeDeleteCommentModal();
            }
        }
    });

    // ===== SECTION INITIALISATION =====
    
    // Gestion de l'en-tête et initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction de debug pour vérifier la présence des éléments
        console.log('=== DEBUG MENU KEBAB ===');
        console.log('Bouton kebab:', document.getElementById('kebab-button'));
        console.log('Menu kebab:', document.getElementById('kebab-menu'));
        console.log('Modales disponibles:');
        console.log('- deleteModal:', document.getElementById('deleteModal'));
        console.log('- publishModal:', document.getElementById('publishModal'));
        console.log('- draftModal:', document.getElementById('draftModal'));
        console.log('- restoreModal:', document.getElementById('restoreModal'));
        console.log('========================');

        const authButtons = document.querySelector('.auth-buttons');
        const userProfile = document.querySelector('.user-profile');
        const userAvatar = document.querySelector('.user-avatar');
        const userName = document.querySelector('.user-name');
        const isLoggedIn = <?php echo auth()->check() ? 'true' : 'false'; ?>;

        function updateHeader() {
            if (isLoggedIn) {
                if (authButtons) authButtons.classList.add('hidden');
                if (userProfile) userProfile.classList.remove('hidden');
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
                    if (userName) userName.textContent = '<?php echo auth()->user()->name; ?>';
                <?php endif; ?>
            } else {
                if (authButtons) authButtons.classList.remove('hidden');
                if (userProfile) userProfile.classList.add('hidden');
            }
        }

        if (userProfile) {
            userProfile.addEventListener('click', function(e) {
                if (isLoggedIn) {
                    window.location.href = '/profile';
                }
            });
        }

        updateHeader();

        // Gestion de la barre de recherche
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                console.log('Recherche :', this.value);
            });
        }

        // Gestion de la sidebar
        const navItems = document.querySelectorAll('.sidebar-menu a');
        function setActiveNav() {
            const currentPath = window.location.pathname;
            navItems.forEach(item => {
                const href = item.getAttribute('href');
                if (currentPath.includes('/articles') && href === '/articles') {
                    navItems.forEach(nav => nav.classList.remove('active'));
                    item.classList.add('active');
                }
            });
        }

        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                if (this.getAttribute('href') !== '#') {
                    window.location.href = this.getAttribute('href');
                }
            });
        });

        setActiveNav();
        window.addEventListener('popstate', setActiveNav);

        // Charger les commentaires
        fetchComments('{{ $article->id }}');
    });
    // Script pour le compteur de caractères et gestion des erreurs dans la modal
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('reportDescription');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 450) {
                charCount.className = 'text-red-400 font-bold';
            } else if (count > 400) {
                charCount.className = 'text-yellow-400';
            } else {
                charCount.className = 'text-gray-400';
            }
        });
    }
});

// Fonction pour afficher les erreurs dans la modal
function showReportError(message) {
    const errorContainer = document.getElementById('reportErrorContainer');
    const errorMessage = document.getElementById('reportErrorMessage');
    
    if (errorContainer && errorMessage) {
        errorMessage.textContent = message;
        errorContainer.classList.remove('hidden');
        errorContainer.classList.add('show');
        
        // Faire défiler jusqu'à l'erreur
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Fonction pour cacher les erreurs
function hideReportError() {
    const errorContainer = document.getElementById('reportErrorContainer');
    if (errorContainer) {
        errorContainer.classList.add('hidden');
        errorContainer.classList.remove('show');
    }
}
</script>
</body>
</html>