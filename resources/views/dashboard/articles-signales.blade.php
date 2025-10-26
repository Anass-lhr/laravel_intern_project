<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles Signalés - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1a9e9e',
                            hover: '#25c4c4',
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
                $primaryColor = $settings->primary_color ?? '#1a9e9e';
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
        }

        /* En-tête */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--dark-border);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--light-text);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header h1 i {
            background: linear-gradient(135deg, var(--primary-color), #25c4c4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .back-btn {
            background: linear-gradient(135deg, var(--gray-bg), var(--dark-element));
            color: var(--light-text);
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--dark-border);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, var(--dark-element), var(--gray-bg));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }

        .refresh-btn {
            background: linear-gradient(135deg, var(--primary-color), #25c4c4);
            color: #000;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--primary-color);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .refresh-btn:hover {
            background: linear-gradient(135deg, #25c4c4, var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(26, 158, 158, 0.4);
        }

        /* Statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            border-radius: 16px;
            padding: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            color: #000;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .stat-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 16px 60px rgba(0, 0, 0, 0.4);
        }

        .stat-card.pending { background: linear-gradient(135deg, #f59e0b, #f97316); }
        .stat-card.resolved { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-card.dismissed { background: linear-gradient(135deg, #6b7280, #4b5563); color: #fff; }
        .stat-card.total { background: linear-gradient(135deg, var(--primary-color), #25c4c4); }

        //* Section de filtrage */
.filter-section {
    background: var(--dark-card);
    border: 1px solid var(--dark-border);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 32px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}

.filter-btn {
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    background: rgba(255, 255, 255, 0.05);
    color: var(--gray-text);
    cursor: pointer;
}

.filter-btn i {
    color: white; /* Keep icons white in all states */
}

.filter-btn.active {
    background: var(--primary-color);
    color: #000;
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(26, 158, 158, 0.4);
}

.filter-btn.active i {
    color: white; /* Keep icons white even in active state */
}

.filter-btn:hover:not(.active) {
    background: rgba(255, 255, 255, 0.1);
    color: var(--light-text);
    transform: translateY(-2px);
}

.filter-btn:hover:not(.active) i {
    color: white; /* Keep icons white on hover */
}

.filter-inputs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
}

/* Status select dropdown styling */
.status-select {
    background-color: #4a5568; /* Gray background */
    color: white;
    border: 1px solid #718096;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 500;
    min-width: 120px;
    cursor: pointer;
    transition: all 0.2s ease;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 8px center;
    background-size: 16px;
    padding-right: 32px;
}

.status-select:hover {
    background-color: #2d3748; /* Darker gray on hover */
    border-color: #4a5568;
}

.status-select:focus {
    outline: none;
    border-color: #63b3ed;
    box-shadow: 0 0 0 3px rgba(99, 179, 237, 0.1);
    background-color: #2d3748;
}

/* Style the dropdown options */
.status-select option {
    background-color: #4a5568; /* Gray background for options */
    color: white;
    padding: 8px 12px;
    border: none;
}

.status-select option:hover {
    background-color: #2d3748; /* Darker gray on hover */
}

.status-select option:checked {
    background-color: #63b3ed; /* Blue for selected option */
    color: white;
}

/* Alternative styling for better browser compatibility */
.status-select option[value="pending"] {
    background-color: #4a5568;
    color: #fbbf24; /* Yellow text for pending */
}

.status-select option[value="resolved"] {
    background-color: #4a5568;
    color: #10b981; /* Green text for resolved */
}

.status-select option[value="dismissed"] {
    background-color: #4a5568;
    color: #ef4444; /* Red text for dismissed */
}

        .search-wrapper {
            position: relative;
            background-color: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .search-wrapper:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 20px rgba(26, 158, 158, 0.3);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-text);
            z-index: 2;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 48px;
            background: transparent;
            border: none;
            outline: none;
            color: var(--light-text);
            font-size: 14px;
        }

        .search-input::placeholder {
            color: var(--gray-text);
        }

        .custom-select {
            background: rgba(0, 0, 0, 0.08); 
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: var(--light-text); 
            width: 100%;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .custom-select:hover,
        .custom-select:focus {
            border-color: var(--primary-color);
            background: rgba(0, 0, 0, 0.12);
        }

        /* Actions en lot */
        .bulk-actions {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .bulk-actions.show {
            display: flex;
        }

        .select-count {
            background: var(--primary-color);
            color: #000;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Table principale */
        .table-container {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: linear-gradient(135deg, var(--dark-element), var(--gray-bg));
        }

        .table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-text);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--dark-border);
        }

        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--dark-border);
            color: var(--light-text);
            font-size: 0.875rem;
            vertical-align: top;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(26, 158, 158, 0.05);
        }

        /* Badges modernes */
        .status-badge {
            padding: 6px 14px;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-pending {
            background: rgba(251, 191, 36, 0.2);
            color: #f59e0b;
            border: 1px solid rgba(251, 191, 36, 0.4);
        }

        .status-resolved {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .status-dismissed {
            background: rgba(107, 114, 128, 0.2);
            color: #6b7280;
            border: 1px solid rgba(107, 114, 128, 0.4);
        }

        .priority-high {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }
        .priority-medium {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }
        .priority-low {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        .comment-type {
            background: rgba(139, 92, 246, 0.15);
            color: var(--primary-color);
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .reply-type {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Boutons d'action */
        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 0.125rem;
            text-decoration: none;
        }

        .btn-view {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .btn-approve {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-reject {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-delete {
            background: rgba(185, 28, 28, 0.15);
            color: #f87171;
            border: 1px solid rgba(185, 28, 28, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Liens */
        .table-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .table-link:hover {
            color: #25c4c4;
            text-decoration: underline;
        }

        .text-truncate {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-muted {
            color: var(--gray-text);
        }

        /* État vide */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-text);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* SweetAlert2 thème sombre */
        .swal2-popup {
            background-color: var(--dark-card) !important;
            color: var(--light-text) !important;
            border: 1px solid var(--dark-border) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .header h1 {
                font-size: 2rem;
                justify-content: center;
            }
            
            .header-actions {
                justify-content: center;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .filter-section {
                padding: 16px;
            }
            
            .filter-inputs {
                grid-template-columns: 1fr;
            }
            
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table {
                min-width: 1200px;
            }
            
            .table th, .table td {
                padding: 0.75rem;
                font-size: 0.8125rem;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .header-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .back-btn, .refresh-btn {
                justify-content: center;
            }
            
            .filter-buttons {
                justify-content: center;
            }
        
            .filter-btn {
                padding: 8px 16px;
                font-size: 0.8125rem;
            }
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="header">
            <h1>
                <i class="fas fa-flag"></i>
                Tous les Signalements
            </h1>
            <div class="header-actions">
                <button onclick="refreshData()" class="refresh-btn" title="Actualiser">
                    <i class="fas fa-sync-alt" id="refresh-icon"></i>
                    Actualiser
                </button>
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Retour au Dashboard
                </a>
            </div>
        </div>

        <!-- Statistiques Unifiées -->
        <div class="section-header">
            <h2><i class="fas fa-chart-bar mr-2"></i>Statistiques Générales</h2>
        </div>
        <div class="stats-grid">
            <div class="stat-card pending" onclick="filterByGeneralStatus('pending')">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-1">En attente</h3>
                        <p class="text-3xl font-bold">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="text-4xl opacity-70">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card resolved" onclick="filterByGeneralStatus('resolved')">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Résolus</h3>
                        <p class="text-3xl font-bold">{{ $stats['resolved'] ?? 0 }}</p>
                    </div>
                    <div class="text-4xl opacity-70">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card dismissed" onclick="filterByGeneralStatus('dismissed')">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Rejetés</h3>
                        <p class="text-3xl font-bold">{{ $stats['dismissed'] ?? 0 }}</p>
                    </div>
                    <div class="text-4xl opacity-70">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card total">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Total</h3>
                        <p class="text-3xl font-bold">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="text-4xl opacity-70">
                        <i class="fas fa-flag"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section de filtrage unifiée -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn" 
                        onclick="filterByStatus('all')" 
                        data-filter="all">
                    <i class="fas fa-list mr-2"></i>Tous
                </button>
                <button class="filter-btn" 
                        onclick="filterByStatus('pending')" 
                        data-filter="pending">
                    <i class="fas fa-clock mr-2"></i>En attente
                </button>
                <button class="filter-btn" 
                        onclick="filterByStatus('resolved')" 
                        data-filter="resolved">
                    <i class="fas fa-check mr-2"></i>Résolus
                </button>
                <button class="filter-btn" 
                        onclick="filterByStatus('dismissed')" 
                        data-filter="dismissed">
                    <i class="fas fa-times mr-2"></i>Rejetés
                </button>
            </div>

            <div class="filter-inputs">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           id="searchInput" 
                           class="search-input" 
                           placeholder="Rechercher dans tous les signalements..."
                           value="{{ request('search') }}">
                </div>

                <!-- Filtre par type de signalement -->
                <select id="typeFilter" class="custom-select" onchange="filterByType(this.value)">
                    <option value="all">Tous les types</option>
                    <option value="article">Articles seulement</option>
                    <option value="comment">Commentaires seulement</option>
                </select>
            </div>
        </div>

        <!-- Actions en lot unifiées -->
        <div class="bulk-actions" id="bulk-actions">
            <span class="select-count" id="selected-count">0 sélectionné(s)</span>
            <button class="action-btn btn-approve" onclick="bulkProcessReports('resolve')">
                <i class="fas fa-check"></i> Résoudre
            </button>
            <button class="action-btn btn-reject" onclick="bulkProcessReports('dismiss')">
                <i class="fas fa-times"></i> Rejeter
            </button>
            <button class="action-btn btn-delete" onclick="bulkProcessReports('delete')">
                <i class="fas fa-trash"></i> Supprimer
            </button>
            <button class="action-btn btn-view" onclick="clearSelection()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>

        <!-- Check if we have any reports to display -->
        @php
            $hasArticleReports = isset($articleReports) && $articleReports && $articleReports->count() > 0;
            $hasCommentReports = isset($commentReports) && $commentReports && $commentReports->count() > 0;
            $hasAnyReports = $hasArticleReports || $hasCommentReports;
        @endphp

        <!-- Table unifiée des signalements -->
        <div class="table-container">
            @if($hasAnyReports)
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="rounded" onchange="toggleSelectAll()">
                            </th>
                            <th><i class="fas fa-tag mr-2"></i>Type</th>
                            <th><i class="fas fa-user mr-2"></i>Signaleur</th>
                            <th><i class="fas fa-newspaper mr-2"></i>Article</th>
                            <th><i class="fas fa-info-circle mr-2"></i>Détails du signalement</th>
                            <th><i class="fas fa-traffic-light mr-2"></i>Priorité</th>
                            <th><i class="fas fa-check-circle mr-2"></i>Statut</th>
                            <th><i class="fas fa-calendar mr-2"></i>Date</th>
                        </tr>
                    </thead>
                    <tbody id="reportTable">
                        <!-- Article Reports -->
                        @if($hasArticleReports)
                            @foreach($articleReports as $report)
                            <tr data-report-id="{{ $report->id }}" data-report-type="article" class="report-row">
                                <td>
                                    <input type="checkbox" 
                                           class="report-checkbox rounded" 
                                           value="{{ $report->id }}"
                                           data-type="article"
                                           onchange="updateBulkActions()">
                                </td>
                                <td>
                                    <span class="status-badge type-article">
                                        <i class="fas fa-newspaper mr-1"></i>
                                        Article
                                    </span>
                                </td>
                                <td>{{ $report->reported_by ?? 'Anonyme' }}</td>
                                <td>
                                    @if($report->article)
                                        <a href="{{ route('articles.show', $report->article->id) }}" 
                                           class="table-link text-truncate" 
                                           target="_blank"
                                           title="{{ $report->article->titre }}">
                                            {{ Str::limit($report->article->titre, 40) }}
                                        </a>
                                    @else
                                        <span class="text-muted">Article supprimé</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-truncate" title="{{ $report->reason_details }}">
                                        {{ Str::limit($report->reason_details, 60) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge priority-{{ $report->priority ?? 'medium' }}">
                                        <i class="fas fa-flag mr-1"></i>
                                        {{ ucfirst($report->priority ?? 'medium') }}
                                    </span>
                                </td>
                                <td>
                                    <select class="custom-select status-select" 
                                            data-report-id="{{ $report->id }}" 
                                            data-report-type="article"
                                            data-original-status="{{ $report->status }}"
                                            onchange="updateStatus(this)">
                                        <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>
                                            En attente
                                        </option>
                                        <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>
                                            Résolu
                                        </option>
                                        <option value="dismissed" {{ $report->status == 'dismissed' ? 'selected' : '' }}>
                                            Rejeté
                                        </option>
                                    </select>
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        @endif

                        <!-- Comment Reports -->
                        @if($hasCommentReports)
                            @foreach($commentReports as $report)
                            <tr data-report-id="{{ $report->id }}" data-report-type="comment" class="report-row">
                                <td>
                                    <input type="checkbox" 
                                           class="report-checkbox rounded" 
                                           value="{{ $report->id }}"
                                           data-type="comment"
                                           onchange="updateBulkActions()">
                                </td>
                                <td>
                                    <span class="status-badge type-comment">
                                        <i class="fas fa-comment mr-1"></i>
                                        Commentaire
                                    </span>
                                </td>
                                <td>{{ $report->reported_by ?? 'Anonyme' }}</td>
                                <td>
                                    @if($report->article)
                                        <a href="{{ route('articles.show', $report->article->id) }}" 
                                           class="table-link text-truncate" 
                                           target="_blank"
                                           title="{{ $report->article->titre }}">
                                            {{ Str::limit($report->article->titre, 40) }}
                                        </a>
                                    @else
                                        <span class="text-muted">Article supprimé</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="comment-details">
                                        <div class="comment-author">
                                            <i class="fas fa-user-edit mr-1"></i>
                                            <strong>{{ $report->comment_author }}</strong>
                                        </div>
                                        <div class="comment-content text-truncate" title="{{ $report->comment_content }}">
                                            {{ Str::limit($report->comment_content, 40) }}
                                        </div>
                                        @if($report->reason_details)
                                            <div class="report-reason text-truncate text-muted" title="{{ $report->reason_details }}">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                {{ Str::limit($report->reason_details, 30) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge priority-medium">
                                        <i class="fas fa-flag mr-1"></i>
                                        Medium
                                    </span>
                                </td>
                                <td>
                                    <select class="custom-select status-select" 
                                            data-report-id="{{ $report->id }}" 
                                            data-report-type="comment"
                                            data-original-status="{{ $report->status }}"
                                            onchange="updateStatus(this)">
                                        <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>
                                            En attente
                                        </option>
                                        <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>
                                            Résolu
                                        </option>
                                        <option value="dismissed" {{ $report->status == 'dismissed' ? 'selected' : '' }}>
                                            Rejeté
                                        </option>
                                    </select>
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3 class="text-2xl font-semibold text-gray-400 mb-2">Aucun signalement trouvé</h3>
                    <p class="text-gray-500">Il n'y a aucun signalement correspondant à vos critères de recherche.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($hasAnyReports)
            <div class="flex items-center justify-between mt-8">
                <div class="text-gray-400">
                    Affichage des signalements
                </div>
                <div class="flex items-center space-x-4">
                    @if($hasArticleReports && $articleReports->hasPages())
                        <div class="pagination-wrapper">
                            <span class="text-sm text-gray-500">Articles:</span>
                            {{ $articleReports->appends(request()->query())->links() }}
                        </div>
                    @endif
                    @if($hasCommentReports && $commentReports->hasPages())
                        <div class="pagination-wrapper">
                            <span class="text-sm text-gray-500">Commentaires:</span>
                            {{ $commentReports->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <script>
        // Configuration
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        const ROUTES = {
            commentReports: '{{ route("dashboard.articles-signales") }}',
            articleReports: '{{ route("dashboard.articles-reports") }}',
            allReports: '{{ route("dashboard.all-article-reports") }}',
            updateCommentReport: '{{ route("dashboard.articles-signales.update", ":id") }}',
            updateArticleReport: '{{ route("dashboard.articles-reports.update", ":id") }}',
            bulkProcessComments: '{{ route("dashboard.articles-signales.bulk-process") }}',
            bulkProcessArticles: '{{ route("dashboard.articles-reports.bulk-process") }}'
        };

        // Variables globales
        let selectedReports = [];
        let currentFilters = {
            status: new URLSearchParams(window.location.search).get('status') || 'all',
            type: new URLSearchParams(window.location.search).get('type') || 'all',
            search: new URLSearchParams(window.location.search).get('search') || '',
            sort: 'created_at_desc',
            page: parseInt(new URLSearchParams(window.location.search).get('page')) || 1
        };

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
            updateActiveFilters();
            updateTypeFilter();
            loadStatistics();
        });

        // Configuration des événements
        function setupEventListeners() {
            // Recherche avec debounce
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        currentFilters.search = this.value;
                        currentFilters.page = 1;
                        applyFilters();
                    }, 500);
                });
            }
        }

        // Fonction pour charger les statistiques générales
        async function loadStatistics() {
            try {
                const response = await fetch(`${ROUTES.allReports}?ajax=stats`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        updateStatisticsDisplay(data.stats);
                    }
                }
            } catch (error) {
                console.error('Erreur lors du chargement des statistiques:', error);
            }
        }

        // Mettre à jour l'affichage des statistiques
        function updateStatisticsDisplay(stats) {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                const statusClass = card.classList[1]; // pending, resolved, dismissed, total
                if (stats[statusClass] !== undefined) {
                    const countElement = card.querySelector('.text-3xl');
                    if (countElement) {
                        countElement.textContent = stats[statusClass];
                    }
                }
            });
        }

        // Fonction pour actualiser les données
        async function refreshData() {
            const refreshIcon = document.getElementById('refresh-icon');
            refreshIcon.classList.add('fa-spin');
            
            try {
                await loadStatistics();
                location.reload();
            } catch (error) {
                console.error('Erreur lors de l\'actualisation:', error);
                alert('Erreur lors de l\'actualisation des données');
            } finally {
                refreshIcon.classList.remove('fa-spin');
            }
        }

        // Fonctions de filtrage
        function updateActiveFilters() {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.filter === currentFilters.status) {
                    btn.classList.add('active');
                }
            });
        }

        function updateTypeFilter() {
            const typeFilter = document.getElementById('typeFilter');
            if (typeFilter) {
                typeFilter.value = currentFilters.type;
            }
        }

        function applyFilters() {
            const params = new URLSearchParams();
            
            // Ajouter tous les filtres non vides et non 'all'
            if (currentFilters.status && currentFilters.status !== 'all') {
                params.append('status', currentFilters.status);
            }
            if (currentFilters.type && currentFilters.type !== 'all') {
                params.append('type', currentFilters.type);
            }
            if (currentFilters.search && currentFilters.search.trim() !== '') {
                params.append('search', currentFilters.search);
            }
            if (currentFilters.page && currentFilters.page > 1) {
                params.append('page', currentFilters.page);
            }
            
            const queryString = params.toString();
            const newUrl = queryString ? `${ROUTES.allReports}?${queryString}` : ROUTES.allReports;
            window.location.href = newUrl;
        }

        function filterByStatus(status) {
            currentFilters.status = status;
            currentFilters.page = 1;
            applyFilters();
        }

        function filterByType(type) {
            currentFilters.type = type;
            currentFilters.page = 1;
            applyFilters();
        }

        function filterByGeneralStatus(status) {
            filterByStatus(status);
        }

        // Fonctions de sélection
        function toggleSelectAll() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.report-checkbox');
            
            selectedReports = [];
            
            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
                if (selectAll.checked) {
                    const reportId = cb.value;
                    const reportType = cb.dataset.type;
                    const reportKey = `${reportType}-${reportId}`;
                    selectedReports.push(reportKey);
                }
            });
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.report-checkbox:checked');
            selectedReports = [];
            
            checkboxes.forEach(cb => {
                const reportId = cb.value;
                const reportType = cb.dataset.type;
                selectedReports.push(`${reportType}-${reportId}`);
            });
            
            const bulkActions = document.getElementById('bulk-actions');
            const selectedCount = document.getElementById('selected-count');
            
            if (selectedReports.length > 0) {
                bulkActions.classList.add('show');
                selectedCount.textContent = `${selectedReports.length} sélectionné(s)`;
            } else {
                bulkActions.classList.remove('show');
            }

            // Update select all checkbox state
            const selectAll = document.getElementById('select-all');
            const allCheckboxes = document.querySelectorAll('.report-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.report-checkbox:checked');
            
            if (checkedCheckboxes.length === 0) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
            } else if (checkedCheckboxes.length === allCheckboxes.length) {
                selectAll.checked = true;
                selectAll.indeterminate = false;
            } else {
                selectAll.checked = false;
                selectAll.indeterminate = true;
            }
        }

        function clearSelection() {
            selectedReports = [];
            document.querySelectorAll('.report-checkbox').forEach(cb => cb.checked = false);
            const selectAll = document.getElementById('select-all');
            if (selectAll) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
            }
            updateBulkActions();
        }

        // Fonctions de traitement par lots
        async function bulkProcessReports(action) {
            if (selectedReports.length === 0) {
                alert('Veuillez sélectionner au moins un signalement');
                return;
            }

            if (!confirm(`Êtes-vous sûr de vouloir ${getActionLabel(action)} pour ${selectedReports.length} signalement(s) ?`)) {
                return;
            }

            // Séparer les signalements par type
            const commentReports = selectedReports
                .filter(id => id.startsWith('comment-'))
                .map(id => id.replace('comment-', ''));
            
            const articleReports = selectedReports
                .filter(id => id.startsWith('article-'))
                .map(id => id.replace('article-', ''));

            try {
                let promises = [];

                // Traiter les commentaires
                if (commentReports.length > 0) {
                    promises.push(
                        fetch(ROUTES.bulkProcessComments, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify({ 
                                report_ids: commentReports,
                                action: action === 'resolve' ? 'approve' : action
                            })
                        })
                    );
                }

                // Traiter les articles
                if (articleReports.length > 0) {
                    promises.push(
                        fetch(ROUTES.bulkProcessArticles, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify({ 
                                report_ids: articleReports,
                                action: action === 'resolve' ? 'approve' : action
                            })
                        })
                    );
                }

                const responses = await Promise.all(promises);
                let allSuccess = true;
                let errorMessages = [];

                for (const response of responses) {
                    const result = await response.json();
                    if (!result.success) {
                        allSuccess = false;
                        errorMessages.push(result.message || 'Erreur inconnue');
                    }
                }

                if (allSuccess) {
                    alert('Traitement par lots effectué avec succès');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert('Erreurs lors du traitement:\n' + errorMessages.join('\n'));
                }

            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors du traitement par lots');
            }
        }

        // Fonctions de mise à jour du statut
        async function updateStatus(selectElement) {
            const reportId = selectElement.getAttribute('data-report-id');
            const reportType = selectElement.getAttribute('data-report-type');
            const newStatus = selectElement.value;
            const originalStatus = selectElement.getAttribute('data-original-status') || 'pending';

            if (!confirm(`Êtes-vous sûr de vouloir changer le statut en ${getStatusLabel(newStatus)} ?`)) {
                selectElement.value = originalStatus;
                return;
            }

            try {
                let url;
                if (reportType === 'comment') {
                    url = ROUTES.updateCommentReport.replace(':id', reportId);
                } else {
                    url = ROUTES.updateArticleReport.replace(':id', reportId);
                }

                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const result = await response.json();

                if (result.success) {
                    selectElement.setAttribute('data-original-status', newStatus);
                    alert('Statut mis à jour avec succès');
                    await loadStatistics();
                } else {
                    selectElement.value = originalStatus;
                    alert(result.message || 'Erreur lors de la mise à jour');
                }

            } catch (error) {
                console.error('Erreur:', error);
                selectElement.value = originalStatus;
                alert('Erreur lors de la mise à jour du statut');
            }
        }

        // Fonctions utilitaires
        function getActionLabel(action) {
            const labels = {
                'resolve': 'résoudre',
                'dismiss': 'rejeter',
                'delete': 'supprimer'
            };
            return labels[action] || action;
        }

        function getStatusLabel(status) {
            const labels = {
                'pending': 'En attente',
                'resolved': 'Résolu',
                'dismissed': 'Rejeté'
            };
            return labels[status] || status;
        }

        // Gestion des événements de raccourcis clavier
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                refreshData();
            }
            
            if (e.key === 'Escape') {
                clearSelection();
            }
        });
    </script>
</body>
</html>