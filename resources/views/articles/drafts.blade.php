<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brouillons d'articles - Business+ Talk</title>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
            --primary-color: #1a9e9e;
            --primary-hover: #25c4c4;
            --primary-dark: #148585;
            --dark-bg: #1A1D21;
            --darker-bg: #121212;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
            --gray-bg: #2A2D35;
            --dark-card: #1e1e1e;
            --dark-element: #252525;
            --dark-border: #333333;
            --success: #10b981;
            --danger: #b91c1c;
            --warning: #b45309;
        }

        /* Reset */
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

        /* Container and Layout */
        .container {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 0;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
            width: calc(100% - 280px);
        }

        .content-area {
            padding: 2rem;
            flex: 1;
            overflow: visible;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* Sidebar */
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

        /* Header - Fixed */
        .header {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            background-color: var(--darker-bg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-logo-container {
            flex: 0 0 auto;
            display: none;
        }

        .header-logo {
            max-height: 50px;
            width: auto;
        }

        .header-center {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 600px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 0 0 auto;
        }

        /* Search */
        .search-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            transition: transform 0.2s ease;
        }

        .search-container:hover {
            transform: scale(1.02);
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 3rem 0.75rem 1.2rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            background-color: var(--gray-bg);
            color: var(--light-text);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            background-color: var(--darker-bg);
            box-shadow: 0 0 0 3px rgba(26, 158, 158, 0.1);
        }

        .search-input::placeholder {
            color: var(--gray-text);
            opacity: 0.7;
        }

        .search-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-text);
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .search-container:hover .search-icon {
            color: var(--primary-color);
        }

        /* Buttons - Fixed */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 48px;
            touch-action: manipulation;
            white-space: nowrap;
            border: 2px solid transparent;
            line-height: 1.2;
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.05);
            color: var(--light-text);
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 158, 158, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: var(--light-text);
            border: 2px solid var(--primary-color);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 158, 158, 0.3);
        }

        /* Action Buttons Container - Fixed */
        .action-buttons {
            
            z-index: 50;
            background-color: var(--darker-bg);
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .action-buttons .flex {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

       /* Profil utilisateur dans l'en-tête */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .user-profile:hover .user-name {
            color: var(--primary-color);
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

        /* Kebab Menu */
        .kebab-menu {
            position: relative;
            display: inline-block;
            z-index: 1000;
        }

        .kebab-button {
            background: none;
            border: none;
            color: var(--gray-text);
            cursor: pointer;
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-size: 1.2rem;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kebab-button:hover {
            color: var(--light-text);
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.1);
        }

        .kebab-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            background-color: var(--gray-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            z-index: 9999;
            min-width: 200px;
            margin-top: 0.5rem;
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        .kebab-dropdown:not(.hidden) {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .kebab-dropdown-item {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.75rem 1rem;
            color: var(--light-text);
            text-decoration: none;
            border: none;
            background: none;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            text-align: left;
        }

        .kebab-dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .kebab-dropdown-item i {
            margin-right: 0.75rem;
            width: 1.2rem;
            text-align: center;
        }

        /* Article Cards */
        .article-card {
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            margin-bottom: 2rem;
            background-color: var(--dark-card);
        }

        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
        }

        .article-layout {
            display: flex;
            min-height: 200px;
        }

        .category-band {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: var(--light-text);
            text-align: center;
            padding: 1rem 0.5rem;
            min-width: 50px;
            font-weight: 700;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            font-size: 0.9rem;
        }

        .article-content {
            display: flex;
            flex: 1;
            padding: 1.5rem;
            gap: 1.5rem;
        }

        .article-image-container {
            flex: 0 0 300px;
            border-right: 1px solid var(--dark-border);
            padding-right: 1.5rem;
        }

        .article-image-placeholder {
            background-color: var(--dark-element);
            color: var(--gray-text);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 180px;
            border-radius: 0.75rem;
            font-size: 3rem;
        }

        .article-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .article-title-section {
            flex: 1;
        }

        .article-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--light-text);
            text-decoration: none;
            transition: color 0.3s ease;
            line-height: 1.4;
        }

        .article-title:hover {
            color: var(--primary-color);
        }

        .article-meta {
            font-size: 0.875rem;
            color: var(--gray-text);
            margin-top: 0.5rem;
        }

        .article-description {
            color: var(--gray-text);
            line-height: 1.6;
            flex: 1;
        }

        .category-tag {
            display: inline-block;
            background-color: rgba(26, 158, 158, 0.1);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-content {
                margin-left: 280px;
                width: calc(100% - 280px);
            }
            
            .content-area {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                padding: 1rem 0;
            }

            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
            }

            .logo-container {
                display: none;
            }

            .sidebar-menu a span {
                display: none;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 1rem;
            }

            .sidebar-menu a i {
                margin-right: 0;
                font-size: 1.8rem;
            }

            .header-logo-container {
                display: block;
            }

            .header-center {
                max-width: 400px;
            }

            .article-image-container {
                flex: 0 0 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }

            .main-content {
                margin-left: 60px;
                width: calc(100% - 60px);
            }

            .header {
                height: auto;
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }

            .header-center {
                width: 100%;
                max-width: none;
            }

            .header-actions {
                width: 100%;
                justify-content: center;
            }

            .search-container {
                max-width: none;
            }

            .content-area {
                padding: 1rem;
            }

            .action-buttons {
                top: 120px;
                padding: 1rem 0;
            }

            .action-buttons .flex {
                justify-content: center;
                gap: 0.75rem;
            }

            .btn {
                flex: 1;
                min-width: 140px;
                font-size: 0.9rem;
            }

            .article-layout {
                flex-direction: column;
            }

            .category-band {
                writing-mode: horizontal-tb;
                text-orientation: mixed;
                transform: none;
                padding: 0.75rem 1rem;
                min-width: auto;
            }

            .article-content {
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }

            .article-image-container {
                flex: none;
                border-right: none;
                border-bottom: 1px solid var(--dark-border);
                padding-right: 0;
                padding-bottom: 1rem;
            }

            .article-info {
                padding-left: 0;
            }

            .kebab-dropdown {
                right: -1rem;
                min-width: 180px;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                margin-left: 40px;
                width: calc(100% - 40px);
            }

            .sidebar {
                width: 40px;
            }

            .action-buttons .flex {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                width: 100%;
                flex: none;
            }

            .article-title {
                font-size: 1.1rem;
            }

            .kebab-dropdown {
                right: -1.5rem;
                min-width: 160px;
            }
        }

        /* Animations */
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

        .animate__fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        /* Additional status styles */
        .article-card.is-deleted {
            border: 2px dashed var(--danger);
            background-color: rgba(185, 28, 28, 0.05);
        }

        .article-card.is-draft {
            border: 2px dashed var(--warning);
            background-color: rgba(180, 83, 9, 0.05);
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 9999px;
            color: var(--light-text);
            font-weight: 600;
        }

        .status-deleted {
            background-color: var(--danger);
        }

        .status-draft {
            background-color: var(--warning);
        }

        /* Modal styles */
        .modal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background-color: var(--gray-bg);
            border-radius: 1rem;
            border-top: 4px solid var(--primary-color);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 28rem;
            width: 90%;
            padding: 2rem;
            text-align: center;
        }

        /* Filter styles */
        .filter-container {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .filter-select {
            background-color: var(--gray-bg);
            border: 2px solid var(--dark-border);
            color: var(--light-text);
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border-radius: 0.5rem;
            appearance: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 158, 158, 0.1);
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
                <div class="flex justify-end gap-2 mb-6">
                    @if(auth()->check() && auth()->user()->is_active && $userHasArticleModule)
                        <a href="{{ route('articles.create') }}" class="btn btn-primary">➕ Ajouter un article</a>
                    @endif
                </div>

                <!-- Modales de succès et d'erreur -->
                @if(session('success'))
                    <div id="successModal" class="modal animate__animated animate__fadeIn">
                        <div class="modal-content">
                            <div class="p-6 text-center">
                                <div class="text-2xl mb-2 text-success">✓</div>
                                <p class="text-lg mb-4">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div id="errorModal" class="modal animate__animated animate__fadeIn">
                        <div class="modal-content">
                            <div class="p-6 text-center">
                                <div class="text-2xl mb-2 text-danger">✕</div>
                                <p class="text-lg mb-4">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="drafts-container">
                    <!-- Filtres pour afficher les brouillons supprimés -->
                    <div class="mb-6 flex justify-end">
                        <div class="filter-container">
                            <span class="filter-icon">🔍</span>
                            <select id="filter-deleted" class="filter-select">
                                <option value="active" {{ ($currentFilter ?? '') === 'active' ? 'selected' : '' }}>Brouillons actifs</option>
                                <option value="deleted" {{ ($currentFilter ?? '') === 'deleted' ? 'selected' : '' }}>Brouillons supprimés</option>
                                <option value="all" {{ ($currentFilter ?? '') === 'all' ? 'selected' : '' }}>Tous les brouillons</option>
                            </select>
                        </div>
                    </div>

                    <!-- Liste des brouillons -->
                    @if(count($drafts) > 0)
                        @foreach($drafts as $article)
                            <div class="article-card {{ $article->is_deleted ? 'is-deleted' : 'is-draft' }}">
                                <div class="article-card-content">
                                    <div class="category-band">
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
                                        {{ $firstCategory ? strtoupper($firstCategory) : 'N/A' }}
                                    </div>
                                    <div class="article-content-wrapper">
                                        <!-- Zone image -->
                                        <div class="article-image-container">
                                            @if($article->image)
                                                @php
                                                    $extension = pathinfo($article->image, PATHINFO_EXTENSION);
                                                @endphp
                                                <img src="{{ $article->image }}" alt="{{ $article->titre }}" class="article-image">
                                            @else
                                                <div class="article-image-placeholder">
                                                    <i class="fas fa-image"></i>
                                                    <div>Pas d'image</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Zone info -->
                                        <div class="article-info">
                                            <!-- En-tête avec titre et menu kebab -->
                                            <div class="article-header">
                                                <div class="article-title-wrapper">
                                                    <a href="{{ route('articles.show', $article->id) }}" class="article-title">
                                                        {{ $article->titre ?: 'Sans titre' }}
                                                    </a>
                                                <div class="status-badges">
                                                    <span class="status-badge status-draft">BROUILLON</span>
                                                    @if($article->is_deleted)
                                                        <span class="status-badge status-deleted">SUPPRIMÉ</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Menu kebab -->
                                            <div class="kebab-menu">
                                                <button class="kebab-button" onclick="toggleKebabMenu('kebab{{ $article->id }}')">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div id="kebab{{ $article->id }}" class="kebab-dropdown hidden">
                                                    @if($article->is_deleted)
                                                        @if(Auth::user()->role === 'superadmin' || $article->created_by === Auth::id() && Auth::user()->is_active)
                                                            <button class="kebab-dropdown-item success" data-modal-target="confirmRestoreModal{{$article->id}}">
                                                                <i class="fas fa-undo"></i> Restaurer
                                                            </button>
                                                            <div class="kebab-dropdown-divider"></div>
                                                        @endif
                                                        <button class="kebab-dropdown-item" onclick="showArticleInfo('{{ $article->id }}')">
                                                            <i class="fas fa-info-circle"></i> Informations
                                                        </button>
                                                    @else
                                                        @if(Auth::user()->role === 'superadmin' || $article->created_by === Auth::id() && Auth::user()->is_active)
                                                            <a href="{{ route('articles.edit', $article->id) }}" class="kebab-dropdown-item">
                                                                <i class="fas fa-edit"></i> Modifier
                                                            </a>
                                                            <button class="kebab-dropdown-item success" data-modal-target="confirmPublishModal{{$article->id}}">
                                                                <i class="fas fa-upload"></i> Publier
                                                            </button>
                                                            <button class="kebab-dropdown-item danger" data-modal-target="confirmDeleteModal{{$article->id}}">
                                                                <i class="fas fa-trash"></i> Supprimer
                                                            </button>
                                                            <div class="kebab-dropdown-divider"></div>
                                                        @endif
                                                        <button class="kebab-dropdown-item" onclick="showArticleInfo('{{ $article->id }}')">
                                                            <i class="fas fa-info-circle"></i> Informations
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    <div class="article-meta">
                                        <div><strong>Auteur :</strong> {{ $article->auteur ?? 'Non spécifié' }}</div>
                                    </div>
                                    <p class="article-description"><strong>Description :</strong> {{ $article->description ?? 'Pas de description' }}</p>
                                    <div class="categories-section">
                                        <strong>Catégories :</strong>
            @php
                $categoriesDisplay = [];
                if (isset($article->categorie)) {
                    if (is_array($article->categorie)) {
                        $categoriesDisplay = $article->categorie;
                    } elseif (is_string($article->categorie) && substr($article->categorie, 0, 1) === '[') {
                        $categoriesDisplay = json_decode($article->categorie, true) ?: [];
                    } elseif (is_string($article->categorie) && !empty($article->categorie)) {
                        $categoriesDisplay = [$article->categorie];
                    }
                }
            @endphp
                                                @if(count($categoriesDisplay) > 0)
                                                    @foreach($categoriesDisplay as $cat)
                                                        @php
                                                            $cat = trim($cat, '"\'');
                                                        @endphp
                                                        <span class="category-tag">{{ $cat }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-gray-text">Aucune catégorie</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Toutes les modales -->
                        @foreach($drafts as $article)
                            <!-- Modale de confirmation pour publier -->
                            <div id="confirmPublishModal{{$article->id}}" tabindex="-1" aria-hidden="true" class="modal hidden">
                                <div class="modal-content animate__animated animate__fadeInDown">
                                    <h3 class="text-xl font-bold text-white mb-4">Confirmation</h3>
                                    <p class="text-gray-400 mb-6">Voulez-vous publier cet article ?</p>
                                    <div class="flex justify-end space-x-4">
                                        <button type="button" class="modal-button modal-button-cancel" data-modal-hide="confirmPublishModal{{$article->id}}">Annuler</button>
                                        <form action="{{ route('articles.publish', $article->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="modal-button modal-button-confirm modal-button-publish">Publier</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modale de confirmation pour supprimer -->
                            <div id="confirmDeleteModal{{$article->id}}" tabindex="-1" aria-hidden="true" class="modal hidden">
                                <div class="modal-content animate__animated animate__fadeInDown">
                                    <h3 class="text-xl font-bold text-white mb-4">Confirmation</h3>
                                    <p class="text-gray-text mb-6">Voulez-vous vraiment supprimer ce brouillon ?</p>
                                    <div class="flex justify-end space-x-4">
                                        <button type="button" class="modal-button modal-button-cancel" data-modal-hide="confirmDeleteModal{{$article->id}}">Annuler</button>
                                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="modal-button modal-button-confirm modal-button-delete">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modale de confirmation pour restaurer -->
                            <div id="confirmRestoreModal{{$article->id}}" tabindex="-1" aria-hidden="true" class="modal hidden">
                                <div class="modal-content animate__animated animate__fadeInDown">
                                    <h3 class="text-xl font-bold text-white mb-4">Confirmation</h3>
                                    <p class="text-gray-text mb-6">Comment souhaitez-vous restaurer ce brouillon ?</p>
                                    <div class="flex flex-col gap-4">
                                        <form action="{{ route('articles.restore', $article->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="publish" value="0">
                                            <button type="submit" class="modal-button modal-button-confirm modal-button-restore w-full">
                                                Restaurer comme brouillon
                                            </button>
                                        </form>
                                        <form action="{{ route('articles.restore', $article->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="publish" value="1">
                                            <button type="submit" class="modal-button modal-button-confirm modal-button-restore w-full">
                                                Restaurer et publier immédiatement
                                            </button>
                                        </form>
                                        <button type="button" class="modal-button modal-button-cancel w-full" data-modal-hide="confirmRestoreModal{{$article->id}}">
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Modales d'informations pour tous les brouillons -->
                            <div id="infoModal{{$article->id}}" class="modal hidden">
                                <div class="modal-content">
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold mb-4 text-center">Informations du brouillon</h3>
                                        <div class="space-y-2 text-sm text-left">
                                            <div><strong>Titre :</strong> {{ $article->titre ?: 'Sans titre' }}</div>
                                            <div><strong>Créé le :</strong> {{ $article->created_at->format('d/m/Y à H:i') }}</div>
                                            <div><strong>Dernière modification :</strong> {{ $article->updated_at->format('d/m/Y à H:i') }}</div>
                                            <div><strong>Auteur :</strong> {{ $article->auteur ?? 'Non spécifié' }}</div>
                                            <div><strong>Créé par :</strong> {{ $article->creator->name ?? ($article->created_by == Auth::id() ? 'Vous' : 'ID: '.$article->created_by) }}</div>
                                            @if($article->is_deleted)
                                                <div><strong>Supprimé le :</strong> {{ $article->updated_at->format('d/m/Y à H:i') }}</div>
                                                @if($article->deleted_by)
                                                    <div><strong>Supprimé par :</strong> {{ $article->deleter->name ?? 'Inconnu' }}</div>
                                                @endif
                                                <div><strong>Statut :</strong> <span class="text-red-400">Brouillon supprimé</span></div>
                                            @else
                                                <div><strong>Statut :</strong> <span class="text-yellow-400">Brouillon</span></div>
                                            @endif
                                        </div>
                                        <div class="flex justify-center mt-6">
                                            <button type="button" class="modal-button modal-button-cancel" onclick="closeInfoModal('{{ $article->id }}')">
                                                Fermer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        @endforeach

                    @else
                        <div class="text-center py-10 text-gray-text">Aucun brouillon trouvé</div>
                    @endif
                </div>
            </div>

            <!-- Inclusion du pied de page -->
            @include('components.footer')
        </div>
    </div>

    <script>
    // ========================================
// SCRIPT FINAL POUR LES MODALES ET MENUS KEBAB
// ========================================

// Fonction pour fermer ABSOLUMENT tous les menus kebab
window.closeAllKebabMenus = function() {
    const openMenus = document.querySelectorAll('.kebab-dropdown:not(.hidden)');
    console.log('🔒 Fermeture ABSOLUE de', openMenus.length, 'menus kebab ouverts');
    
    // Fermeture immédiate et multiple
    document.querySelectorAll('.kebab-dropdown').forEach(menu => {
        // Méthode 1: Classes CSS
        menu.classList.add('hidden');
        menu.classList.remove('show');
        
        // Méthode 2: Styles inline forcés
        menu.style.display = 'none !important';
        menu.style.opacity = '0 !important';
        menu.style.visibility = 'hidden !important';
        menu.style.pointerEvents = 'none !important';
        menu.style.transform = 'translateY(-10px) scale(0.95) !important';
        
        // Méthode 3: Attributs
        menu.setAttribute('aria-hidden', 'true');
        menu.setAttribute('hidden', 'true');
    });
    
    // Nettoyer après un délai court
    setTimeout(() => {
        document.querySelectorAll('.kebab-dropdown').forEach(menu => {
            menu.style.display = '';
            menu.style.opacity = '';
            menu.style.visibility = '';
            menu.style.pointerEvents = '';
            menu.style.transform = '';
            menu.removeAttribute('hidden');
        });
    }, 200);
    
    if (openMenus.length > 0) {
        console.log('✅ Menus kebab fermés avec FORCE ABSOLUE');
    }
};

// Fonction pour basculer le menu kebab
window.toggleKebabMenu = function(kebabId) {
    const dropdown = document.getElementById(kebabId);
    if (!dropdown) {
        console.error('Menu kebab non trouvé:', kebabId);
        return;
    }
    
    // D'abord fermer tous les autres
    document.querySelectorAll('.kebab-dropdown').forEach(menu => {
        if (menu.id !== kebabId) {
            menu.classList.add('hidden');
        }
    });
    
    // Basculer le menu actuel
    dropdown.classList.toggle('hidden');
    console.log('🔄 Menu kebab basculé:', kebabId, dropdown.classList.contains('hidden') ? 'FERMÉ' : 'OUVERT');
};

// Fonction principale pour la gestion des modales
window.modalToggle = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error('Modal non trouvée:', modalId);
        return;
    }
    
    if (modal.classList.contains('hidden')) {
        // === OUVRIR LA MODAL ===
        
        console.log('🔓 Ouverture modal:', modalId);
        
        // ÉTAPE 1: Fermeture BRUTALE de tous les menus kebab
        window.closeAllKebabMenus();
        
        // ÉTAPE 2: Double vérification avec force brute
        setTimeout(() => {
            document.querySelectorAll('.kebab-dropdown').forEach(dropdown => {
                dropdown.classList.add('hidden');
                dropdown.style.display = 'none';
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.pointerEvents = 'none';
                console.log('💀 Menu kebab forcé à fermer:', dropdown.id);
            });
        }, 10);
        
        // ÉTAPE 3: Fermer toutes les autres modales
        document.querySelectorAll('.modal:not(.hidden)').forEach(m => {
            if (m.id !== modalId) {
                m.classList.add('hidden');
            }
        });
        
        // ÉTAPE 4: Afficher la modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // ÉTAPE 5: Animation d'entrée
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.classList.remove('animate__fadeOutUp');
            modalContent.classList.add('animate__animated', 'animate__fadeInDown');
        }
        
        console.log('✅ Modal DÉFINITIVEMENT ouverte:', modalId);
        
    } else {
        // === FERMER LA MODAL ===
        
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.classList.remove('animate__fadeInDown');
            modalContent.classList.add('animate__fadeOutUp');
        }
        
        setTimeout(() => {
            modal.classList.add('hidden');
            if (modalContent) {
                modalContent.classList.remove('animate__animated', 'animate__fadeOutUp');
            }
            document.body.style.overflow = '';
            
            // Nettoyer les styles forcés des kebab après fermeture modal
            document.querySelectorAll('.kebab-dropdown').forEach(dropdown => {
                dropdown.style.display = '';
                dropdown.style.opacity = '';
                dropdown.style.visibility = '';
                dropdown.style.pointerEvents = '';
            });
        }, 300);
        
        console.log('❌ Modal fermée:', modalId);
    }
};

// Fonction pour afficher les informations de l'article
window.showArticleInfo = function(articleId) {
    console.log('ℹ️ Affichage info article:', articleId);
    // Fermer TOUS les menus kebab
    window.closeAllKebabMenus();
    
    // Ouvrir la modal d'informations
    window.modalToggle('infoModal' + articleId);
};

// Fonction pour fermer la modal d'informations
window.closeInfoModal = function(articleId) {
    window.modalToggle('infoModal' + articleId);
};

// ========================================
// INITIALISATION AU CHARGEMENT DE LA PAGE
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Initialisation FINALE des modales et menus kebab...');
    
    // ========================================
    // GESTION DES BOUTONS QUI OUVRENT LES MODALES
    // ========================================
    
    const modalButtons = document.querySelectorAll('[data-modal-target]');
    console.log('📋 Boutons de modal trouvés:', modalButtons.length);
    
    modalButtons.forEach((button, index) => {
        const targetId = button.getAttribute('data-modal-target');
        console.log(`🔧 Configuration bouton ${index + 1} pour modal:`, targetId);
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('🖱️ CLIC DÉTECTÉ sur bouton modal:', targetId);
            
            // FERMETURE IMMÉDIATE ET BRUTALE
            window.closeAllKebabMenus();
            console.log('💥 Fermeture BRUTALE des menus kebab');
            
            // Triple vérification avec délais échelonnés
            setTimeout(() => {
                window.closeAllKebabMenus();
                console.log('💥 2ème vague de fermeture');
            }, 25);
            
            setTimeout(() => {
                window.closeAllKebabMenus();
                console.log('💥 3ème vague de fermeture');
                
                // Enfin ouvrir la modal
                window.modalToggle(targetId);
            }, 75);
        });
    });

    // ========================================
    // GESTION DES BOUTONS QUI FERMENT LES MODALES
    // ========================================
    
    const closeButtons = document.querySelectorAll('[data-modal-hide]');
    console.log('❌ Boutons de fermeture trouvés:', closeButtons.length);
    
    closeButtons.forEach((button, index) => {
        const targetId = button.getAttribute('data-modal-hide');
        console.log(`🔧 Configuration bouton fermeture ${index + 1} pour modal:`, targetId);
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('❌ Clic sur fermeture modal:', targetId);
            window.modalToggle(targetId);
        });
    });

    // ========================================
    // FERMER LA MODAL EN CLIQUANT SUR L'ARRIÈRE-PLAN
    // ========================================
    
    document.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('.modal:not(.hidden)');
        modals.forEach(modal => {
            const modalContent = modal.querySelector('.modal-content');
            if (modalContent && !modalContent.contains(event.target) && event.target === modal) {
                console.log('🖱️ Clic sur arrière-plan modal:', modal.id);
                window.modalToggle(modal.id);
            }
        });
    });

    // ========================================
    // FERMER LES MENUS KEBAB QUAND ON CLIQUE AILLEURS
    // ========================================
    
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.kebab-menu')) {
            window.closeAllKebabMenus();
        }
    });

    // ========================================
    // SURVEILLANCE CONTINUE DES MENUS KEBAB
    // ========================================
    
    // Observer pour surveiller les changements dans les menus kebab
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const target = mutation.target;
                if (target.classList.contains('kebab-dropdown') && 
                    !target.classList.contains('hidden') && 
                    document.querySelectorAll('.modal:not(.hidden)').length > 0) {
                    
                    console.log('🔍 Menu kebab détecté ouvert pendant modal - fermeture forcée');
                    target.classList.add('hidden');
                    target.style.display = 'none';
                }
            }
        });
    });

    // Observer tous les menus kebab
    document.querySelectorAll('.kebab-dropdown').forEach(menu => {
        observer.observe(menu, { attributes: true, attributeFilter: ['class'] });
    });

    // ========================================
    // GESTION DU FILTRE POUR LES BROUILLONS
    // ========================================
    
    const filterDropdown = document.getElementById('filter-deleted');
    if (filterDropdown) {
        console.log('🔍 Filtre de brouillons trouvé');
        
        const urlParams = new URLSearchParams(window.location.search);
        const showParam = urlParams.get('show');
        
        if (showParam === 'deleted') {
            filterDropdown.value = 'deleted';
        } else if (showParam === 'all') {
            filterDropdown.value = 'all';
        } else {
            filterDropdown.value = 'active';
        }

        filterDropdown.addEventListener('change', function() {
            const value = this.value;
            let url = new URL(window.location.href);
            this.classList.add('loading');
            
            if (value === 'deleted') {
                url.searchParams.set('show', 'deleted');
            } else if (value === 'all') {
                url.searchParams.set('show', 'all');
            } else {
                url.searchParams.delete('show');
            }
            
            console.log('🔄 Redirection vers:', url.toString());
            window.location.href = url.toString();
        });
    }

    // ========================================
    // RENDRE LES CARTES D'ARTICLES CLIQUABLES
    // ========================================
    
    const articleCards = document.querySelectorAll('.article-card');
    console.log('📄 Cartes d\'articles trouvées:', articleCards.length);
    
    articleCards.forEach((card, index) => {
        card.addEventListener('click', function(event) {
            const clickedElement = event.target;
            
            // Vérifier si l'élément cliqué est interactif
            const isInteractive = 
                clickedElement.tagName === 'A' || 
                clickedElement.tagName === 'BUTTON' || 
                clickedElement.tagName === 'INPUT' || 
                clickedElement.tagName === 'SELECT' || 
                clickedElement.closest('a') !== null || 
                clickedElement.closest('button') !== null || 
                clickedElement.closest('form') !== null || 
                clickedElement.closest('[data-modal-target]') !== null ||
                clickedElement.closest('.kebab-menu') !== null;
                
            if (isInteractive) {
                console.log('🚫 Clic sur élément interactif, pas de redirection');
                return;
            }
            
            // Rediriger vers la page de détail de l'article
            const showLink = this.querySelector('.article-title');
            if (showLink) {
                const href = showLink.getAttribute('href');
                console.log('📄 Redirection vers article:', href);
                window.location.href = href;
            }
        });
    });

    // ========================================
    // AUTO-FERMETURE DES MODALES DE SUCCÈS/ERREUR
    // ========================================
    
    const successModal = document.getElementById('successModal');
    const errorModal = document.getElementById('errorModal');
    
    if (successModal) {
        console.log('✅ Modal de succès détectée, fermeture automatique dans 3s');
        setTimeout(function() {
            window.modalToggle('successModal');
        }, 3000);
    }
    
    if (errorModal) {
        console.log('❌ Modal d\'erreur détectée, fermeture automatique dans 3s');
        setTimeout(function() {
            window.modalToggle('errorModal');
        }, 3000);
    }

    // ========================================
    // GESTION DE LA SIDEBAR ACTIVE
    // ========================================
    
    const navItems = document.querySelectorAll('.sidebar-menu a');
    
    function setActiveNav() {
        const currentPath = window.location.pathname;
        navItems.forEach(item => {
            const href = item.getAttribute('href');
            if (currentPath.includes('/articles') && href === '/articles') {
                navItems.forEach(nav => nav.classList.remove('active'));
                item.classList.add('active');
                console.log('🎯 Navigation active définie sur:', href);
            }
        });
    }

    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            navItems.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            
            const href = this.getAttribute('href');
            if (href !== '#') {
                console.log('🧭 Navigation vers:', href);
                window.location.href = href;
            }
        });
    });

    setActiveNav();
    window.addEventListener('popstate', setActiveNav);
    
    console.log('✅ Initialisation FINALE terminée avec succès');
});

// ========================================
// GESTION DES ERREURS GLOBALES
// ========================================

window.addEventListener('error', function(e) {
    console.error('❌ Erreur JavaScript:', e.error);
});

console.log('📄 Script FINAL des modales chargé');
    </script>
</body>
</html>