<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Signalements - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            --primary-color: #1EB5AD;
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
            color: var(--primary-color);
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

        /* Barre de recherche */
        .search-container {
            margin-bottom: 2rem;
        }

        .search-wrapper {
            position: relative;
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .search-wrapper:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 158, 158, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-text);
            z-index: 2;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: transparent;
            border: none;
            outline: none;
            color: var(--light-text);
            font-size: 1rem;
        }

        .search-input::placeholder {
            color: var(--gray-text);
        }

        /* Messages d'alerte */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            font-weight: 500;
            animation: fadeInUp 0.5s ease-out;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-left-color: var(--success);
        }

        .alert-error {
            background-color: rgba(185, 28, 28, 0.1);
            color: var(--danger);
            border-left-color: var(--danger);
        }

        .hidden {
            display: none;
        }

        /* Table principale */
        .table-container {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 2rem;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        .table thead {
            background-color: var(--dark-element);
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
            white-space: nowrap;
        }

        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--dark-border);
            color: var(--light-text);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(26, 158, 158, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges de statut */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            white-space: nowrap;
        }

        .status-pending {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
        }

        .status-reviewed {
            background-color: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .status-dismissed {
            background-color: rgba(185, 28, 28, 0.15);
            color: #f87171;
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
            text-decoration: none;
            margin: 0.125rem;
            white-space: nowrap;
        }

        .btn-block {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .btn-block:hover {
            background-color: rgba(245, 158, 11, 0.25);
        }

        .btn-unblock {
            background-color: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-unblock:hover {
            background-color: rgba(16, 185, 129, 0.25);
        }

        .btn-delete {
            background-color: rgba(185, 28, 28, 0.15);
            color: #f87171;
            border: 1px solid rgba(185, 28, 28, 0.3);
        }

        .btn-delete:hover {
            background-color: rgba(185, 28, 28, 0.25);
        }

        .btn-disabled {
            background-color: rgba(107, 114, 128, 0.15);
            color: var(--gray-text);
            border: 1px solid rgba(107, 114, 128, 0.3);
            cursor: not-allowed;
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

        /* Select personnalisé */
        .custom-select {
            background-color: var(--dark-element);
            color: var(--light-text);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 0.5rem;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 120px;
        }

        .custom-select:hover {
            border-color: var(--primary-color);
        }

        .custom-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(26, 158, 158, 0.1);
        }

        /* Texte tronqué */
        .text-truncate {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-muted {
            color: var(--gray-text);
        }

        /* Animations */
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

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Loading state */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Responsive Design - Amélioré */
        @media (max-width: 1199px) {
            .table {
                min-width: 1000px;
            }
            
            .text-truncate {
                max-width: 150px;
            }
        }

        @media (max-width: 991px) {
            .container {
                padding: 1.5rem;
            }
            
            .header {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            
            .header h1 {
                font-size: 2rem;
                justify-content: center;
            }
            
            .back-btn {
                align-self: center;
            }
            
            .table {
                min-width: 900px;
            }
        }

        @media (max-width: 767px) {
            .container {
                padding: 1rem;
            }
            
            .header h1 {
                font-size: 1.75rem;
            }
            
            .table {
                min-width: 800px;
            }
            
            .table th, .table td {
                padding: 0.75rem 1rem;
                font-size: 0.8125rem;
            }
            
            .text-truncate {
                max-width: 120px;
            }
            
            .action-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.6875rem;
            }
            
            .custom-select {
                min-width: 100px;
                padding: 0.375rem;
            }
        }

        @media (max-width: 575px) {
            .container {
                padding: 0.75rem;
            }
            
            .header h1 {
                font-size: 1.5rem;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .table {
                min-width: 700px;
            }
            
            .table th, .table td {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }
            
            .text-truncate {
                max-width: 100px;
            }
            
            .action-btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.625rem;
            }
            
            .custom-select {
                min-width: 80px;
                padding: 0.25rem;
                font-size: 0.625rem;
            }
        }

        /* Scroll hint pour mobile */
        @media (max-width: 767px) {
            .table-container::before {
                content: "⟵ Faites défiler horizontalement pour voir tous les éléments ⟶";
                display: block;
                text-align: center;
                padding: 0.5rem;
                background-color: var(--dark-element);
                color: var(--gray-text);
                font-size: 0.75rem;
                border-bottom: 1px solid var(--dark-border);
            }
        }

        /* Flexbox pour les actions */
        .action-cell {
            min-width: 200px;
        }

        .action-cell .flex {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            align-items: center;
        }

        /* Amélioration des colonnes importantes */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            min-width: 150px;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            min-width: 150px;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            min-width: 200px;
        }

        .table th:nth-child(8),
        .table td:nth-child(8) {
            min-width: 120px;
        }

        .table th:nth-child(9),
        .table td:nth-child(9) {
            min-width: 150px;
        }

        .table th:nth-child(10),
        .table td:nth-child(10) {
            min-width: 200px;
        }
    </style>
    
</head>
<body>
    <div class="container fade-in">
        <!-- En-tête -->
        <div class="header">
            <h1>
                <i class="fas fa-flag"></i>
                Signalements
            </h1>
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Retour au Dashboard
            </a>
        </div>

        <!-- Barre de recherche -->
        <div class="search-container">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input 
                    type="text" 
                    id="searchInput" 
                    class="search-input" 
                    placeholder="Rechercher par signaleur, auteur, type, contenu, catégorie, détails ou date..."
                >
            </div>
        </div>

        <!-- Messages d'alerte -->
        <div id="success-message" class="alert alert-success hidden">
            <i class="fas fa-check-circle"></i>
            <span id="success-text"></span>
        </div>

        <!-- Table des signalements -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-user mr-2"></i>Signaleur</th>
                        <th><i class="fas fa-user-edit mr-2"></i>Auteur</th>
                        <th><i class="fas fa-tag mr-2"></i>Type</th>
                        <th><i class="fas fa-file-alt mr-2"></i>Contenu</th>
                        <th><i class="fas fa-list mr-2"></i>Catégorie</th>
                        <th><i class="fas fa-info-circle mr-2"></i>Détails</th>
                        <th><i class="fas fa-calendar mr-2"></i>Date</th>
                        <th><i class="fas fa-traffic-light mr-2"></i>Statut</th>
                        <th><i class="fas fa-cog mr-2"></i>Actions Signaleur</th>
                        <th><i class="fas fa-tools mr-2"></i>Actions Auteur</th>
                    </tr>
                </thead>
                <tbody id="reportTable">
                    @foreach ($reports as $report)
                    <tr data-report-id="{{ $report->id }}" class="report-row">
                        <td>
                            <div class="flex items-center">
                                <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                                <span>{{ $report->user ? $report->user->name : 'Utilisateur inconnu' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <i class="fas fa-user-edit text-gray-400 mr-2"></i>
                                <span>{{ $report->reportable && $report->reportable->user ? $report->reportable->user->name : 'Utilisateur inconnu' }}</span>
                            </div>
                        </td>
                        <td>
                            @if($report->reportable_type === 'App\Models\Post')
                                <span class="status-badge status-pending">
                                    <i class="fas fa-file-alt mr-1"></i>
                                    Post
                                </span>
                            @else
                                <span class="status-badge status-reviewed">
                                    <i class="fas fa-comment mr-1"></i>
                                    Commentaire
                                </span>
                            @endif
                        </td>
                        <td class="content-cell" data-content-id="{{ $report->reportable_id }}">
                            @if ($report->reportable_type === 'App\Models\Post')
                                @if ($report->reportable && !$report->reportable->trashed())
                                    <a href="{{ route('post.show', $report->reportable_id) }}" class="table-link text-truncate" title="{{ $report->reportable->title }}">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        {{ Str::limit($report->reportable->title, 50) }}
                                    </a>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-trash mr-1"></i>
                                        {{ $report->reportable ? Str::limit($report->reportable->title, 50) : 'Contenu supprimé' }}
                                    </span>
                                @endif
                            @else
                                @if ($report->reportable && !$report->reportable->trashed())
                                    <a href="{{ route('post.show', $report->reportable->post_id) }}" class="table-link text-truncate" title="{{ $report->reportable->content }}">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        {{ Str::limit($report->reportable->content, 50) }}
                                    </a>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-trash mr-1"></i>
                                        {{ $report->reportable ? Str::limit($report->reportable->content, 50) : 'Contenu supprimé' }}
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <span class="text-truncate">{{ $report->reason_category ?? 'Non spécifié' }}</span>
                        </td>
                        <td>
                            <span class="text-truncate" title="{{ $report->reason_details ?? 'Aucun détail fourni' }}">
                                {{ Str::limit($report->reason_details ?? 'Aucun détail fourni', 30) }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>
                                <span>{{ $report->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.updateReport', $report->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="custom-select">
                                    <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>Examiné</option>
                                    <option value="dismissed" {{ $report->status == 'dismissed' ? 'selected' : '' }}>Rejeté</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            @if ($report->user)
                                @if ($report->user->role !== 'superadmin')
                                    <form action="{{ $report->user->is_active ? route('user.block', $report->user) : route('user.unblock', $report->user) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir {{ $report->user->is_active ? 'bloquer' : 'débloquer' }} ce signaleur ?', '{{ $report->user->is_active ? 'Bloquer' : 'Débloquer' }}')" class="action-btn {{ $report->user->is_active ? 'btn-block' : 'btn-unblock' }}">
                                            <i class="fas {{ $report->user->is_active ? 'fa-ban' : 'fa-check' }} mr-1"></i>
                                            {{ $report->user->is_active ? 'Bloquer' : 'Débloquer' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="action-btn btn-disabled">
                                        <i class="fas fa-shield-alt mr-1"></i>
                                        Superadmin
                                    </span>
                                @endif
                            @else
                                <span class="action-btn btn-disabled">
                                    <i class="fas fa-times mr-1"></i>
                                    Indisponible
                                </span>
                            @endif
                        </td>
                        <td class="action-cell">
                            <div class="flex flex-wrap gap-1">
                                @if ($report->reportable && !$report->reportable->trashed())
                                    @if ($report->reportable_type === 'App\Models\Post')
                                        <form action="{{ route('post.delete', $report->reportable_id) }}" method="POST" class="inline-block delete-form" data-type="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="deleteContent(event, this.form, 'Êtes-vous sûr de vouloir supprimer ce post ?', 'Supprimer')" class="action-btn btn-delete">
                                                <i class="fas fa-trash mr-1"></i>
                                                Supprimer
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('comment.delete', $report->reportable_id) }}" method="POST" class="inline-block delete-form" data-type="comment">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="deleteContent(event, this.form, 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', 'Supprimer')" class="action-btn btn-delete">
                                                <i class="fas fa-trash mr-1"></i>
                                                Supprimer
                                            </button>
                                        </form>
                                    @endif
                                @endif
                                @if ($report->reportable && $report->reportable->user)
                                    @if ($report->reportable->user->role !== 'superadmin')
                                        <form action="{{ $report->reportable->user->is_active ? route('user.block', $report->reportable->user) : route('user.unblock', $report->reportable->user) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir {{ $report->reportable->user->is_active ? 'bloquer' : 'débloquer' }} cet auteur ?', '{{ $report->reportable->user->is_active ? 'Bloquer' : 'Débloquer' }}')" class="action-btn {{ $report->reportable->user->is_active ? 'btn-block' : 'btn-unblock' }}">
                                                <i class="fas {{ $report->reportable->user->is_active ? 'fa-ban' : 'fa-check' }} mr-1"></i>
                                                {{ $report->reportable->user->is_active ? 'Bloquer' : 'Débloquer' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="action-btn btn-disabled">
                                            <i class="fas fa-shield-alt mr-1"></i>
                                            Superadmin
                                        </span>
                                    @endif
                                @else
                                    <span class="action-btn btn-disabled">
                                        <i class="fas fa-times mr-1"></i>
                                        Indisponible
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmAction(event, form, message, actionText) {
            event.preventDefault();
            if (confirm(message)) {
                form.classList.add('loading');
                form.submit();
            }
        }

        function deleteContent(event, form, message, actionText) {
            event.preventDefault();
            if (confirm(message)) {
                form.classList.add('loading');
                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: $(form).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            const row = form.closest('tr');
                            row.style.animation = 'fadeOut 0.3s ease-out forwards';
                            setTimeout(() => {
                                row.remove();
                            }, 300);
                            
                            showSuccessMessage(response.message || 'Action effectuée avec succès !');
                        } else {
                            alert(response.message || 'Erreur lors de la suppression.');
                        }
                        form.classList.remove('loading');
                    },
                    error: function(xhr) {
                        alert('Une erreur s\'est produite lors de la suppression.');
                        form.classList.remove('loading');
                    }
                });
            }
        }

        function showSuccessMessage(message) {
            const successMessage = document.getElementById('success-message');
            const successText = document.getElementById('success-text');
            successText.textContent = message;
            successMessage.classList.remove('hidden');
            
            setTimeout(() => {
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                    successMessage.style.opacity = '';
                    successMessage.style.transform = '';
                }, 300);
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const reportRows = document.querySelectorAll('.report-row');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                reportRows.forEach(row => {
                    const signaleur = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const auteur = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const type = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    const contenu = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                    const categorieRaison = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                    const detailsRaison = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
                    const date = row.querySelector('td:nth-child(7)').textContent.toLowerCase();
                    
                    if (signaleur.includes(searchTerm) || auteur.includes(searchTerm) || type.includes(searchTerm) || contenu.includes(searchTerm) || categorieRaison.includes(searchTerm) || detailsRaison.includes(searchTerm) || date.includes(searchTerm)) {
                        row.style.display = '';
                        row.style.animation = 'fadeInUp 0.3s ease-out';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Animation d'entrée pour les éléments
            const elements = document.querySelectorAll('.table-container, .search-container');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
                element.classList.add('fade-in');
            });
        });

        // Animation de sortie
        const style = document.createElement('style');
        style.textContent = `
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
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>