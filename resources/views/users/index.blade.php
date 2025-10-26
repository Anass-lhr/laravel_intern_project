<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs - Business+ Talk</title>
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
                $primaryColor = $settings->primary_color ?? '#1a9e9e';
            @endphp
            --primary-color: {{ $primaryColor }};            
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
            margin-left: 280px;
            padding: 0;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
            overflow: visible;
        }

        /* Zone de contenu */
        .content-area {
            padding: 2rem;
            flex: 1;
            overflow: visible;
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
            border: none;
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
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 181, 173, 0.3);
        }

        .btn-danger {
            background-color: var(--danger);
            color: var(--light-text);
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(185, 28, 28, 0.3);
        }

        /* Styles pour les cartes d'utilisateurs */
        .user-card {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 1.5rem;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .role-band {
            background-color: var(--primary-color);
            color: var(--light-text);
            text-align: center;
            padding: 0.75rem 0.5rem;
            min-width: 40px;
            font-weight: 600;
            border-right: 1px solid var(--primary-dark);
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
        }

        .role-band.admin {
            background-color: var(--warning);
        }

        .role-band.superadmin {
            background-color: var(--danger);
        }

        .user-info {
            flex: 1;
            padding: 1.5rem;
        }

        .user-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--light-text);
            margin-bottom: 0.5rem;
        }

        .user-email {
            font-size: 0.875rem;
            color: var(--gray-text);
            margin-bottom: 0.5rem;
        }

        .user-meta {
            font-size: 0.875rem;
            color: var(--gray-text);
            margin-bottom: 1rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 9999px;
            color: var(--light-text);
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .status-active {
            background-color: var(--success);
        }

        .status-inactive {
            background-color: var(--danger);
        }

        .status-user {
            background-color: var(--primary-color);
        }

        .status-admin {
            background-color: var(--warning);
        }

        .status-superadmin {
            background-color: var(--danger);
        }

        .action-form {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .action-select {
            background-color: var(--dark-element);
            border: 1px solid var(--dark-border);
            color: var(--light-text);
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .action-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(30, 181, 173, 0.3);
        }

        .btn-small {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Styles pour les modales */
        .modal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .modal-content {
            background-color: var(--gray-bg);
            border-radius: 0.75rem;
            border-top: 4px solid var(--primary-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            max-width: 28rem;
            width: 100%;
            padding: 1.5rem;
            text-align: center;
        }

        .modal-button {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            margin: 0 0.5rem;
        }

        .modal-button-cancel {
            background-color: var(--dark-element);
            color: var(--light-text);
        }

        .modal-button-cancel:hover {
            background-color: var(--dark-border);
        }

        .modal-button-confirm {
            background-color: var(--primary-color);
            color: var(--light-text);
        }

        .modal-button-confirm:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* Styles pour la table responsive */
        .table-container {
            background-color: var(--dark-card);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--dark-border);
        }

        .table th {
            background-color: var(--dark-element);
            color: var(--light-text);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table td {
            color: var(--gray-text);
            font-size: 0.875rem;
        }

        .table tr:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        /* Footer */
        .footer {
            background-color: var(--darker-bg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            text-align: center;
        }

        .footer-text {
            color: var(--gray-text);
            font-size: 0.875rem;
        }

        .header-section {
            padding: 1rem 0;
        }

        /* Ajustements responsifs */
        @media (max-width: 992px) and (min-width: 769px) {
            .sidebar {
                width: 80px;
            }
            .main-content {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .header-section {
                padding: 0.5rem 0;
            }
            
            .header-section h1 {
                font-size: 1.5rem !important;
                margin-bottom: 1rem;
            }
            
            .sidebar {
                width: 60px;
            }
            .main-content {
                margin-left: 60px;
            }
            .user-card {
                margin-bottom: 1rem;
            }
            .table-container {
                overflow-x: auto;
            }
        }

        @media (max-width: 400px) {
            .sidebar {
                width: 40px;
            }
            .main-content {
                margin-left: 40px;
            }
            .header-section h1 {
                font-size: 1.25rem !important;
            }
            
            .header-section h1 i {
                font-size: 1.25rem;
                margin-right: 0.5rem;
            }
        }

        /* Correction du layout sans sidebar */
        .main-content {
            margin-left: 0;
        }

        .hidden {
            display: none !important;
        }

        /* Animation de chargement */
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

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Contenu principal -->
        <div class="main-content">


            <!-- Zone de contenu -->
            <div class="content-area">
                <!-- Actions en haut -->
                <div class="header-section mb-6">
                    <!-- Flèche de retour -->
                    <div class="flex justify-start mb-4">
                        <form action="{{ route('dashboard') }}" method="get">
                            <button class="btn btn-outline" type="submit">
                                <i class="fas fa-arrow-left mr-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Titre centré -->
                    <div class="text-center mb-4">
                        <h1 class="text-3xl font-bold" style="color: var(--light-text);">
                            <i class="fas fa-users mr-3" style="color: var(--primary-color);"></i>
                            Liste des utilisateurs
                        </h1>
                        <p class="text-gray-400 mt-2">
                            Utilisez la barre de recherche ci-dessus pour filtrer les utilisateurs
                        </p>
                    </div>
                </div>

                <!-- Table responsive -->
                <div class="table-container">
                    <table id="usersTable" class="table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag mr-2"></i>ID</th>
                                <th><i class="fas fa-user mr-2"></i>Nom</th>
                                <th><i class="fas fa-envelope mr-2"></i>Email</th>
                                <th><i class="fas fa-user-tag mr-2"></i>Rôle</th>
                                <th><i class="fas fa-calendar mr-2"></i>Admin depuis</th>
                                <th><i class="fas fa-cogs mr-2"></i>Actions</th>
                                <th><i class="fas fa-toggle-on mr-2"></i>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="user-row hover:bg-opacity-5 hover:bg-white transition-colors duration-200">
                                    <td class="font-mono font-semibold" style="color: var(--primary-color);">{{ $user->id }}</td>
                                    <td>
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3" style="background-color: var(--primary-color);">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span style="color: var(--light-text);" class="font-medium">{{ $user->name }}</span>
                                            <span class="status-badge status-{{ $user->role }}">{{ strtoupper($user->role) }}</span>
                                        </div>
                                    </td>
                                    <td style="color: var(--gray-text);">{{ $user->email }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $user->role }}">
                                            <i class="fas fa-{{ $user->role === 'superadmin' ? 'crown' : ($user->role === 'admin' ? 'user-shield' : 'user') }} mr-1"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td style="color: var(--gray-text);">
                                        @if($user->role === 'admin')
                                            @if($user->admin_since)
                                                <i class="fas fa-calendar-alt mr-1" style="color: var(--primary-color);"></i>
                                                {{ \Carbon\Carbon::parse($user->admin_since)->format('d/m/Y H:i') }}
                                            @else
                                                <span style="color: var(--gray-text);">Non disponible</span>
                                            @endif
                                        @else
                                            <span style="color: var(--gray-text);">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->role !== 'superadmin')
                                            <form method="POST" action="{{ route('users.updateRole', $user->id) }}" class="role-form action-form">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="user_name" value="{{ $user->name }}">
                                                <select name="role" class="action-select">
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                                </select>
                                                <button type="button" onclick="showConfirm(this)" class="btn btn-primary btn-small">
                                                    <i class="fas fa-save mr-1"></i> Enregistrer
                                                </button>
                                            </form>
                                        @else
                                            <span style="color: var(--gray-text);" class="italic">
                                                <i class="fas fa-lock mr-1"></i> Non modifiable
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->role === 'admin')
                                            <form method="POST" action="{{ route('users.toggleActive', $user->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn {{ $user->is_active ? 'btn-primary' : 'btn-outline' }} btn-small">
                                                    <i class="fas fa-{{ $user->is_active ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                                </button>
                                            </form>
                                        @else
                                            <span style="color: var(--gray-text);">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal de confirmation -->
                <div class="modal hidden" id="confirmModal">
                    <div class="modal-content fade-in">
                        <div class="p-6">
                            <div style="color: var(--primary-color);" class="text-3xl mb-4">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h3 class="text-lg font-bold mb-4">Confirmation de modification</h3>
                            <p id="confirmText" style="color: var(--gray-text);" class="mb-6"></p>
                            <div class="flex justify-center gap-4">
                                <button onclick="cancelChange()" class="modal-button modal-button-cancel">
                                    <i class="fas fa-times mr-1"></i> Annuler
                                </button>
                                <button onclick="confirmChange()" class="modal-button modal-button-confirm">
                                    <i class="fas fa-check mr-1"></i> Confirmer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

 
        </div>
    </div>

    <script>
        // Animation d'entrée pour les éléments
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Page des utilisateurs chargée avec le nouveau style');
            
            // Utiliser la barre de recherche du header
            const searchInput = document.querySelector('.search-input');
            const userRows = document.querySelectorAll('.user-row');
            const totalUsers = userRows.length;

            // Initialiser le compteur de résultats
            function createResultsCounter() {
                const counter = document.createElement('div');
                counter.id = 'results-counter';
                counter.style.cssText = `
                    margin: 1rem 0;
                    padding: 0.75rem;
                    background-color: var(--dark-element);
                    border: 1px solid var(--dark-border);
                    border-radius: 0.5rem;
                    color: var(--gray-text);
                    font-size: 0.9rem;
                    text-align: center;
                    transition: all 0.3s ease;
                `;
                
                const tableContainer = document.querySelector('.table-container');
                if (tableContainer) {
                    tableContainer.parentNode.insertBefore(counter, tableContainer);
                }
                
                updateResultsCounter(totalUsers);
                return counter;
            }

            // Mettre à jour le compteur de résultats
            function updateResultsCounter(visibleCount) {
                let counter = document.getElementById('results-counter');
                if (!counter) {
                    counter = createResultsCounter();
                }
                
                if (visibleCount === totalUsers) {
                    counter.textContent = `${totalUsers} utilisateur(s) au total`;
                    counter.style.backgroundColor = 'var(--dark-element)';
                } else {
                    counter.textContent = `${visibleCount} résultat(s) sur ${totalUsers} utilisateur(s)`;
                    counter.style.backgroundColor = 'rgba(26, 158, 158, 0.1)';
                }
            }

            // Fonction principale de filtrage
            function filterUsers(searchTerm) {
                const filter = searchTerm.toLowerCase().trim();
                let visibleCount = 0;

                userRows.forEach(row => {
                    if (!filter) {
                        row.style.display = '';
                        visibleCount++;
                        return;
                    }

                    const idCell = row.getElementsByTagName("td")[0];
                    const nameCell = row.getElementsByTagName("td")[1];
                    const emailCell = row.getElementsByTagName("td")[2];
                    const roleCell = row.getElementsByTagName("td")[3];
                    const dateCell = row.getElementsByTagName("td")[4];

                    if (idCell && nameCell && emailCell && roleCell) {
                        const idText = idCell.textContent.toLowerCase();
                        const nameText = nameCell.textContent.toLowerCase();
                        const emailText = emailCell.textContent.toLowerCase();
                        const roleText = roleCell.textContent.toLowerCase();
                        const dateText = dateCell ? dateCell.textContent.toLowerCase() : '';

                        const isMatch = idText.includes(filter) ||
                                       nameText.includes(filter) ||
                                       emailText.includes(filter) ||
                                       roleText.includes(filter) ||
                                       dateText.includes(filter);

                        if (isMatch) {
                            row.style.display = '';
                            row.classList.add('fade-in');
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                            row.classList.remove('fade-in');
                        }
                    }
                });

                updateResultsCounter(visibleCount);

                // Afficher/masquer le message "aucun résultat"
                if (filter && visibleCount === 0) {
                    showNoResultsMessage();
                } else {
                    hideNoResultsMessage();
                }
            }

            // Afficher le message "aucun résultat"
            function showNoResultsMessage() {
                let noResults = document.getElementById('noResultsMessage');
                if (!noResults) {
                    noResults = document.createElement('div');
                    noResults.id = 'noResultsMessage';
                    noResults.style.cssText = `
                        background-color: var(--dark-card);
                        border: 1px solid var(--dark-border);
                        border-radius: 0.75rem;
                        padding: 3rem;
                        text-align: center;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        margin: 2rem 0;
                    `;
                    noResults.innerHTML = `
                        <div style="color: var(--gray-text); margin-bottom: 1.5rem;">
                            <i class="fas fa-search" style="font-size: 4rem;"></i>
                        </div>
                        <h3 style="color: var(--light-text); font-size: 1.25rem; font-weight: 600; margin-bottom: 0.75rem;">
                            Aucun utilisateur trouvé
                        </h3>
                        <p style="color: var(--gray-text); font-size: 0.95rem;">
                            Essayez de modifier vos critères de recherche ou utilisez d'autres mots-clés.
                        </p>
                    `;
                    document.querySelector('.content-area').appendChild(noResults);
                }
                noResults.style.display = 'block';
            }

            // Masquer le message "aucun résultat"
            function hideNoResultsMessage() {
                const noResults = document.getElementById('noResultsMessage');
                if (noResults) {
                    noResults.style.display = 'none';
                }
            }

            // Configuration de la recherche si des éléments existent
            if (searchInput && userRows.length > 0) {
                // Personnaliser le placeholder pour la page des utilisateurs
                searchInput.placeholder = "Rechercher des utilisateurs (ID, nom, email, rôle, date...)";
                
                // Supprimer les anciens événements de recherche
                if (searchInput._affectationSearchHandler) {
                    searchInput.removeEventListener('input', searchInput._affectationSearchHandler);
                }
                if (searchInput._adminSearchHandler) {
                    searchInput.removeEventListener('input', searchInput._adminSearchHandler);
                }
                if (searchInput._videoSearchHandler) {
                    searchInput.removeEventListener('input', searchInput._videoSearchHandler);
                }
                if (searchInput._articleSearchHandler) {
                    searchInput.removeEventListener('input', searchInput._articleSearchHandler);
                }
                
                // Événement de recherche en temps réel pour les utilisateurs
                const userSearchHandler = function() {
                    filterUsers(this.value);
                };
                
                searchInput.addEventListener('input', userSearchHandler);
                searchInput._userSearchHandler = userSearchHandler;
                
                // Améliorer l'UX avec des événements supplémentaires
                searchInput.addEventListener('focus', function() {
                    this.style.borderColor = 'var(--primary-color)';
                    this.parentNode.style.transform = 'scale(1.02)';
                });
                
                searchInput.addEventListener('blur', function() {
                    this.style.borderColor = '';
                    this.parentNode.style.transform = '';
                });

                // Raccourci clavier Ctrl+F pour focus sur la recherche
                document.addEventListener('keydown', function(e) {
                    if (e.ctrlKey && e.key === 'f') {
                        e.preventDefault();
                        searchInput.focus();
                    }
                });
                
                // Initialiser le compteur
                createResultsCounter();
                
                console.log(`🔍 Recherche initialisée pour ${totalUsers} utilisateur(s)`);
            }

            // Fonction de nettoyage de la recherche
            function clearSearch() {
                if (searchInput) {
                    searchInput.value = '';
                    filterUsers('');
                }
            }

            // Ajouter un bouton de nettoyage dans le header
            const searchContainer = document.querySelector('.search-container');
            if (searchContainer && searchInput) {
                const clearButton = document.createElement('button');
                clearButton.innerHTML = '<i class="fas fa-times"></i>';
                clearButton.style.cssText = `
                    position: absolute;
                    right: 3rem;
                    top: 50%;
                    transform: translateY(-50%);
                    background: none;
                    border: none;
                    color: var(--gray-text);
                    cursor: pointer;
                    padding: 0.5rem;
                    transition: color 0.3s ease;
                    display: none;
                    z-index: 10;
                `;
                clearButton.title = 'Effacer la recherche';
                
                clearButton.addEventListener('click', clearSearch);
                clearButton.addEventListener('mouseenter', function() {
                    this.style.color = 'var(--danger)';
                });
                clearButton.addEventListener('mouseleave', function() {
                    this.style.color = 'var(--gray-text)';
                });
                
                searchContainer.appendChild(clearButton);
                
                // Ajuster la position de l'icône de recherche pour faire de la place au bouton clear
                const searchIcon = document.querySelector('.search-icon');
                if (searchIcon) {
                    searchIcon.style.right = '1rem';
                }
                
                // Afficher/masquer le bouton selon le contenu
                searchInput.addEventListener('input', function() {
                    if (this.value.trim()) {
                        clearButton.style.display = 'block';
                    } else {
                        clearButton.style.display = 'none';
                    }
                });
            }

            // Fonction utilitaire pour exporter les résultats visibles
            window.exportVisibleUsers = function() {
                const visibleRows = Array.from(userRows).filter(row => 
                    row.style.display !== 'none'
                );
                
                const data = visibleRows.map(row => {
                    const cells = row.querySelectorAll('td');
                    return {
                        id: cells[0]?.textContent.trim(),
                        nom: cells[1]?.textContent.trim(),
                        email: cells[2]?.textContent.trim(),
                        role: cells[3]?.textContent.trim(),
                        adminDepuis: cells[4]?.textContent.trim()
                    };
                });
                
                console.log('Utilisateurs visibles:', data);
                return data;
            };
            
            // Ajouter une animation d'entrée pour les lignes du tableau
            const rows = document.querySelectorAll('#usersTable tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });

        // Gestion des modales (code original)
        let selectedForm = null;

        function showConfirm(button) {
            selectedForm = button.closest('form');
            const name = selectedForm.querySelector('input[name="user_name"]').value;
            const role = selectedForm.querySelector('select[name="role"]').value;
            const roleText = role === 'admin' ? 'administrateur' : 'utilisateur';
            const text = `Êtes-vous sûr de vouloir rendre ${name} ${roleText} ?`;

            document.getElementById("confirmText").innerText = text;
            document.getElementById("confirmModal").classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function confirmChange() {
            if (selectedForm) {
                selectedForm.submit();
            }
            cancelChange();
        }

        function cancelChange() {
            document.getElementById("confirmModal").classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            selectedForm = null;
        }

        // Fermer la modal en cliquant sur l'arrière-plan
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                cancelChange();
            }
        });

        // Fermer la modal avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cancelChange();
            }
        });
    </script>
</body>
</html>