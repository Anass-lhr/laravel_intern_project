<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anciens Administrateurs - Business+ Talk</title>
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

        /* Boutons */
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

        /* Header section */
        .header-section {
            padding: 1rem 0;
        }

        /* Cartes et conteneurs */
        .card {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card-content {
            padding: 2rem;
        }

        /* Table moderne */
        .modern-table {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            background-color: var(--dark-element);
            border-bottom: 1px solid var(--dark-border);
        }

        .table-header th {
            padding: 1.25rem 1.5rem;
            text-left;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--light-text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-right: 1px solid var(--dark-border);
        }

        .table-header th:last-child {
            border-right: none;
        }

        .table-body tr {
            border-bottom: 1px solid var(--dark-border);
            transition: all 0.3s ease;
        }

        .table-body tr:hover {
            background-color: rgba(26, 158, 158, 0.05);
            transform: translateX(2px);
        }

        .table-body tr:last-child {
            border-bottom: none;
        }

        .table-body td {
            padding: 1.25rem 1.5rem;
            color: var(--light-text);
            font-size: 0.9rem;
            border-right: 1px solid var(--dark-border);
        }

        .table-body td:last-child {
            border-right: none;
        }

        /* Tags de modules */
        .module-tag {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 1rem;
            margin-right: 0.5rem;
            margin-bottom: 0.3rem;
            box-shadow: 0 2px 4px rgba(26, 158, 158, 0.2);
            transition: all 0.3s ease;
        }

        .module-tag:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(26, 158, 158, 0.3);
        }

        /* État vide */
        .empty-state {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .empty-state-icon {
            color: var(--gray-text);
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            color: var(--light-text);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            color: var(--gray-text);
            font-size: 0.95rem;
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

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-area {
                padding: 1rem;
            }
            
            .table-header th,
            .table-body td {
                padding: 1rem;
                font-size: 0.8rem;
            }
            
            .header-section h1 {
                font-size: 1.5rem !important;
            }
        }

        @media (max-width: 480px) {
            .header-section h1 {
                font-size: 1.25rem !important;
            }
            
            .modern-table {
                font-size: 0.75rem;
            }
        }

        .hidden {
            display: none !important;
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
                <!-- En-tête de la page -->
                <div class="header-section mb-6">
                    <!-- Titre centré -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold" style="color: var(--light-text);">
                            <i class="fas fa-history mr-3" style="color: var(--primary-color);"></i>
                            Historique des Administrateurs
                        </h1>
                    </div>
                        <div class="flex justify-start mb-4">
                        <a href="{{ route('affectations.index') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour à la liste
                        </a>
                    </div>
                </div>

                <!-- Contenu conditionnel -->
                <div id="adminContent" class="fade-in">
                    @if(isset($oldAdmins) && count($oldAdmins) > 0)
                        <div class="modern-table">
                            <table class="min-w-full">
                                <thead class="table-header">
                                    <tr>
                                        <th><i class="fas fa-user mr-2"></i>Nom</th>
                                        <th><i class="fas fa-envelope mr-2"></i>Email</th>
                                        <th><i class="fas fa-puzzle-piece mr-2"></i>Modules Affectés</th>
                                        <th><i class="fas fa-calendar-plus mr-2"></i>Début Admin</th>
                                        <th><i class="fas fa-calendar-times mr-2"></i>Fin Admin</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @foreach($oldAdmins as $admin)
                                        <tr class="old-admin-row">
                                            <td>{{ $admin->name ?? 'N/A' }}</td>
                                            <td>{{ $admin->email ?? 'N/A' }}</td>
                                            <td>
                                                @if(!empty($admin->modules))
                                                    @php
                                                        $modules = is_array($admin->modules) ? 
                                                            $admin->modules : 
                                                            json_decode($admin->modules, true);
                                                        $modules = $modules ?? [];
                                                    @endphp
                                                    @if(count($modules) > 0)
                                                        @foreach($modules as $module)
                                                            <span class="module-tag">{{ $module }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-gray-400 text-sm">Aucun module</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400 text-sm">Aucun module</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($admin->start_date))
                                                    {{ \Carbon\Carbon::parse($admin->start_date)->format('d/m/Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($admin->end_date))
                                                    {{ \Carbon\Carbon::parse($admin->end_date)->format('d/m/Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-info-circle text-6xl"></i>
                            </div>
                            <h3>Aucun ancien administrateur</h3>
                            <p>Il n'y a pas encore d'anciens administrateurs enregistrés dans le système.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Page Historique des Administrateurs chargée avec le style Business+ Talk');
    
    // Utiliser la barre de recherche du header au lieu de créer une nouvelle
    const searchInput = document.querySelector('.search-input');
    const adminRows = document.querySelectorAll('.old-admin-row');
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
        
        const tableContainer = document.querySelector('.modern-table');
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
            counter.textContent = `${totalAdmins} ancien(s) administrateur(s) au total`;
            counter.style.backgroundColor = 'var(--dark-element)';
        } else {
            counter.textContent = `${visibleCount} résultat(s) sur ${totalAdmins} ancien(s) administrateur(s)`;
            counter.style.backgroundColor = 'rgba(26, 158, 158, 0.1)';
        }
    }

    // Fonction principale de recherche
    function filterAdmins(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        let visibleCount = 0;
        
        adminRows.forEach(row => {
            if (!term) {
                // Afficher toutes les lignes si pas de terme de recherche
                row.style.display = '';
                visibleCount++;
                return;
            }
            
            // Récupérer le contenu de chaque colonne
            const cells = row.querySelectorAll('td');
            const name = cells[0]?.textContent.toLowerCase() || '';
            const email = cells[1]?.textContent.toLowerCase() || '';
            const startDate = cells[3]?.textContent.toLowerCase() || '';
            const endDate = cells[4]?.textContent.toLowerCase() || '';
            
            // Recherche dans les modules
            const moduleTags = cells[2]?.querySelectorAll('.module-tag') || [];
            let modules = '';
            moduleTags.forEach(tag => {
                modules += tag.textContent.toLowerCase() + ' ';
            });
            
            // Vérifier si le terme correspond
            const isMatch = name.includes(term) || 
                           email.includes(term) || 
                           modules.includes(term) ||
                           startDate.includes(term) ||
                           endDate.includes(term);
            
            if (isMatch) {
                row.style.display = '';
                row.classList.add('fade-in');
                visibleCount++;
            } else {
                row.style.display = 'none';
                row.classList.remove('fade-in');
            }
        });
        
        updateResultsCounter(visibleCount);
        
        // Afficher/masquer le message "aucun résultat"
        if (term && visibleCount === 0) {
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
            noResults.className = 'empty-state fade-in';
            noResults.innerHTML = `
                <div class="empty-state-icon">
                    <i class="fas fa-search text-6xl"></i>
                </div>
                <h3>Aucun résultat trouvé</h3>
                <p>Essayez de modifier vos critères de recherche ou utilisez d'autres mots-clés.</p>
            `;
            document.getElementById('adminContent').appendChild(noResults);
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
        // Personnaliser le placeholder pour la page des anciens admins
        searchInput.placeholder = "Rechercher des anciens administrateurs (nom, email, modules, dates...)";
        
        // Supprimer les anciens événements de recherche (pour les vidéos)
        if (searchInput._videoSearchHandler) {
            searchInput.removeEventListener('input', searchInput._videoSearchHandler);
        }
        
        // Événement de recherche en temps réel pour les admins
        const adminSearchHandler = function() {
            filterAdmins(this.value);
        };
        
        searchInput.addEventListener('input', adminSearchHandler);
        searchInput._adminSearchHandler = adminSearchHandler;
        
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
        
        console.log(`🔍 Recherche initialisée pour ${totalAdmins} ancien(s) administrateur(s)`);
    }

    // Animation des tags de modules au survol
    const moduleTags = document.querySelectorAll('.module-tag');
    moduleTags.forEach(tag => {
        tag.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
            this.style.boxShadow = '0 6px 12px rgba(26, 158, 158, 0.4)';
        });
        
        tag.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '0 2px 4px rgba(26, 158, 158, 0.2)';
        });
    });

    // Fonction de nettoyage de la recherche
    function clearSearch() {
        if (searchInput) {
            searchInput.value = '';
            filterAdmins('');
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

    // Fonction utilitaire pour exporter les résultats (bonus)
    window.exportVisibleAdmins = function() {
        const visibleRows = Array.from(adminRows).filter(row => 
            row.style.display !== 'none'
        );
        
        const data = visibleRows.map(row => {
            const cells = row.querySelectorAll('td');
            return {
                nom: cells[0]?.textContent.trim(),
                email: cells[1]?.textContent.trim(),
                modules: Array.from(cells[2]?.querySelectorAll('.module-tag') || [])
                    .map(tag => tag.textContent.trim()),
                dateDebut: cells[3]?.textContent.trim(),
                dateFin: cells[4]?.textContent.trim()
            };
        });
        
        console.log('Données visibles:', data);
        return data;
    };
});
    </script>
</body>
</html>