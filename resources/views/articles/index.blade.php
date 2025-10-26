<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liste des articles - Business+ Talk</title>
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
                @php
                    $userHasArticleModule = false;
                    if (auth()->check()) {
                        if (auth()->user()->role === 'superadmin') {
                            $userHasArticleModule = true;
                        } elseif (auth()->user()->affectation) {
                            $modules = is_array(auth()->user()->affectation->modules) ?
                                auth()->user()->affectation->modules :
                                json_decode(auth()->user()->affectation->modules, true);
                            if (is_array($modules) && in_array('article', $modules)) {
                                $userHasArticleModule = true;
                            }
                        }
                    }
                @endphp

                @if($userHasArticleModule)
                    <div class="action-buttons">
                        <div class="flex justify-end gap-2 flex-wrap">
                            <a href="{{ route('articles.drafts') }}" class="btn btn-outline">📝 Brouillons</a>
                            @if(auth()->check() && auth()->user()->is_active && $userHasArticleModule)
                                <a href="{{ route('articles.create') }}" class="btn btn-primary">➕ Ajouter un article</a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Success modal -->
                @if(session('success'))
                    <div id="successModal" class="modal">
                        <div class="modal-content" id="successModalContent">
                            <div class="p-6 text-center">
                                <div class="text-2xl mb-2 text-success">✓</div>
                                <p class="text-lg mb-4">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="articles-container">
                    @if(auth()->check() && auth()->user()->role === 'superadmin' )
                        <div class="mb-6 flex justify-end">
                            <div class="filter-container">
                                <span class="filter-icon">🔍</span>
                                <select id="filter-deleted" class="filter-select">
                                    <option value="active" {{ ($currentFilter ?? '') === 'active' ? 'selected' : '' }}>Articles actifs</option>
                                    <option value="deleted" {{ ($currentFilter ?? '') === 'deleted' ? 'selected' : '' }}>Articles supprimés</option>
                                    <option value="all" {{ ($currentFilter ?? '') === 'all' ? 'selected' : '' }}>Tous les articles</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    <!-- Liste des articles -->
                    @if(count($articles) > 0)
                        @foreach($articles as $article)
                            <div class="mb-6 article-card {{ $article->is_deleted ? 'is-deleted' : '' }} {{ $article->status === 'draft' ? 'is-draft' : '' }}">
                                <div class="article-layout">
                                    <!-- Bande latérale pour la catégorie -->
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
                                    
                                    <div class="article-content">
                                        <!-- Zone image -->
                                        <div class="article-image-container">
                                            @if($article->image)
                                                @php
                                                    $extension = pathinfo($article->image, PATHINFO_EXTENSION);
                                                @endphp
                                                    <img src="{{ $article->image }}" alt="{{ $article->titre }}" class="w-full h-auto object-cover rounded">
                                            @else
                                                <div class="article-image-placeholder">
                                                    <span>Pas d'image</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Zone info -->
                                        <div class="article-info">
                                            <div class="article-header">
                                                <div class="article-title-section">
                                                    <a href="{{ route('articles.show', $article->id) }}" class="article-title">
                                                        {{ $article->titre }}
                                                    </a>
                                                    <div class="status-badges">
                                                        @if($article->is_deleted)
                                                            <span class="status-badge status-deleted">SUPPRIMÉ</span>
                                                        @endif
                                                        @if($article->status === 'draft')
                                                            <span class="status-badge status-draft">BROUILLON</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-start gap-3">
                                                    <!-- Menu kebab -->
                                                <div class="kebab-menu">
                                                    <button 
                                                        class="kebab-button" 
                                                            onclick="toggleKebabMenu('kebab{{ $article->id }}', event)"
                                                        aria-expanded="false"
                                                        aria-haspopup="true"
                                                        aria-label="Options pour l'article {{ $article->titre }}"
                                                        data-kebab-id="kebab{{ $article->id }}">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    
                                                    <div id="kebab{{ $article->id }}" class="kebab-dropdown hidden">
                                                        @if(auth()->check() && auth()->user()->is_active && $userHasArticleModule)
                                                            @if($article->is_deleted)
                                                                @if(auth()->user()->role === 'superadmin')
                                                                    <button class="kebab-dropdown-item success" data-modal-target="confirmRestoreModal{{$article->id}}" onclick="event.stopPropagation()">
                                                                        <i class="fas fa-undo"></i> Restaurer
                                                                    </button>
                                                                    <div class="kebab-dropdown-divider"></div>
                                                                @endif
                                                                <button class="kebab-dropdown-item" onclick="showArticleInfo('{{ $article->id }}', event)">
                                                                    <i class="fas fa-info-circle"></i> Informations
                                                                </button>
                                                            @else
                                                                @if(auth()->user()->role === 'superadmin' || $article->created_by === auth()->id())
                                                                    <a href="{{ route('articles.edit', $article->id) }}" class="kebab-dropdown-item" onclick="event.stopPropagation()">
                                                                        <i class="fas fa-edit"></i> Modifier
                                                                    </a>
                                                                @endif
                                                                @if($article->created_by === auth()->id())
                                                                    <button class="kebab-dropdown-item warning" data-modal-target="confirmDraftModal{{$article->id}}" onclick="event.stopPropagation()">
                                                                        <i class="fas fa-file-alt"></i> Mettre en brouillon
                                                                    </button>
                                                                @endif
                                                                <button class="kebab-dropdown-item danger" data-modal-target="confirmDeleteModal{{$article->id}}" onclick="event.stopPropagation()">
                                                                    <i class="fas fa-trash"></i> Supprimer
                                                                </button>
                                                                <div class="kebab-dropdown-divider"></div>
                                                                <button class="kebab-dropdown-item" onclick="showArticleInfo('{{ $article->id }}')">
                                                                    <i class="fas fa-info-circle"></i> Informations
                                                                </button>
                                                                
                                                                {{-- Signal button - moved outside the creator condition --}}
                                                            @if(Auth::id() !== $article->created_by)
                                                                <div class="kebab-dropdown-divider"></div>
                                                                <button class="kebab-dropdown-item warning" onclick="showReportModal({{ $article->id }}); closeAllKebabMenus();">
                                                                    <i class="fas fa-flag"></i> Signaler
                                                                </button>
                                                            @endif
                                                            @endif
                                                        @else
                                                            <button class="kebab-dropdown-item" onclick="showArticleInfo('{{ $article->id }}')">
                                                                <i class="fas fa-info-circle"></i> Informations
                                                            </button>
                                                            
                                                            {{-- Signal button for non-active users or users without article module --}}
                                                            @if(Auth::id() !== $article->created_by)
                                                            <div class="kebab-dropdown-divider"></div>
                                                            <button class="kebab-dropdown-item warning" onclick="showReportModal({{ $article->id }}); closeAllKebabMenus();">
                                                                <i class="fas fa-flag"></i> Signaler
                                                            </button>
                                                        @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>                                
                                            </div>
                                            
                                            <div class="article-meta">
                                                <strong>Auteur :</strong> {{ $article->auteur ?? 'Non spécifié' }}
                                            </div>
                                            
                                            <p class="article-description"><strong>Description :</strong> {{ $article->description ?? 'Pas de description' }}</p>
                                            
                                            <div class="mb-4">
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
                                                    <span class="text-gray-400">Aucune catégorie</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modale de confirmation pour mettre en brouillon -->
                            <div id="confirmDraftModal{{$article->id}}" tabindex="-1" aria-hidden="true" class="modal hidden">
                                <div class="modal-content">
                                    <div class="p-6 text-center">
                                        <p class="text-lg mb-4">Êtes-vous sûr de vouloir mettre cet article en brouillon ?</p>
                                        <div class="flex justify-center mt-6 space-x-4">
                                            <button type="button" class="modal-button modal-button-cancel" data-modal-hide="confirmDraftModal{{$article->id}}">Annuler</button>
                                            <form action="{{ route('articles.to-draft', $article->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="modal-button modal-button-confirm modal-button-draft">Confirmer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modale de confirmation pour restaurer et publier -->
                            <div id="confirmRestoreModal{{$article->id}}" tabindex="-1" aria-hidden="true" class="modal hidden">
                                <div class="modal-content">
                                    <div class="p-6 text-center">
                                        <p class="text-lg mb-4">Comment souhaitez-vous restaurer cet article ?</p>
                                        <div class="flex flex-col gap-4 mt-6">
                                            <form action="{{ route('articles.restore', $article->id) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="publish" value="1">
                                                <button type="submit" class="modal-button modal-button-confirm modal-button-restore-publish w-full">
                                                    Restaurer et publier immédiatement
                                                </button>
                                            </form>
                                            <form action="{{ route('articles.restore', $article->id) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="publish" value="0">
                                                <button type="submit" class="modal-button modal-button-confirm modal-button-draft w-full">
                                                    Restaurer comme brouillon
                                                </button>
                                            </form>
                                            <button type="button" class="modal-button modal-button-cancel w-full" data-modal-hide="confirmRestoreModal{{$article->id}}">
                                                Annuler
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modale de confirmation pour supprimer -->
                            <div id="confirmDeleteModal{{$article->id}}" tabindex="-1" aria-hidden="true" class="modal hidden">
                                <div class="modal-content">
                                    <div class="p-6 text-center">
                                        <p class="text-lg mb-4">Voulez-vous vraiment supprimer cet article ?</p>
                                        <div class="flex justify-center mt-6 space-x-4">
                                            <button type="button" class="modal-button modal-button-cancel" data-modal-hide="confirmDeleteModal{{$article->id}}">Annuler</button>
                                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="modal-button modal-button-confirm modal-button-delete">Confirmer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Modales d'informations pour tous les articles -->
                        @foreach($articles as $article)
                            <div id="infoModal{{$article->id}}" class="modal hidden">
                                <div class="modal-content">
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold mb-4 text-center">Informations de l'article</h3>
                                        <div class="space-y-2 text-sm text-left">
                                            <div><strong>Titre :</strong> {{ $article->titre }}</div>
                                            <div><strong>Créé le :</strong> {{ $article->created_at->format('d/m/Y à H:i') }}</div>
                                            <div><strong>Auteur :</strong> {{ $article->auteur ?? 'Non spécifié' }}</div>
                                            @if(auth()->check() && auth()->user()->role !== 'user')
                                                <div><strong>Ajouté par :</strong> {{ $article->creator->name ?? 'Inconnu' }}</div>
                                            @endif
                                            @if($article->is_deleted)
                                                <div><strong>Supprimé le :</strong> {{ $article->updated_at->format('d/m/Y à H:i') }}</div>
                                                @if($article->deleted_by)
                                                    <div><strong>Supprimé par :</strong> {{ $article->deleter->name ?? 'Inconnu' }}</div>
                                                @endif
                                                @if(auth()->check() && auth()->user()->role !== 'user')
                                                    <div><strong>Statut :</strong> <span class="text-red-400">Supprimé</span></div>
                                                @endif
                                            @elseif($article->status === 'draft')
                                                <div><strong>Modifié le :</strong> {{ $article->updated_at->format('d/m/Y à H:i') }}</div>
                                                @if(auth()->check() && auth()->user()->role !== 'user')
                                                    <div><strong>Statut :</strong> <span class="text-yellow-400">Brouillon</span></div>
                                                @endif
                                            @else
                                                @if(auth()->check() && auth()->user()->role !== 'user')
                                                    <div><strong>Statut :</strong> <span class="text-green-400">Publié</span></div>
                                                @endif
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
                        <div class="text-center py-10 text-gray-400">Aucun article trouvé</div>
                    @endif
                </div>
            </div>

            <!-- Inclusion du pied de page -->
            @include('components.footer')
        </div>
    </div>

    <!-- Report Modal - moved outside the foreach loop -->
<div class="modal fade hidden" id="reportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Signaler cet article</h5>
                <button type="button" class="btn-close" onclick="closeReportModal()" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    @csrf
                    <input type="hidden" id="articleId" name="article_id" value="">
                    
                    <div class="mb-3">
                        <label for="reason_category" class="form-label">Raison du signalement <span class="text-red-500">*</span></label>
                        <select class="form-select" id="reason_category" name="reason_category" required>
                            <option value="">Sélectionnez une raison</option>
                            <option value="spam">Spam</option>
                            <option value="inappropriate">Contenu inapproprié</option>
                            <option value="misinformation">Désinformation</option>
                            <option value="hate_speech">Discours de haine</option>
                            <option value="violence">Violence</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason_details" class="form-label">Détails (optionnel)</label>
                        <textarea class="form-control" id="reason_details" name="reason_details" rows="3" maxlength="500" placeholder="Décrivez le problème (optionnel)"></textarea>
                        <small class="form-text text-muted">Maximum 500 caractères</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeReportModal()">Annuler</button>
                <button type="button" class="btn btn-warning" onclick="submitReport()">Signaler</button>
            </div>
        </div>
    </div>
</div>
<script>
function showReportModal(articleId) {
    // Vérifier que l'articleId est valide
    if (!articleId || articleId === '') {
        console.error('❌ ID d\'article invalide pour le signalement');
        return;
    }
    
    // Fermer tous les menus kebab
    closeAllKebabMenus();
    
    // Remettre à zéro le formulaire
    const form = document.getElementById('reportForm');
    if (form) {
        form.reset();
    }
    
    // Définir l'ID de l'article
    const articleIdInput = document.getElementById('articleId');
    if (articleIdInput) {
        articleIdInput.value = articleId;
        console.log('📄 Article ID défini pour signalement:', articleId);
    } else {
        console.error('❌ Champ articleId introuvable');
        return;
    }
    
    // Ouvrir la modal
    const modal = document.getElementById('reportModal');
    if (modal) {
        modal.classList.remove('hidden');
        // Si vous utilisez Bootstrap
        if (typeof bootstrap !== 'undefined') {
            new bootstrap.Modal(modal).show();
        }
        document.body.classList.add('overflow-hidden');
        console.log('✅ Modal de signalement ouverte pour l\'article:', articleId);
    } else {
        console.error('❌ Modal de signalement introuvable');
    }
}


function submitReport() {
    const form = document.getElementById('reportForm');
    const articleIdInput = document.getElementById('articleId');
    const reasonCategory = document.getElementById('reason_category');
    
    console.log('🔍 Starting report submission debug...');
    
    // Validations
    if (!articleIdInput || !articleIdInput.value) {
        console.error('❌ Article ID missing');
        alert('Erreur: Aucun article sélectionné pour le signalement');
        return;
    }
    
    if (!reasonCategory || !reasonCategory.value) {
        console.error('❌ Reason category missing');
        alert('Veuillez sélectionner une raison pour le signalement');
        reasonCategory.focus();
        return;
    }
    
    const articleId = articleIdInput.value;
    console.log('📤 Sending report for article:', articleId);
    console.log('📝 Reason category:', reasonCategory.value);
    
    // Disable submit button
    const submitButton = document.querySelector('#reportModal .btn-warning');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Signalement en cours...';
    }
    
    // Prepare form data
    const formData = new FormData(form);
    
    // Enhanced CSRF token detection
    let csrfToken = null;
    
    // Method 1: Meta tag
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken) {
        csrfToken = metaToken.getAttribute('content');
        console.log('✅ CSRF token found in meta tag');
    }
    
    // Method 2: Form input
    if (!csrfToken) {
        const inputToken = document.querySelector('input[name="_token"]');
        if (inputToken) {
            csrfToken = inputToken.value;
            console.log('✅ CSRF token found in form input');
        }
    }
    
    // Method 3: From the form itself
    if (!csrfToken) {
        const formToken = form.querySelector('input[name="_token"]');
        if (formToken) {
            csrfToken = formToken.value;
            console.log('✅ CSRF token found in report form');
        }
    }
    
    // Method 4: Laravel's global csrf token function (if available)
    if (!csrfToken && typeof window._token !== 'undefined') {
        csrfToken = window._token;
        console.log('✅ CSRF token found in window._token');
    }
    
    if (!csrfToken) {
        console.error('❌ CSRF token missing completely');
        alert('Erreur: Token CSRF manquant. Veuillez rafraîchir la page.');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Signaler';
        }
        return;
    }
    
    console.log('🔑 CSRF token (first 10 chars):', csrfToken.substring(0, 10) + '...');
    
    // Add CSRF token to form data if not already present
    if (!formData.has('_token')) {
        formData.append('_token', csrfToken);
    }
    
    // Enhanced form data logging
    console.log('📋 Form data contents:');
    for (let pair of formData.entries()) {
        if (pair[0] === '_token') {
            console.log('  ', pair[0], ':', pair[1].substring(0, 10) + '...');
        } else {
            console.log('  ', pair[0], ':', pair[1]);
        }
    }
    
    // Check if user is authenticated
    const isAuthenticated = document.querySelector('meta[name="user-authenticated"]');
    if (isAuthenticated) {
        console.log('👤 User authenticated:', isAuthenticated.getAttribute('content'));
    }
    
    // Enhanced fetch request with better error handling
    console.log('🌐 Sending request to: /articles/report-article');
    
    fetch('/articles/report-article', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('📥 Response received:');
        console.log('  Status:', response.status);
        console.log('  Status text:', response.statusText);
        console.log('  Headers:', Object.fromEntries(response.headers.entries()));
        
        // Clone response to read it multiple times
        const responseClone = response.clone();
        
        // Try to read response as text first for debugging
        return responseClone.text().then(text => {
            console.log('📄 Raw response text:', text);
            
            // Handle different response statuses with more detail
            if (response.status === 405) {
                throw new Error('Method Not Allowed (405) - Route might not accept POST requests');
            }
            
            if (response.status === 419) {
                throw new Error('CSRF Token Mismatch (419) - Token expired or invalid');
            }
            
            if (response.status === 401) {
                throw new Error('Unauthorized (401) - User not authenticated');
            }
            
            if (response.status === 403) {
                throw new Error('Forbidden (403) - User lacks permission');
            }
            
            if (response.status === 404) {
                throw new Error('Not Found (404) - Route not found');
            }
            
            if (response.status === 422) {
                // Validation errors
                try {
                    const errorData = JSON.parse(text);
                    console.log('🔍 Validation errors:', errorData);
                    throw new Error('Validation Error (422): ' + (errorData.message || 'Invalid data'));
                } catch (parseError) {
                    throw new Error('Validation Error (422): ' + text);
                }
            }
            
            // Handle 400 Bad Request - Check if it's a duplicate report
            if (response.status === 400) {
                try {
                    const errorData = JSON.parse(text);
                    console.log('🔍 Bad request error:', errorData);
                    
                    // Check if the error is about already reporting this article
                    if (errorData.message && (
                        errorData.message.includes('already reported') ||
                        errorData.message.includes('déjà signalé') ||
                        errorData.message.includes('duplicate') ||
                        errorData.error === 'already_reported'
                    )) {
                        throw new Error('ALREADY_REPORTED');
                    }
                    
                    throw new Error('Bad Request (400): ' + (errorData.message || 'Invalid request'));
                } catch (parseError) {
                    if (parseError.message === 'ALREADY_REPORTED') {
                        throw parseError;
                    }
                    throw new Error('Bad Request (400): ' + text);
                }
            }
            
            if (response.status === 500) {
                throw new Error('Internal Server Error (500) - Check server logs for details');
            }
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            // Try to parse as JSON
            try {
                return JSON.parse(text);
            } catch (parseError) {
                console.error('❌ JSON parse error:', parseError);
                throw new Error('Invalid JSON response: ' + text);
            }
        });
    })
    .then(data => {
        console.log('✅ Parsed response data:', data);
        
        if (data.success) {
            console.log('🎉 Report submitted successfully');
            // Just close the modal - no success alert
            closeReportModal();
            
            // Reset form
            form.reset();
            document.getElementById('articleId').value = '';
        } else {
            console.error('❌ Server returned error:', data);
            alert(data.message || data.error || 'Erreur lors du signalement');
        }
    })
    .catch(error => {
        console.error('❌ Request failed:', error);
        console.error('❌ Error stack:', error.stack);
        
        // More specific error messages
        if (error.message === 'ALREADY_REPORTED') {
            alert('Vous avez déjà signalé cet article.');
        } else if (error.message.includes('405')) {
            alert('Erreur: Cette action n\'est pas autorisée avec cette méthode. Vérifiez les routes.');
        } else if (error.message.includes('419')) {
            alert('Session expirée. Veuillez rafraîchir la page et réessayer.');
        } else if (error.message.includes('401')) {
            alert('Vous devez être connecté pour signaler un article.');
        } else if (error.message.includes('403')) {
            alert('Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        } else if (error.message.includes('404')) {
            alert('Route non trouvée. Contactez l\'administrateur.');
        } else if (error.message.includes('422')) {
            alert('Données invalides: ' + error.message);
        } else if (error.message.includes('500')) {
            alert('Erreur serveur. Vérifiez les logs du serveur.');
        } else {
            alert('Erreur lors du signalement: ' + error.message);
        }
    })
    .finally(() => {
        // Re-enable button
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Signaler';
        }
    });
}

function checkAuthStatus() {
    fetch('/csrf-token', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('🔑 Current CSRF token:', data.csrf_token.substring(0, 10) + '...');
        
        // Update meta tag if it exists
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            metaTag.setAttribute('content', data.csrf_token);
        }
    })
    .catch(error => {
        console.error('❌ Failed to get CSRF token:', error);
    });
}

// Call this function when the page loads to verify authentication
document.addEventListener('DOMContentLoaded', function() {
    checkAuthStatus();
});
// Fonction améliorée pour fermer la modal
function closeReportModal() {
    const modal = document.getElementById('reportModal');
    const form = document.getElementById('reportForm');
    
    if (modal) {
        modal.classList.add('hidden');
        
        // Si vous utilisez Bootstrap
        if (typeof bootstrap !== 'undefined') {
            const bootstrapModal = bootstrap.Modal.getInstance(modal);
            if (bootstrapModal) {
                bootstrapModal.hide();
            }
        }
        
        document.body.classList.remove('overflow-hidden');
    }
    
    // Réinitialiser le formulaire
    if (form) {
        form.reset();
        const articleIdInput = document.getElementById('articleId');
        if (articleIdInput) {
            articleIdInput.value = '';
        }
    }
    
    console.log('✅ Modal de signalement fermée');
} 




// Ajouter cette partie dans la fonction DOMContentLoaded après les autres gestionnaires d'événements

// Fermer la modal de signalement avec Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAllKebabMenus();
        closeReportModal();
        
        // Fermer aussi les autres modales ouvertes
        document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
            if (modal.id !== 'reportModal') {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    }
});

// Fermer la modal de signalement en cliquant sur l'arrière-plan
document.addEventListener('click', function(event) {
    const reportModal = document.getElementById('reportModal');
    if (reportModal && !reportModal.classList.contains('hidden')) {
        const modalContent = reportModal.querySelector('.modal-content');
        if (modalContent && !modalContent.contains(event.target) && event.target === reportModal) {
            closeReportModal();
        }
    }
});



// Variables globales pour éviter les conflits
let isMenuOpen = false;
let currentOpenMenu = null;
let scrollTimeout = null;

// Fonction améliorée pour fermer tous les menus kebab
window.closeAllKebabMenus = function() {
    const openMenus = document.querySelectorAll('.kebab-dropdown:not(.hidden)');
    
    document.querySelectorAll('.kebab-dropdown').forEach(menu => {
        menu.classList.add('hidden');
        menu.style.transform = '';
        menu.style.top = '';
        menu.style.bottom = '';
        menu.style.visibility = '';
        menu.style.opacity = '';
        menu.style.marginTop = '';
        menu.style.marginBottom = '';
        menu.style.display = '';
        menu.style.pointerEvents = '';
        menu.classList.remove('position-left', 'mobile-adjust');
    });
    
    // Réinitialiser les variables globales
    isMenuOpen = false;
    currentOpenMenu = null;
    
    // Mettre à jour les attributs aria-expanded
    document.querySelectorAll('.kebab-button').forEach(button => {
        button.setAttribute('aria-expanded', 'false');
    });
    
    if (openMenus.length > 0) {
        console.log('✅ Fermé', openMenus.length, 'menus kebab');
    }
};

// Fonction pour basculer le menu kebab avec détection de position
window.toggleKebabMenu = function(kebabId, event) {
    // Arrêter la propagation
    if (event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
    }
    
    const dropdown = document.getElementById(kebabId);
    if (!dropdown) {
        console.error('Menu kebab non trouvé:', kebabId);
        return;
    }
    
    const button = document.querySelector(`[data-kebab-id="${kebabId}"]`);
    
    // Si c'est le même menu qui est déjà ouvert, le fermer
    if (currentOpenMenu === kebabId && isMenuOpen) {
        closeAllKebabMenus();
        return;
    }
    
    // Fermer tous les autres menus d'abord
    closeAllKebabMenus();
    
    // Ouvrir le nouveau menu
    dropdown.classList.remove('hidden');
    dropdown.style.visibility = 'hidden';
    dropdown.style.opacity = '0';
    
    // Marquer comme ouvert
    isMenuOpen = true;
    currentOpenMenu = kebabId;
    
    // Mettre à jour aria-expanded
    if (button) {
        button.setAttribute('aria-expanded', 'true');
    }
    
    // Calculer la position après un court délai
    setTimeout(() => {
        if (dropdown.classList.contains('hidden')) return; // Vérifier si pas fermé entre temps
        
        const rect = dropdown.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        
        // Réinitialiser les classes de position
        dropdown.classList.remove('position-left', 'mobile-adjust');
        dropdown.style.transform = '';
        dropdown.style.top = '';
        dropdown.style.bottom = '';
        dropdown.style.marginTop = '';
        dropdown.style.marginBottom = '';
        
        // Si le menu dépasse à droite
        if (rect.right > viewportWidth - 10) {
            dropdown.classList.add('position-left');
        }
        
        // Si le menu dépasse en bas
        if (rect.bottom > viewportHeight - 10) {
            dropdown.style.top = 'auto';
            dropdown.style.bottom = '100%';
            dropdown.style.marginBottom = '0.25rem';
        }
        
        // Ajustement spécial pour mobile
        if (window.innerWidth <= 768) {
            dropdown.classList.add('mobile-adjust');
        }
        
        // Rendre visible avec animation
        dropdown.style.visibility = 'visible';
        dropdown.style.opacity = '1';
        
        console.log('✅ Menu kebab ouvert:', kebabId);
    }, 10);
};

// Fonction pour afficher les informations de l'article
window.showArticleInfo = function(articleId, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
    }
    
    console.log('ℹ️ Affichage info article:', articleId);
    
    // Fermer tous les menus kebab
    closeAllKebabMenus();
    
    // Fermer toutes les modales d'information ouvertes
    document.querySelectorAll('[id^="infoModal"]').forEach(modal => {
        modal.classList.add('hidden');
    });
    
    // Ouvrir la modal correcte
    const modalId = 'infoModal' + articleId;
    const targetModal = document.getElementById(modalId);
    
    if (!targetModal) {
        console.error('❌ Modal introuvable:', modalId);
        return;
    }
    
    setTimeout(() => {
        targetModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        console.log('✅ Modal ouverte:', modalId);
    }, 50);
};

// Fonction pour fermer la modal d'informations
window.closeInfoModal = function(articleId) {
    const modalId = 'infoModal' + articleId;
    const modal = document.getElementById(modalId);
    
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        console.log('✅ Modal fermée:', modalId);
    }
};

// Fonction pour gérer les modales de confirmation
window.modalToggle = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error('Modal non trouvée:', modalId);
        return;
    }
    
    if (modal.classList.contains('hidden')) {
        // Ouvrir la modal
        closeAllKebabMenus();
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        console.log('✅ Modal ouverte:', modalId);
    } else {
        // Fermer la modal
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        console.log('❌ Modal fermée:', modalId);
    }
};

// Gestionnaire d'événements pour le redimensionnement
window.addEventListener('resize', function() {
    closeAllKebabMenus();
});

// Gestionnaire d'événements pour le scroll
window.addEventListener('scroll', function() {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
        const openMenus = document.querySelectorAll('.kebab-dropdown:not(.hidden)');
        if (openMenus.length > 0) {
            openMenus.forEach(menu => {
                const rect = menu.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                
                if (rect.bottom < 0 || rect.top > viewportHeight) {
                    closeAllKebabMenus();
                }
            });
        }
    }, 100);
});

// Gestion du clavier
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAllKebabMenus();
        // Fermer aussi les modales ouvertes
        document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }
    
    // Navigation dans le menu kebab avec les flèches
    if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
        const openMenu = document.querySelector('.kebab-dropdown:not(.hidden)');
        if (openMenu) {
            event.preventDefault();
            const items = openMenu.querySelectorAll('.kebab-dropdown-item:not(.kebab-dropdown-divider)');
            const currentFocus = document.activeElement;
            let index = Array.from(items).indexOf(currentFocus);
            
            if (event.key === 'ArrowDown') {
                index = (index + 1) % items.length;
            } else {
                index = index <= 0 ? items.length - 1 : index - 1;
            }
            
            if (items[index]) {
                items[index].focus();
            }
        }
    }
});

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Initialisation des modales et menus kebab...');
    
    // Gestion des boutons qui ouvrent les modales
    document.querySelectorAll('[data-modal-target]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-modal-target');
            console.log('🖱️ Clic sur bouton modal:', targetId);
            
            closeAllKebabMenus();
            
            setTimeout(() => {
                modalToggle(targetId);
            }, 50);
        });
    });
    
    // Gestion des boutons qui ferment les modales
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-modal-hide');
            modalToggle(targetId);
        });
    });
    
    // Fermer les modales en cliquant sur l'arrière-plan
    document.addEventListener('click', function(event) {
        document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
            const modalContent = modal.querySelector('.modal-content');
            if (modalContent && !modalContent.contains(event.target) && event.target === modal) {
                modalToggle(modal.id);
            }
        });
    });
    
    // Fermer les menus kebab quand on clique ailleurs
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.kebab-menu')) {
            closeAllKebabMenus();
        }
    });
    
    // Gestion du filtre pour les articles
    const filterDropdown = document.getElementById('filter-deleted');
    if (filterDropdown) {
        // Synchroniser avec l'URL
        const urlParams = new URLSearchParams(window.location.search);
        const showParam = urlParams.get('show');
        
        if (showParam === 'deleted') {
            filterDropdown.value = 'deleted';
        } else if (showParam === 'all') {
            filterDropdown.value = 'all';
        } else {
            filterDropdown.value = 'active';
        }
        
        // Gérer le changement
        filterDropdown.addEventListener('change', function() {
            const value = this.value;
            const url = new URL(window.location.href);
            
            this.style.opacity = '0.5';
            
            if (value === 'deleted') {
                url.searchParams.set('show', 'deleted');
            } else if (value === 'all') {
                url.searchParams.set('show', 'all');
            } else {
                url.searchParams.delete('show');
            }
            
            window.location.href = url.toString();
        });
    }
    
    // Rendre les cartes d'articles cliquables
    document.querySelectorAll('.article-card').forEach(card => {
        card.addEventListener('click', function(event) {
            // Éviter la redirection si on clique sur un élément interactif
            if (event.target.closest('a, button, form, .kebab-menu, [data-modal-target]')) {
                return;
            }
            
            const showLink = this.querySelector('a.article-title');
            if (showLink) {
                window.location.href = showLink.getAttribute('href');
            }
        });
    });
    
    // Auto-fermeture de la modal de succès
    const successModal = document.getElementById('successModal');
    if (successModal && !successModal.classList.contains('hidden')) {
        const modalContent = document.getElementById('successModalContent');
        
        setTimeout(() => {
            if (modalContent) {
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'translateY(1rem)';
            }
            
            setTimeout(() => {
                successModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 500);
        }, 3000);
        
        // Fermeture manuelle
        if (modalContent) {
            modalContent.addEventListener('click', function() {
                this.style.opacity = '0';
                this.style.transform = 'translateY(1rem)';
                
                setTimeout(() => {
                    successModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }, 500);
            });
        }
    }
    
    // Gestion de la navigation avec cache
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            if (filterDropdown) {
                const urlParams = new URLSearchParams(window.location.search);
                const showParam = urlParams.get('show');
                
                if (showParam === 'deleted') {
                    filterDropdown.value = 'deleted';
                } else if (showParam === 'all') {
                    filterDropdown.value = 'all';
                } else {
                    filterDropdown.value = 'active';
                }
            }
        }
    });
    
    console.log('✅ Initialisation terminée avec succès');
});

// Gestion des erreurs
window.addEventListener('error', function(e) {
    console.error('❌ Erreur JavaScript:', e.error);
});

console.log('📄 Script des modales chargé et optimisé');
</script>
</body>
</html>