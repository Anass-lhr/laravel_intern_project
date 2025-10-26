<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signalements Podcasts - Dashboard</title>
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
.type-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.podcast-comment {
    background-color: rgba(139, 92, 246, 0.15);
    color: var(--primary-color);
    border: 1px solid rgba(139, 92, 246, 0.3);
}

.podcast-reply {
    background-color: rgba(16, 185, 129, 0.15);
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
}

.btn-block {
    background-color: rgba(245, 158, 11, 0.15);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.btn-unblock {
    background-color: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.btn-delete {
    background-color: rgba(185, 28, 28, 0.15);
    color: #f87171;
    border: 1px solid rgba(185, 28, 28, 0.3);
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
}

.custom-select:hover {
    border-color: var(--primary-color);
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

/* SweetAlert2 thème sombre */
.swal2-popup {
    background-color: var(--dark-card) !important;
    color: var(--light-text) !important;
    border: 1px solid var(--dark-border) !important;
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
    
    .text-truncate {
        max-width: 280px;
    }
    
    .action-btn {
        padding: 0.625rem 1.25rem;
        font-size: 0.8125rem;
    }
    
    .custom-select {
        padding: 0.625rem;
        font-size: 0.8125rem;
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
    
    .text-truncate {
        max-width: 240px;
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
    
    .text-truncate {
        max-width: 200px;
    }
    
    .action-btn {
        padding: 0.4375rem 0.875rem;
        font-size: 0.6875rem;
    }
    
    .custom-select {
        padding: 0.4375rem;
        font-size: 0.6875rem;
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
        min-width: 1200px;
    }
    
    .table th, .table td {
        padding: 0.875rem 1rem;
        font-size: 0.8125rem;
    }
    
    .text-truncate {
        max-width: 160px;
    }
    
    .action-btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.625rem;
    }
    
    .custom-select {
        padding: 0.375rem;
        font-size: 0.625rem;
    }
    
    /* Masquer une colonne moins importante */
    .table th:nth-child(6), 
    .table td:nth-child(6) {
        display: none;
    }
    
    /* Ajuster les badges de type */
    .type-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.625rem;
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
        min-width: 1000px;
    }
    
    .table th, .table td {
        padding: 0.75rem 0.875rem;
        font-size: 0.8125rem;
    }
    
    /* Masquer plusieurs colonnes */
    .table th:nth-child(5), 
    .table td:nth-child(5),
    .table th:nth-child(6), 
    .table td:nth-child(6) {
        display: none;
    }
    
    .text-truncate {
        max-width: 130px;
    }
    
    .action-btn {
        padding: 0.3125rem 0.625rem;
        font-size: 0.5625rem;
    }
    
    .custom-select {
        padding: 0.3125rem;
        font-size: 0.5625rem;
    }
    
    .type-badge {
        padding: 0.1875rem 0.375rem;
        font-size: 0.5625rem;
    }
    
    /* Réorganiser les actions */
    .action-cell {
        min-width: 120px;
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
        min-width: 800px;
    }
    
    .table th, .table td {
        padding: 0.625rem 0.75rem;
        font-size: 0.75rem;
    }
    
    /* Masquer encore plus de colonnes */
    .table th:nth-child(3), 
    .table td:nth-child(3),
    .table th:nth-child(5), 
    .table td:nth-child(5),
    .table th:nth-child(6), 
    .table td:nth-child(6) {
        display: none;
    }
    
    .text-truncate {
        max-width: 100px;
    }
    
    .action-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.5rem;
    }
    
    .custom-select {
        padding: 0.25rem;
        font-size: 0.5rem;
    }
    
    /* Actions empilées */
    .action-cell {
        min-width: 100px;
    }
    
    .action-cell .inline-block {
        display: block;
        margin: 0.125rem 0;
    }
    
    .action-cell button,
    .action-cell span {
        width: 100%;
        justify-content: center;
        text-align: center;
        font-size: 0.5rem;
        padding: 0.25rem 0.375rem;
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
        min-width: 650px;
    }
    
    .table th, .table td {
        padding: 0.5rem 0.625rem;
        font-size: 0.6875rem;
    }
    
    /* Masquer maximum de colonnes pour les très petits écrans */
    .table th:nth-child(2), 
    .table td:nth-child(2),
    .table th:nth-child(3), 
    .table td:nth-child(3),
    .table th:nth-child(5), 
    .table td:nth-child(5),
    .table th:nth-child(6), 
    .table td:nth-child(6),
    .table th:nth-child(7), 
    .table td:nth-child(7) {
        display: none;
    }
    
    .text-truncate {
        max-width: 80px;
    }
    
    .action-btn {
        padding: 0.1875rem 0.375rem;
        font-size: 0.4375rem;
        border-radius: 0.375rem;
    }
    
    .custom-select {
        padding: 0.1875rem;
        font-size: 0.4375rem;
    }
    
    /* Actions complètement empilées */
    .action-cell {
        min-width: 80px;
    }
    
    .action-cell .inline-block {
        display: block;
        width: 100%;
        margin: 0.0625rem 0;
    }
    
    .action-cell button,
    .action-cell span {
        width: 100%;
        justify-content: center;
        text-align: center;
        font-size: 0.375rem;
        padding: 0.1875rem 0.25rem;
    }
    
    /* Simplifier l'affichage du signaleur */
    .table td:first-child {
        font-size: 0.625rem;
        font-weight: 600;
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
        min-width: 500px;
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
        padding: 0.125rem 0.25rem;
        font-size: 0.375rem;
    }
    
    .custom-select {
        padding: 0.125rem;
        font-size: 0.375rem;
    }
    
    .text-truncate {
        max-width: 60px;
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
    
    .table {
        min-width: 1000px;
    }
    
    /* Afficher une colonne de plus en paysage */
    .table th:nth-child(3), 
    .table td:nth-child(3) {
        display: table-cell;
    }
}

/* Améliorations pour l'accessibilité tactile */
@media (max-width: 767px) {
    .action-btn,
    .table .bg-yellow-500,
    .table .bg-green-500,
    .table .bg-red-500 {
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
    
    .custom-select {
        min-height: 40px;
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
    
    .action-btn:active,
    .table button:active {
        transform: scale(0.98);
    }
    
    .back-btn:active {
        transform: translateY(0) scale(0.98);
    }
    
    .custom-select:active {
        transform: scale(0.99);
    }
}

/* Affichage spécial pour les très longues tables */
@media (max-width: 575px) {
    .table-container::before {
        content: "⟵ Faites défiler horizontalement ⟶";
        display: block;
        text-align: center;
        padding: 0.5rem;
        background-color: var(--dark-element);
        color: var(--gray-text);
        font-size: 0.75rem;
        border-bottom: 1px solid var(--dark-border);
    }
}

/* Animation responsive améliorée */
@media (max-width: 767px) {
    .fade-in {
        animation: fadeInUp 0.4s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
}

/* Personnalisation des badges podcast pour mobile */
@media (max-width: 767px) {
    .type-badge.podcast-comment,
    .type-badge.podcast-reply {
        font-size: 0.5rem;
        padding: 0.125rem 0.25rem;
    }
    
    .type-badge i {
        margin-right: 0.125rem;
        font-size: 0.75em;
    }
}

/* Gestion des boutons Tailwind CSS sur mobile */
@media (max-width: 575px) {
    .table .bg-yellow-500,
    .table .bg-green-500,
    .table .bg-red-500 {
        font-size: 0.5rem;
        padding: 0.25rem 0.375rem;
        border-radius: 0.25rem;
        margin: 0.0625rem 0;
        width: 100%;
    }
    
    .table .text-gray-500 {
        font-size: 0.5rem;
        text-align: center;
    }
}

/* Optimisation des liens de contenu pour mobile */
@media (max-width: 767px) {
    .table .text-blue-600 {
        font-size: 0.75rem;
        display: block;
        word-break: break-word;
    }
}

/* Amélioration de l'affichage des dates sur mobile */
@media (max-width: 479px) {
    .table td:nth-child(7) {
        font-size: 0.625rem;
        white-space: nowrap;
    }
}

/* Gestion des classes whitespace-nowrap sur mobile */
@media (max-width: 575px) {
    .table .whitespace-nowrap {
        white-space: normal;
        word-wrap: break-word;
    }
}

/* Optimisation SweetAlert2 pour mobile */
@media (max-width: 767px) {
    .swal2-popup {
        font-size: 0.875rem !important;
        margin: 1rem !important;
    }
    
    .swal2-title {
        font-size: 1.25rem !important;
    }
    
    .swal2-content {
        font-size: 0.875rem !important;
    }
}
</style>
</head>
<body>
    <div class="container fade-in">
        <div class="header">
    <h1>
        <i class="fas fa-podcast"></i>
        Signalements Podcasts
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
            placeholder="Rechercher par signaleur, auteur, type, catégorie, détails ou date..."
        >
    </div>
</div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-user mr-2"></i>Signaleur</th>
                        <th><i class="fas fa-user-edit mr-2"></i>Auteur</th>
                        <th><i class="fas fa-podcast mr-2 podcast-icon"></i>Type</th>
                        <th><i class="fas fa-comment mr-2"></i>Contenu</th>
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $report->user ? $report->user->name : 'Utilisateur inconnu' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $report->comment && $report->comment->user ? $report->comment->user->name : ($report->reply && $report->reply->user ? $report->reply->user->name : 'Utilisateur inconnu') }}
                        </td>
                        <td>
                            @if($report->comment_id)
                                <span class="type-badge podcast-comment">
                                    <i class="fas fa-comment mr-1"></i>
                                    Commentaire
                                </span>
                            @else
                                <span class="type-badge podcast-reply">
                                    <i class="fas fa-reply mr-1"></i>
                                    Réponse
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap content-cell" data-content-id="{{ $report->comment_id ?? $report->reply_id }}">
                            @if ($report->comment_id && $report->comment)
                                <a href="{{ route('podcasts.index') }}?videoId={{ $report->comment->video_id }}" class="text-blue-600 hover:underline">
                                    {{ Str::limit($report->comment->content, 50) }}
                                </a>
                            @elseif ($report->reply_id && $report->reply)
                                <a href="{{ route('podcasts.index') }}?videoId={{ $report->reply->video_id }}" class="text-blue-600 hover:underline">
                                    {{ Str::limit($report->reply->content, 50) }}
                                </a>
                            @else
                                <span class="text-gray-500">Contenu supprimé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->reason_category ?? 'Non spécifié' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->reason_details ?? 'Aucun détail fourni' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('dashboard.podcasts.updateReport', $report->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="custom-select">
                                    <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>Examiné</option>
                                    <option value="dismissed" {{ $report->status == 'dismissed' ? 'selected' : '' }}>Rejeté</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($report->user)
                                @if ($report->user->role !== 'superadmin')
                                    <form action="{{ $report->user->is_active ? route('user.block', $report->user) : route('user.unblock', $report->user) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir {{ $report->user->is_active ? 'bloquer' : 'débloquer' }} ce signaleur ?', '{{ $report->user->is_active ? 'Bloquer' : 'Débloquer' }}')" class="{{ $report->user->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white text-sm px-3 py-1 rounded">{{ $report->user->is_active ? 'Bloquer' : 'Débloquer' }}</button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm">Non blocable (Superadmin)</span>
                                @endif
                            @else
                                <span class="text-gray-500 text-sm">Aucune action disponible</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap action-cell">
                            @if ($report->comment_id && $report->comment)
                                <form action="{{ route('podcasts.comment.delete', $report->comment->id) }}" method="POST" class="inline-block mr-2 delete-form" data-type="comment">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deleteContent(event, this.form, 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', 'Supprimer')" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Supprimer</button>
                                </form>
                            @elseif ($report->reply_id && $report->reply)
                                <form action="{{ route('podcast.reply.delete', $report->reply->id) }}" method="POST" class="inline-block mr-2 delete-form" data-type="reply">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deleteContent(event, this.form, 'Êtes-vous sûr de vouloir supprimer cette réponse ?', 'Supprimer')" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Supprimer</button>
                                </form>
                            @endif
                            @if ($report->comment && $report->comment->user)
                                @if ($report->comment->user->role !== 'superadmin')
                                    <form action="{{ $report->comment->user->is_active ? route('user.block', $report->comment->user) : route('user.unblock', $report->comment->user) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir {{ $report->comment->user->is_active ? 'bloquer' : 'débloquer' }} cet auteur ?', '{{ $report->comment->user->is_active ? 'Bloquer' : 'Débloquer' }}')" class="{{ $report->comment->user->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white text-sm px-3 py-1 rounded">{{ $report->comment->user->is_active ? 'Bloquer' : 'Débloquer' }}</button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm">Non blocable (Superadmin)</span>
                                @endif
                            @elseif ($report->reply && $report->reply->user)
                                @if ($report->reply->user->role !== 'superadmin')
                                    <form action="{{ $report->reply->user->is_active ? route('user.block', $report->reply->user) : route('user.unblock', $report->reply->user) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir {{ $report->reply->user->is_active ? 'bloquer' : 'débloquer' }} cet auteur ?', '{{ $report->reply->user->is_active ? 'Bloquer' : 'Débloquer' }}')" class="{{ $report->reply->user->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white text-sm px-3 py-1 rounded">{{ $report->reply->user->is_active ? 'Bloquer' : 'Débloquer' }}</button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm">Non blocable (Superadmin)</span>
                                @endif
                            @else
                                <span class="text-gray-500 text-sm">Aucune action disponible</span>
                            @endif
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, ' + actionText + ' !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function deleteContent(event, form, message, actionText) {
            event.preventDefault();
            Swal.fire({
                title: 'Confirmation',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, ' + actionText + ' !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.action,
                        method: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status === 'success') {
                                // Trouver la ligne et la cellule de contenu
                                const row = form.closest('tr');
                                const contentCell = row.querySelector('.content-cell');
                                const actionCell = row.querySelector('.action-cell');

                                // Mettre à jour la cellule de contenu
                                contentCell.innerHTML = '<span class="text-gray-500">Contenu supprimé</span>';

                                // Supprimer le formulaire de suppression
                                const deleteForm = actionCell.querySelector('.delete-form');
                                if (deleteForm) {
                                    deleteForm.remove();
                                }

                                Swal.fire('Supprimé !', response.message, 'success');
                            } else {
                                Swal.fire('Erreur !', response.message || 'Erreur lors de la suppression.', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Erreur !', 'Une erreur s\'est produite lors de la suppression.', 'error');
                        }
                    });
                }
            });
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
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>