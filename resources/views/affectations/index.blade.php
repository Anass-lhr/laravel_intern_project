<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Affectations - Business+ Talk</title>
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

        .btn-warning {
            background-color: var(--primary-color);
            color: var(--light-text);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(180, 83, 9, 0.3);
        }

        .btn-success {
            background-color: var(--success);
            color: var(--light-text);
        }

        .btn-success:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-small {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Styles pour la nouvelle disposition header */
        .header-section {
            padding: 1rem 0;
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

        /* Styles pour les modules */
        .module-tag {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--light-text);
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
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

        /* Ajustements responsifs pour la nouvelle disposition */
        @media (max-width: 768px) {
            .header-section {
                padding: 0.5rem 0;
            }
            
            .header-section h1 {
                font-size: 1.5rem !important;
                margin-bottom: 1rem;
            }
            
            .header-section .btn {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            .user-card {
                margin-bottom: 1rem;
            }
            .table-container {
                overflow-x: auto;
            }
        }

        @media (max-width: 480px) {
            .header-section h1 {
                font-size: 1.25rem !important;
            }
            
            .header-section h1 i {
                font-size: 1.25rem;
                margin-right: 0.5rem;
            }
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
            <!-- Inclusion de l'en-tête -->

            <!-- Zone de contenu -->
            <div class="content-area">
                <!-- Actions en haut -->
                <div class="header-section mb-6">
                    <!-- Boutons d'action en haut -->
                    <div class="flex justify-between items-center mb-4">
                        <form action="{{ route('dashboard') }}" method="get">
                            <button class="btn btn-outline" type="submit">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour
                            </button>
                        </form>
                        
                        <!-- Bouton pour accéder aux anciens admins -->
                        <a href="{{ route('affectations.ancien_admins') }}" 
                           class="btn btn-primary">
                            <i class="fas fa-history mr-2"></i>
                            Anciens Admins
                        </a>
                    </div>

                    <!-- Titre centré -->
                    <div class="text-center mb-4">
                        <h1 class="text-3xl font-bold" style="color: var(--light-text);">
                            <i class="fas fa-user-cog mr-3" style="color: var(--primary-color);"></i>
                            Liste des Affectations
                        </h1>
                        <p class="text-gray-400 mt-2">
                            Utilisez la barre de recherche ci-dessus pour filtrer les affectations
                        </p>
                    </div>
                </div>

                <!-- Table responsive -->
                <div class="table-container">
                    <table id="affectationsTable" class="table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-toggle-on mr-2"></i>Statut</th>
                                <th><i class="fas fa-user mr-2"></i>Nom</th>
                                <th><i class="fas fa-envelope mr-2"></i>Email</th>
                                <th><i class="fas fa-puzzle-piece mr-2"></i>Modules Affectés</th>
                                <th><i class="fas fa-cogs mr-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                                <tr data-user-id="{{ $admin->id }}" class="admin-row hover:bg-opacity-5 hover:bg-white transition-colors duration-200">
                                    <td>
                                        <span class="status-badge {{ $admin->is_active ? 'status-active' : 'status-inactive' }}">
                                            <i class="fas fa-{{ $admin->is_active ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                            {{ $admin->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3" style="background-color: var(--primary-color);">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                            <span style="color: var(--light-text);" class="font-medium">{{ $admin->name }}</span>
                                        </div>
                                    </td>
                                    <td style="color: var(--gray-text);">{{ $admin->email }}</td>
                                    <td>
                                        @if($admin->affectation && !empty($admin->affectation->modules))
                                            @php
                                                $modules = is_array($admin->affectation->modules) ? 
                                                $admin->affectation->modules : 
                                                json_decode($admin->affectation->modules, true);
                                            @endphp
                                            @foreach($modules as $mod)
                                                <span class="module-tag">{{ $mod }}</span>
                                            @endforeach
                                        @else
                                            <span style="color: var(--gray-text);" class="text-sm italic">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Aucun module
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('affectations.edit', $admin->id) }}" 
                                               class="btn btn-warning btn-small">
                                                <i class="fas fa-edit mr-1"></i>
                                                Modifier
                                            </a>
                                            <form method="POST" action="{{ route('users.toggleActive', $admin->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn {{ $admin->is_active ? 'btn-danger' : 'btn-success' }} btn-small">
                                                    <i class="fas fa-{{ $admin->is_active ? 'ban' : 'check' }} mr-1"></i>
                                                    {{ $admin->is_active ? 'Bloquer' : 'Activer' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Animation d'entrée pour les éléments
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Page des affectations chargée avec le style Business+ Talk');
            
            // Utiliser la barre de recherche du header
            const searchInput = document.querySelector('.search-input');
            const adminRows = document.querySelectorAll('.admin-row');
            const totalAdmins = adminRows.length;

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
                
                updateResultsCounter(totalAdmins);
                return counter;
            }

            // Mettre à jour le compteur de résultats
            function updateResultsCounter(visibleCount) {
                let counter = document.getElementById('results-counter');
                if (!counter) {
                    counter = createResultsCounter();
                }
                
                if (visibleCount === totalAdmins) {
                    counter.textContent = `${totalAdmins} affectation(s) au total`;
                    counter.style.backgroundColor = 'var(--dark-element)';
                } else {
                    counter.textContent = `${visibleCount} résultat(s) sur ${totalAdmins} affectation(s)`;
                    counter.style.backgroundColor = 'rgba(26, 158, 158, 0.1)';
                }
            }

            // Fonction principale de filtrage
            function filterAffectations(searchTerm) {
                const filter = searchTerm.toLowerCase().trim();
                let visibleCount = 0;

                adminRows.forEach(row => {
                    if (!filter) {
                        row.style.display = '';
                        visibleCount++;
                        return;
                    }

                    const statusCell = row.getElementsByTagName("td")[0];
                    const nameCell = row.getElementsByTagName("td")[1];
                    const emailCell = row.getElementsByTagName("td")[2];
                    const modulesCell = row.getElementsByTagName("td")[3];

                    if (statusCell && nameCell && emailCell && modulesCell) {
                        const statusText = statusCell.textContent.toLowerCase();
                        const nameText = nameCell.textContent.toLowerCase();
                        const emailText = emailCell.textContent.toLowerCase();
                        const modulesText = modulesCell.textContent.toLowerCase();

                        const isMatch = statusText.includes(filter) ||
                                       nameText.includes(filter) ||
                                       emailText.includes(filter) ||
                                       modulesText.includes(filter);

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
                            Aucun résultat trouvé
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
            if (searchInput && adminRows.length > 0) {
                // Personnaliser le placeholder pour la page des affectations
                searchInput.placeholder = "Rechercher des affectations (nom, email, statut, modules...)";
                
                // Supprimer les anciens événements de recherche
                if (searchInput._adminSearchHandler) {
                    searchInput.removeEventListener('input', searchInput._adminSearchHandler);
                }
                if (searchInput._videoSearchHandler) {
                    searchInput.removeEventListener('input', searchInput._videoSearchHandler);
                }
                
                // Événement de recherche en temps réel pour les affectations
                const affectationSearchHandler = function() {
                    filterAffectations(this.value);
                };
                
                searchInput.addEventListener('input', affectationSearchHandler);
                searchInput._affectationSearchHandler = affectationSearchHandler;
                
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
                
                console.log(`🔍 Recherche initialisée pour ${totalAdmins} affectation(s)`);
            }

            // Fonction de nettoyage de la recherche
            function clearSearch() {
                if (searchInput) {
                    searchInput.value = '';
                    filterAffectations('');
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
            
            // Ajouter une animation d'entrée pour les lignes du tableau
            const rows = document.querySelectorAll('#affectationsTable tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });

            // Fonction utilitaire pour exporter les résultats visibles
            window.exportVisibleAffectations = function() {
                const visibleRows = Array.from(adminRows).filter(row => 
                    row.style.display !== 'none'
                );
                
                const data = visibleRows.map(row => {
                    const cells = row.querySelectorAll('td');
                    return {
                        statut: cells[0]?.textContent.trim(),
                        nom: cells[1]?.textContent.trim(),
                        email: cells[2]?.textContent.trim(),
                        modules: Array.from(cells[3]?.querySelectorAll('.module-tag') || [])
                            .map(tag => tag.textContent.trim())
                    };
                });
                
                console.log('Affectations visibles:', data);
                return data;
            };
        });
    </script>
</body>
</html>