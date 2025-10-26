<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BUSINESS+ Talk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                $primaryColor = $settings->primary_color ?? '#1EB5AD';
            @endphp
            --primary-color: {{ $primaryColor }};
            --dark-bg: #1A1D21;
            --darker-bg: #111315;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
            --gray-bg: #2A2D35;
            --dark-element: #252525;
            --dark-border: #333333;
            --dark-card: #1e1e1e;
            --success: #10b981;
            --danger: #b91c1c;
            --warning: #b45309;
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
            display: flex;
            min-height: 100vh;
            flex-direction: row;
        }

        /* Barre latérale - CORRIGÉE */
        .sidebar {
            width: 320px;
            background-color: var(--darker-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            top: 0; /* Commence en haut */
            height: 100vh;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            /* Masquer complètement les barres de défilement */
            overflow: hidden;
            z-index: 999; /* S'assurer qu'elle reste au-dessus du header */
        }

        .logo-container {
            padding: 2rem 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            flex-shrink: 0;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .user-info {
            background-color: var(--dark-card);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: 1.5rem 1rem;
            border: 1px solid var(--dark-border);
            flex-shrink: 0;
        }

        .user-info h3 {
            color: var(--light-text);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .user-role {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: var(--primary-color);
            color: var(--light-text);
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Menu avec scroll interne - CORRIGÉ */
        .sidebar-menu {
            flex-grow: 1;
            list-style: none;
            padding: 0 0.75rem 1rem;
            overflow-y: auto;
            /* Barres de défilement masquées mais fonctionnelles */
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }

        /* Chrome/Safari/Opera */
        .sidebar-menu::-webkit-scrollbar {
            display: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.75rem;
        }

        .sidebar-menu a, .sidebar-menu button {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--gray-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            text-align: left;
        }

        .sidebar-menu a:hover, .sidebar-menu button:hover {
            color: var(--light-text);
            background-color: color-mix(in srgb, var(--primary-color) 15%, transparent);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar-menu a i, .sidebar-menu button i {
            color: var(--primary-color);
            margin-right: 1rem;
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        .logout-section {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .logout-btn {
            background-color: var(--danger);
            color: var(--light-text);
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            border: none;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(185, 28, 28, 0.3);
        }

        /* Menu mobile en bas */
        .mobile-bottom-menu {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--darker-bg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            z-index: 1000;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.4);
        }

        .mobile-menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            padding: 0 1rem;
            max-width: 100%;
        }

        .mobile-menu-item {
            background: none;
            border: none;
            color: var(--gray-text);
            padding: 0.75rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .mobile-menu-item:hover,
        .mobile-menu-item:active {
            color: var(--light-text);
            background-color: color-mix(in srgb, var(--primary-color) 15%, transparent);
        }

        .mobile-menu-item i {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .mobile-menu-item span {
            font-size: 0.7rem;
            font-weight: 500;
            line-height: 1;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            margin-left: 320px;
            padding: 2rem;
            padding-top: 1rem; /* Réduire le padding-top pour compenser le header */
            transition: margin-left 0.3s ease;
        }

        .header {
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--light-text);
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--gray-text);
            font-size: 1.1rem;
        }

        /* Cartes statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-hover));
        }

        .stat-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--light-text);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray-text);
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Cercle de progression */
        .progress-circle {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
            
        }

        .progress-circle svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .progress-circle-bg {
            fill: none;
            stroke: var(--dark-element);
            stroke-width: 8;
        }

        .progress-circle-fill {
            fill: none;
            stroke: var(--dark-element);
            stroke-width: 8;
            stroke-linecap: round;
            transition: stroke-dashoffset 2s ease-in-out;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--light-text);
        }

        /* Cartes d'actions rapides */
        .quick-actions {
            margin-top: 3rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .action-card {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .action-card h3 {
            color: var(--light-text);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .action-card p {
            color: var(--gray-text);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: var(--light-text);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(26, 158, 158, 0.3);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 280px;
            }
            .main-content {
                margin-left: 280px;
            }
        }

        @media (max-width: 768px) {
            /* Cacher la sidebar sur mobile */
            .sidebar {
                display: none;
            }
            
            /* Afficher le menu mobile */
            .mobile-bottom-menu {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
                padding-bottom: 6rem; /* Espace pour le menu mobile */
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animation d'entrée */
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

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Menu déroulant mobile pour plus d'options */
        .mobile-menu-more {
            position: relative;
        }

        .mobile-submenu {
            position: absolute;
            bottom: 100%;
            left: 10%;
            transform: translateX(-50%);
            background-color: var(--darker-bg) ;
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            display: none;
            min-width: 200px;
            z-index: 1001;
        }

        
        .mobile-submenu.show {
            display: block;
        }

        .mobile-submenu-item {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--gray-text);
            text-decoration: none;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .mobile-submenu-item:hover {
            color: var(--light-text);
            background-color: color-mix(in srgb, var(--primary-color) 15%, transparent);
        }

        .mobile-submenu-item:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
     <div class="container">
        <!-- Barre latérale (Desktop) -->
        <div class="sidebar">

            <!-- Informations utilisateur -->
            <div class="user-info">
                <h3>{{ Auth::user()->name ?? 'Utilisateur' }}</h3>
                <span class="user-role">{{ strtoupper(Auth::user()->role ?? 'USER') }}</span>
            </div>

            <!-- Menu de navigation avec scroll interne -->
            <ul class="sidebar-menu">
                
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                 <li>
                <a href="/admin/questions">
                    <i class="fas fa-cogs"></i>
                    <span>Gérer Questions</span>
                </a>
            </li>
                
                @if(Auth::user()->role === 'superadmin')
                    <li>
                        <a href="{{ route('dashboard.logs.index') }}">
                            <i class="fas fa-clipboard-list"></i>
                            Logs d'activité
                        </a>
                    <li>
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-user-cog"></i>
                            Gérer les utilisateurs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.create-admin') }}">
                            <i class="fas fa-user-shield"></i>
                            Création admin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('affectations.index') }}">
                            <i class="fas fa-users"></i>
                            Affectations
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.deleted_content') }}">
                            <i class="fas fa-trash"></i>
                            Contenu supprimé
                        </a>
                    </li>
                @endif
                
                @if(Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && Auth::user()->affectation && in_array('config', Auth::user()->affectation->modules ?? []) && Auth::user()->is_active))
                    <li>
                        <a href="{{ route('settings.index') }}">
                            <i class="fas fa-cogs"></i>
                            Configuration
                        </a>
                    </li>
                @endif

                @if(Auth::check() && (Auth::user()->role === 'superadmin' || Auth::user()->canManageForum()))
                    <li>
                        <a href="{{ route('dashboard.reports') }}">
                            <i class="fas fa-exclamation-triangle"></i>
                            Signalements Forum
                        </a>
                    </li>
                @endif
                @if(Auth::check() && Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && Auth::user()->is_active && Auth::user()->affectation && in_array('podcast', Auth::user()->affectation->modules ?? [])))
                    <li>
                        <a href="{{ route('dashboard.podcasts.reports') }}">
                            <i class="fas fa-podcast"></i>
                            Signalements Podcasts
                        </a>
                    </li>
                @endif
                @if(Auth::check() && Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && Auth::user()->is_active && Auth::user()->affectation && in_array('article', Auth::user()->affectation->modules ?? [])))
                    <li>
                        <a href="{{ route('dashboard.articles-signales') }}">
                            <i class="fas fa-newspaper"></i>
                            Signalements Articles
                        </a>
                    </li>
                @endif
                @if(Auth::user()->role === 'superadmin')
                    <li>
                        <a href="{{ route('dashboard.blocked-users') }}">
                            <i class="fas fa-user-slash"></i>
                            Utilisateurs bloqués
                        </a>
                    </li>
                @endif                
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            Se déconnecter
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Menu mobile en bas -->
        <div class="mobile-bottom-menu">
            <div class="mobile-menu-grid">
                <a class="mobile-menu-item" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                 @if(Auth::check() && (Auth::user()->role === 'superadmin' || Auth::user()->canManageForum() || (Auth::user()->role === 'admin' && Auth::user()->is_active && Auth::user()->affectation && in_array('podcast', Auth::user()->affectation->modules ?? []))))
                    <a class="mobile-menu-item" href="{{ route('dashboard.blocked-users') }}">
                        <i class="fas fa-user-slash"></i> <span>Bloqués</span>
                    </a>
                @endif

                @if(Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && Auth::user()->affectation && in_array('config', Auth::user()->affectation->modules ?? []) && Auth::user()->is_active))
                    <a class="mobile-menu-item" href="{{ route('settings.index') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Config</span>
                    </a>
                @endif
                <div class="mobile-menu-more">
                    <button class="mobile-menu-item" onclick="toggleSubmenu()">
                        <i class="fas fa-ellipsis-h"></i>
                        <span>Plus</span>
                    </button>
                    <div class="mobile-submenu" id="mobileSubmenu">
                        <a class="mobile-submenu-item" href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                        @if(Auth::user()->role === 'superadmin')
                            <a class="mobile-submenu-item" href="{{ route('dashboard.logs.index') }}">
                                <i class="fas fa-clipboard-list"></i> Logs d'activité
                            </a>
                            <a class="mobile-submenu-item" href="{{ route('users.index') }}">
                                <i class="fas fa-user-cog"></i> Utilisateurs
                            </a>
                            <a class="mobile-submenu-item" href="{{ route('affectations.index') }}">
                                <i class="fas fa-users"></i> Affectations
                            </a>
                            <a class="mobile-submenu-item" href="{{ route('dashboard.deleted_content') }}">
                                <i class="fas fa-trash"></i> Contenu Supprimé
                            </a>
                        @endif
                        @if(Auth::check() && (Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && Auth::user()->is_active && Auth::user()->affectation && in_array('podcast', Auth::user()->affectation->modules ?? []))))
                            <a class="mobile-submenu-item" href="{{ route('dashboard.podcasts.reports') }}">
                                <i class="fas fa-podcast"></i>  Podcasts
                            </a>
                        @endif
                        @if(Auth::check() && (Auth::user()->role === 'superadmin' || (Auth::user()->role === 'admin' && Auth::user()->is_active && Auth::user()->affectation && in_array('article', Auth::user()->affectation->modules ?? []))))
                            <a class="mobile-submenu-item" href="{{ route('dashboard.articles-signales') }}">
                                <i class="fas fa-newspaper"></i> Articles
                            </a>
                        @endif
                        @if(Auth::check() && (Auth::user()->role === 'superadmin' || Auth::user()->canManageForum()))
                            <a class="mobile-submenu-item" href="{{ route('dashboard.reports') }}">
                                <i class="fas fa-exclamation-triangle"></i> Forum
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="mobile-submenu-item">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contenu principal -->
        <div class="main-content">
            <div class="header">
                <h1>
                    <i class="fas fa-tachometer-alt" style="color: var(--primary-color);"></i>
                    Dashboard
                </h1>
                <p>Bienvenue sur votre tableau de bord administrateur</p>
            </div>

            <!-- Statistiques -->
            <div class="stats-grid">
                <!-- Nouveaux utilisateurs (7 jours) -->
                <div class="stat-card fade-in-up" style="animation-delay: 0.5s;">
                    <div class="stat-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="stat-number" id="recentUsers">{{ $recentUsers }}</div>
                <div class="stat-label">Nouveaux Utilisateurs (7 jours)</div>
                <div class="progress-circle">
                    <svg>
                        <circle class="progress-circle-bg" cx="60" cy="60" r="50"></circle>
                        <circle class="progress-circle-fill" cx="60" cy="60" r="50" 
                            stroke-dasharray="314" stroke-dashoffset="{{ $totalUsers > 0 ? 314 - (($recentUsers / $totalUsers) * 100 / 100 * 314) : 314 }}" 
                            id="recentUsersCircle" style="stroke: var(--primary-color);"></circle>
                    </svg>
                <div class="progress-text" id="recentUsersPercent">{{ $totalUsers > 0 ? round(($recentUsers / $totalUsers) * 100, 1) : 0 }}%</div>
            </div>
        </div>

        <!-- Total utilisateurs -->
        <div class="stat-card fade-in-up" style="animation-delay: 0.1s;">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number" id="totalUsers">{{ $totalUsers }}</div>
            <div class="stat-label">Total Utilisateurs</div>
            <div class="progress-circle">
                <svg>
                    <circle class="progress-circle-bg" cx="60" cy="60" r="50"></circle>
                    <circle class="progress-circle-fill" cx="60" cy="60" r="50" 
                            stroke-dasharray="314" stroke-dashoffset="0" id="usersCircle" style="stroke: var(--primary-color);"></circle>
                </svg>
                <div class="progress-text" id="usersPercent">{{ $totalUsers > 0 ? '100' : '0' }}%</div>
            </div>
        </div>


        <!-- Utilisateurs actifs (Membres) -->
        <div class="stat-card fade-in-up" style="animation-delay: 0.3s;">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-number" id="activeUsers">{{ $activeUsers }}</div>
            <div class="stat-label">Membres</div>
            <div class="progress-circle">
                <svg>
                    <circle class="progress-circle-bg" cx="60" cy="60" r="50"></circle>
                    <circle class="progress-circle-fill" cx="60" cy="60" r="50" 
                            stroke-dasharray="314" stroke-dashoffset="{{ $totalUsers > 0 ? 314 - ($activePercent / 100 * 314) : 314 }}" 
                            id="activeCircle" style="stroke: var(--primary-color);" ></circle>
                </svg>
                <div class="progress-text" id="activePercent">{{ $activePercent }}%</div>
            </div>
        </div>

        <!-- Super Admins -->
        <div class="stat-card fade-in-up" style="animation-delay: 0.6s;">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-number" id="superAdmins">{{ $superAdmins }}</div>
            <div class="stat-label">Super Admins</div>
            <div class="progress-circle">
                <svg>
                    <circle class="progress-circle-bg" cx="60" cy="60" r="50"></circle>
                    <circle class="progress-circle-fill" cx="60" cy="60" r="50" 
                            stroke-dasharray="314" stroke-dashoffset="{{ $totalUsers > 0 ? 314 - (($superAdmins / $totalUsers) * 100 / 100 * 314) : 314 }}" 
                            id="superAdminsCircle" style="stroke: var(--primary-color);"></circle>
                </svg>
                <div class="progress-text" id="superAdminsPercent">{{ $totalUsers > 0 ? round(($superAdmins / $totalUsers) * 100, 1) : 0 }}%</div>
            </div>
        </div>

        <!-- Admins réguliers -->
        <div class="stat-card fade-in-up" style="animation-delay: 0.7s;">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-number" id="regularAdmins">{{ $regularAdmins }}</div>
            <div class="stat-label">Admins Réguliers</div>
            <div class="progress-circle">
                <svg>
                    <circle class="progress-circle-bg" cx="60" cy="60" r="50"></circle>
                    <circle class="progress-circle-fill" cx="60" cy="60" r="50" 
                            stroke-dasharray="314", stroke-dashoffset="{{ $totalUsers > 0 ? 314 - (($regularAdmins / $totalUsers) * 100 / 100 * 314) : 314 }}" 
                            id="regularAdminsCircle" style="stroke: var(--primary-color);"></circle>
                </svg>
                <div class="progress-text" id="regularAdminsPercent">{{ $totalUsers > 0 ? round(($regularAdmins / $totalUsers) * 100, 1) : 0 }}%</div>
            </div>
        </div>
    </div>
    <script>
        // Navigation function
        function navigateTo(page) {
            let url;
            switch (page) {
                case 'dashboard':
                    url = '{{ route("dashboard") }}';
                    break;
                case 'users':
                    url = '{{ route("users.index") }}';
                    break;
                case 'affectations':
                    url = '{{ route("affectations.index") }}';
                    break;
                case 'settings':
                    url = '{{ route("settings.index") }}';
                    break;
                case 'reports':
                    url = '{{ route("dashboard.reports") }}';
                    break;
                case 'podcast-reports':
                    url = '{{ route("dashboard.podcasts.reports") }}';
                    break;
                case 'articles-signales':
                   url = '{{ route("dashboard.articles-signales") }}';
                    break;
                case 'blocked-users':
                    url = '{{ route("dashboard.blocked-users") }}';
                    break;
                case 'deleted-content':
                    url = '{{ route("dashboard.deleted_content") }}';
                    break;
                case 'profile':
                    url = '{{ route("profile.edit") }}';
                    break;
                case 'stats':
                    url = '{{ route("dashboard.stats") }}';
                    break;
                default:
                    url = '{{ route("dashboard") }}';
            }
            window.location.href = url;
        }

        // Toggle submenu mobile
        function toggleSubmenu() {
            const submenu = document.getElementById('mobileSubmenu');
            submenu.classList.toggle('show');
        }

        // Fermer le submenu si on clique ailleurs
        document.addEventListener('click', function(event) {
            const submenu = document.getElementById('mobileSubmenu');
            const moreButton = event.target.closest('.mobile-menu-more');
        
            if (!moreButton && submenu.classList.contains('show')) {
                submenu.classList.remove('show');
            }
        });

        // Fetch and animate stats
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Dashboard chargé avec succès');

            // Initial animations based on Blade data
            setTimeout(() => {
                animateCircle('usersCircle', {{ $totalUsers > 0 ? 100 : 0 }});
                animateCircle('adminsCircle', {{ $adminPercent }});
                animateCircle('activeCircle', {{ $activePercent }});
                animateCircle('reportsCircle', {{ $reportsPercent }});
                animateCircle('recentUsersCircle', {{ $totalUsers > 0 ? round(($recentUsers / $totalUsers) * 100, 1) : 0 }});
                animateCircle('superAdminsCircle', {{ $totalUsers > 0 ? round(($superAdmins / $totalUsers) * 100, 1) : 0 }});
                animateCircle('regularAdminsCircle', {{ $totalUsers > 0 ? round(($regularAdmins / $totalUsers) * 100, 1) : 0 }});
            }, 500);

            // Fetch updated stats via AJAX
            fetch('{{ route("dashboard.stats") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau ou accès non autorisé');
                }
                return response.json();
            })
            .then(data => {
                // Animate numbers
                animateNumber('totalUsers', data.totalUsers || 0, 2000);
                animateNumber('totalAdmins', data.totalAdmins || 0, 1500);
                animateNumber('activeUsers', data.activeUsers || 0, 2200);
                animateNumber('pendingReports', data.pendingReports || 0, 1000);
                animateNumber('recentUsers', data.recentUsers || 0, 1800);
                animateNumber('superAdmins', data.superAdmins || 0, 1600);
                animateNumber('regularAdmins', data.regularAdmins || 0, 1700);

                // Update percentages
                document.getElementById('usersPercent').textContent = data.totalUsers > 0 ? '100%' : '0%';
                document.getElementById('adminsPercent').textContent = `${data.adminPercent}%`;
                document.getElementById('activePercent').textContent = `${data.activePercent}%`;
                document.getElementById('reportsPercent').textContent = `${data.reportsPercent}%`;
                document.getElementById('recentUsersPercent').textContent = `${data.recentUsersPercent || 0}%`;
                document.getElementById('superAdminsPercent').textContent = `${data.superAdminsPercent || 0}%`;
                document.getElementById('regularAdminsPercent').textContent = `${data.regularAdminsPercent || 0}%`;

                // Animate circles with updated data
                setTimeout(() => {
                    animateCircle('usersCircle', data.totalUsers > 0 ? 100 : 0);
                    animateCircle('adminsCircle', data.adminPercent);
                    animateCircle('activeCircle', data.activePercent);
                    animateCircle('reportsCircle', data.reportsPercent);
                    animateCircle('recentUsersCircle', data.recentUsersPercent || 0);
                    animateCircle('superAdminsCircle', data.superAdminsPercent || 0);
                    animateCircle('regularAdminsCircle', data.regularAdminsPercent || 0);
                }, 500);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des stats:', error);
                // Fallback to Blade-provided values
                animateNumber('totalUsers', {{ $totalUsers }}, 2000);
                animateNumber('totalAdmins', {{ $totalAdmins }}, 1500);
                animateNumber('activeUsers', {{ $activeUsers }}, 2200);
                animateNumber('pendingReports', {{ $pendingReports }}, 1000);
                animateNumber('recentUsers', {{ $recentUsers }}, 1800);
                animateNumber('superAdmins', {{ $superAdmins }}, 1600);
                animateNumber('regularAdmins', {{ $regularAdmins }}, 1700);
            });
        });

        function animateCircle(circleId, percentage) {
            const circle = document.getElementById(circleId);
            const circumference = 2 * Math.PI * 50; // rayon = 50
            const offset = circumference - (percentage / 100 * circumference);
        
            circle.style.strokeDashoffset = offset;
        }

        function animateNumber(elementId, targetNumber, duration) {
            const element = document.getElementById(elementId);
            const startNumber = 0;
            const increment = targetNumber / (duration / 16); // 60 FPS
            let currentNumber = startNumber;

            const timer = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= targetNumber) {
                    currentNumber = targetNumber;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(currentNumber).toLocaleString();
            }, 16);
        }
</script>
</body>
</html>