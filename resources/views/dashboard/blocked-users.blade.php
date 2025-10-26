<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs Bloqués - Dashboard</title>
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
    background: linear-gradient(135deg, var(--primary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
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
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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
}

.table tbody tr {
    transition: background-color 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(139, 92, 246, 0.05);
}

/* Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.status-active {
    background-color: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-blocked {
    background-color: rgba(185, 28, 28, 0.15);
    color: #f87171;
    border: 1px solid rgba(185, 28, 28, 0.3);
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
}

.btn-unblock {
    background-color: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.btn-unblock:hover {
    background-color: rgba(16, 185, 129, 0.25);
    transform: translateY(-1px);
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
    color: var(--primary-color);
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

.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (min-width: 1400px) {
    .container {
        max-width: 1600px;
        padding: 3rem;
    }
    
    .header h1 {
        font-size: 3rem;
    }
    
    .table th, .table td {
        padding: 1.5rem 2rem;
        font-size: 1rem;
    }
}

/* Large screens (1200px - 1399px) */
@media (max-width: 1399px) and (min-width: 1200px) {
    .container {
        max-width: 1200px;
        padding: 2.5rem;
    }
    
    .table th, .table td {
        padding: 1.25rem 1.75rem;
    }
}

/* Medium-Large screens (992px - 1199px) */
@media (max-width: 1199px) and (min-width: 992px) {
    .container {
        padding: 2rem;
    }
    
    .header h1 {
        font-size: 2.25rem;
    }
    
    .table th, .table td {
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
    }
}

/* Medium screens (768px - 991px) */
@media (max-width: 991px) and (min-width: 768px) {
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
        max-width: 300px;
        justify-content: center;
    }
    
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table {
        min-width: 800px;
    }
    
    .table th, .table td {
        padding: 0.875rem 1rem;
        font-size: 0.8125rem;
    }
}

/* Small-Medium screens (576px - 767px) */
@media (max-width: 767px) and (min-width: 576px) {
    .container {
        padding: 1rem;
    }
    
    .header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .header h1 {
        font-size: 1.875rem;
        justify-content: center;
    }
    
    .back-btn {
        align-self: center;
        justify-content: center;
        padding: 0.875rem 1.5rem;
    }
    
    .search-wrapper {
        border-radius: 0.5rem;
    }
    
    .search-input {
        padding: 0.875rem 0.875rem 0.875rem 2.75rem;
        font-size: 0.9375rem;
    }
    
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.75rem;
    }
    
    .table {
        min-width: 700px;
    }
    
    .table th, .table td {
        padding: 0.75rem 0.875rem;
        font-size: 0.8125rem;
    }
    
    /* Masquer certaines colonnes pour plus d'espace */
    .table th:nth-child(3), 
    .table td:nth-child(3) {
        display: none;
    }
    
    .action-btn {
        padding: 0.4375rem 0.875rem;
        font-size: 0.6875rem;
    }
}

/* Small screens (480px - 575px) */
@media (max-width: 575px) and (min-width: 480px) {
    .container {
        padding: 0.875rem;
    }
    
    .header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .header h1 {
        font-size: 1.75rem;
        justify-content: center;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .back-btn {
        align-self: center;
        justify-content: center;
        padding: 0.75rem 1.25rem;
        font-size: 0.875rem;
    }
    
    .search-container {
        margin-bottom: 1.5rem;
    }
    
    .search-input {
        padding: 0.75rem 0.75rem 0.75rem 2.5rem;
        font-size: 0.875rem;
    }
    
    .search-icon {
        left: 0.75rem;
    }
    
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.5rem;
    }
    
    .table {
        min-width: 600px;
    }
    
    .table th, .table td {
        padding: 0.625rem 0.75rem;
        font-size: 0.75rem;
    }
    
    /* Masquer plus de colonnes */
    .table th:nth-child(2), 
    .table td:nth-child(2),
    .table th:nth-child(3), 
    .table td:nth-child(3) {
        display: none;
    }
    
    .action-btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.625rem;
    }
    
    /* Ajuster les avatars */
    .table .h-8 {
        height: 1.75rem;
        width: 1.75rem;
        font-size: 0.75rem;
    }
    
    .table .h-6 {
        height: 1.5rem;
        width: 1.5rem;
        font-size: 0.625rem;
    }
}

/* Extra Small screens (moins de 480px) */
@media (max-width: 479px) {
    .container {
        padding: 0.75rem;
    }
    
    .header {
        flex-direction: column;
        gap: 0.875rem;
        text-align: center;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
    }
    
    .header h1 {
        font-size: 1.5rem;
        justify-content: center;
        flex-direction: column;
        gap: 0.375rem;
    }
    
    .header h1 i {
        font-size: 1.25rem;
    }
    
    .back-btn {
        align-self: center;
        justify-content: center;
        padding: 0.625rem 1rem;
        font-size: 0.8125rem;
        border-radius: 0.5rem;
    }
    
    .search-container {
        margin-bottom: 1.25rem;
    }
    
    .search-wrapper {
        border-radius: 0.5rem;
    }
    
    .search-input {
        padding: 0.625rem 0.625rem 0.625rem 2.25rem;
        font-size: 0.8125rem;
    }
    
    .search-icon {
        left: 0.625rem;
        font-size: 0.875rem;
    }
    
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.5rem;
        margin: 0 -0.25rem;
    }
    
    .table {
        min-width: 500px;
    }
    
    .table th, .table td {
        padding: 0.5rem 0.625rem;
        font-size: 0.6875rem;
    }
    
    /* Masquer encore plus de colonnes pour les très petits écrans */
    .table th:nth-child(2), 
    .table td:nth-child(2),
    .table th:nth-child(3), 
    .table td:nth-child(3) {
        display: none;
    }
    
    /* Réorganiser l'affichage des utilisateurs */
    .table td:first-child .flex {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .table td:first-child .flex-shrink-0 {
        align-self: center;
        margin-right: 0;
        margin-bottom: 0.25rem;
    }
    
    .action-btn {
        padding: 0.3125rem 0.625rem;
        font-size: 0.5625rem;
        border-radius: 0.375rem;
    }
    
    .action-btn i {
        margin-right: 0.25rem;
    }
    
    /* Ajuster les badges de statut */
    .status-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.625rem;
    }
    
    .status-badge i {
        margin-right: 0.125rem;
    }
    
    /* Ajuster les avatars pour les très petits écrans */
    .table .h-8 {
        height: 1.5rem;
        width: 1.5rem;
        font-size: 0.625rem;
    }
    
    .table .h-6 {
        height: 1.25rem;
        width: 1.25rem;
        font-size: 0.5625rem;
    }
}

/* Très petits écrans (moins de 360px) */
@media (max-width: 359px) {
    .container {
        padding: 0.5rem;
    }
    
    .header h1 {
        font-size: 1.25rem;
    }
    
    .table {
        min-width: 400px;
    }
    
    .table th, .table td {
        padding: 0.375rem 0.5rem;
        font-size: 0.625rem;
    }
    
    .search-input {
        padding: 0.5rem 0.5rem 0.5rem 2rem;
        font-size: 0.75rem;
    }
    
    .search-icon {
        left: 0.5rem;
        font-size: 0.75rem;
    }
    
    .action-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.5rem;
    }
    
    .status-badge {
        padding: 0.1875rem 0.375rem;
        font-size: 0.5625rem;
    }
}

/* Orientation paysage pour les petits écrans */
@media (max-width: 767px) and (orientation: landscape) {
    .header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    
    .header h1 {
        font-size: 1.5rem;
        flex-direction: row;
        gap: 0.5rem;
    }
    
    .back-btn {
        align-self: auto;
        max-width: none;
    }
    
    .container {
        padding: 1rem;
    }
}

/* Améliorations pour l'accessibilité tactile */
@media (max-width: 767px) {
    .action-btn {
        min-height: 44px;
        min-width: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .back-btn {
        min-height: 44px;
    }
    
    .search-input {
        min-height: 44px;
    }
}

/* Mode sombre amélioré pour mobile */
@media (max-width: 767px) {
    .table-container {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }
    
    .search-wrapper {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }
    
    .back-btn {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
}

/* Optimisations pour les performances sur mobile */
@media (max-width: 767px) {
    * {
        -webkit-tap-highlight-color: transparent;
    }
    
    .table tbody tr:hover {
        background-color: transparent;
    }
    
    .table tbody tr:active {
        background-color: rgba(139, 92, 246, 0.1);
    }
    
    .action-btn:active {
        transform: scale(0.98);
    }
    
    .back-btn:active {
        transform: translateY(0) scale(0.98);
    }
}
</style>
</head>
<body>
    <div class="container fade-in">
        <div class="header">
            <h1>
                <i class="fas fa-user-slash"></i>
                Utilisateurs Bloqués
            </h1>
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Retour au Dashboard
            </a>
        </div>

        <div class="search-container">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input 
                    type="text" 
                    id="searchInput" 
                    class="search-input" 
                    placeholder="Rechercher par utilisateur, bloqueur ou date..."
                >
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-user mr-2"></i>Utilisateur</th>
                        <th><i class="fas fa-user-shield mr-2"></i>Bloqué par</th>
                        <th><i class="fas fa-calendar mr-2"></i>Date de blocage</th>
                        <th><i class="fas fa-traffic-light mr-2"></i>Statut</th>
                        <th><i class="fas fa-cog mr-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody id="blockedTable">
                    @foreach ($blockedUsers as $blockedUser)
                    <tr data-user-id="{{ $blockedUser->user->id }}" class="blocked-row">
                        <td>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 mr-3">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($blockedUser->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-medium text-white">{{ $blockedUser->user->name }}</div>
                                    <div class="text-gray-400 text-xs">{{ $blockedUser->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                @if($blockedUser->blockedBy)
                                    <div class="flex-shrink-0 h-6 w-6 mr-2">
                                        <div class="h-6 w-6 rounded-full bg-gradient-to-r from-blue-400 to-cyan-400 flex items-center justify-center text-white font-semibold text-xs">
                                            {{ strtoupper(substr($blockedUser->blockedBy->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <span>{{ $blockedUser->blockedBy->name }}</span>
                                @else
                                    <span class="text-muted">Inconnu</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                {{ $blockedUser->blocked_at->format('d/m/Y H:i') }}
                            </div>
                        </td>
                        <td>
                            @if($blockedUser->user->is_active)
                                <span class="status-badge status-active">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Actif
                                </span>
                            @else
                                <span class="status-badge status-blocked">
                                    <i class="fas fa-ban mr-1"></i>
                                    Bloqué
                                </span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('user.unblock', $blockedUser->user) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir débloquer cet utilisateur ?', 'Débloquer')" class="action-btn btn-unblock">
                                    <i class="fas fa-unlock mr-1"></i>
                                    Débloquer
                                </button>
                            </form>
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
            Swal.fire({
                title: 'Confirmation',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim(),
                cancelButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--danger').trim(),
                confirmButtonText: 'Oui, ' + actionText + ' !',
                cancelButtonText: 'Annuler',
                background: getComputedStyle(document.documentElement).getPropertyValue('--dark-card').trim(),
                color: getComputedStyle(document.documentElement).getPropertyValue('--light-text').trim()
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const blockedRows = document.querySelectorAll('.blocked-row');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                blockedRows.forEach(row => {
                    const utilisateur = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const bloqueur = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const date = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    
                    if (utilisateur.includes(searchTerm) || bloqueur.includes(searchTerm) || date.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>