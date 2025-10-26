<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'affectation - Business+ Talk</title>
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

        .btn-success {
            background-color: var(--primary-color);
            color: var(--light-text);
        }

        .btn-success:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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

        .btn-secondary {
            background-color: var(--dark-element);
            color: var(--light-text);
            border: 1px solid var(--dark-border);
        }

        .btn-secondary:hover {
            background-color: var(--dark-border);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Styles pour la nouvelle disposition header */
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

        /* Formulaires */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: var(--light-text);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-text {
            color: var(--gray-text);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        /* Checkboxes personnalisées */
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background-color: var(--dark-element);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .checkbox-item:hover {
            background-color: rgba(26, 158, 158, 0.1);
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }

        .checkbox-item.checked {
            background-color: rgba(26, 158, 158, 0.2);
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(26, 158, 158, 0.3), rgba(26, 158, 158, 0.1));
        }

        .checkbox-item.checked .checkbox-label {
            color: white; /* Blanc au lieu de la couleur primaire */
            font-weight: 600;
        }

        /* Styles pour modules cliquables */
.checkbox-item.clickable-module:hover .checkbox-label {
    color: var(--primary-hover);
}

.checkbox-item.clickable-module:active {
    transform: translateY(-1px) scale(0.98);
}

.checkbox-label.clickable {
    transition: color 0.3s ease;
}

.checkbox-label.clickable:hover {
    color: var(--primary-hover);
}

        .checkbox-input {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid var(--dark-border);
            border-radius: 0.25rem;
            background-color: var(--dark-element);
            margin-right: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .checkbox-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .checkbox-input:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .checkbox-label {
            color: #e5e7eb;
            font-weight: 500;
            cursor: pointer;
        }

        /* Messages d'alerte */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-left-color: var(--success);
            color: var(--success);
        }

        .alert-success .alert-title {
            color: var(--success);
            font-weight: bold;
        }

        /* Modales */
        .modal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.75);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .modal-content {
            background-color: var(--dark-card);
            border-radius: 0.75rem;
            border-top: 4px solid var(--primary-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            max-width: 28rem;
            width: 100%;
            margin: 1rem;
            padding: 2rem;
            text-align: center;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--light-text);
            margin-bottom: 1rem;
        }

        .modal-text {
            color: var(--gray-text);
            margin-bottom: 1rem;
        }

        .modal-highlight {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .modal-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
            text-align: left;
        }

        .modal-list li {
            padding: 0.25rem 0;
            color: var(--gray-text);
            border-bottom: 1px solid var(--dark-border);
        }

        .modal-list li:last-child {
            border-bottom: none;
        }

        .modal-list li::before {
            content: '•';
            color: var(--primary-color);
            margin-right: 0.5rem;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .modal-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .modal-icon.question {
            color: var(--primary-color);
        }

        /* Styles responsifs */
        @media (max-width: 768px) {
            .header-section {
                padding: 0.5rem 0;
            }
            
            .header-section h1 {
                font-size: 1.5rem !important;
                margin-bottom: 1rem;
            }
            
            .checkbox-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .content-area {
                padding: 1rem;
            }
            
            .card-content {
                padding: 1.5rem;
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
            
            .modal-content {
                margin: 0.5rem;
                padding: 1.5rem;
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
                    <!-- Bouton de retour -->
                    <div class="flex justify-start mb-4">
                        <a href="{{ route('affectations.index') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour à la liste
                        </a>
                    </div>

                    <!-- Titre centré -->
                    <div class="text-center mb-4">
                        <h1 class="text-3xl font-bold" style="color: var(--light-text);">
                            <i class="fas fa-user-edit mr-3" style="color: var(--primary-color);"></i>
                            Modifier l'affectation
                        </h1>
                    </div>
                </div>

                <!-- Message de succès -->
                @if(session('success'))
                    <div class="alert alert-success fade-in">
                        <div class="alert-title">
                            <i class="fas fa-check-circle mr-2"></i>
                            Succès !
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Carte principale -->
                <div class="card fade-in">
                    <div class="card-content">
                        <form id="updateForm" action="{{ route('affectations.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Informations utilisateur -->
                            <div class="form-group">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mr-3" style="background-color: var(--primary-color);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="color: var(--light-text);" class="font-semibold text-lg">{{ $user->name }}</div>
                                        <div style="color: var(--gray-text);" class="text-sm">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sélection des modules -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-puzzle-piece mr-2"></i>
                                    Modules disponibles
                                </label>
                                
                                <div class="checkbox-grid">
                                    @foreach ($modules as $mod)
                                        @php
                                            $userModules = $user->affectation ? 
                                                (is_array($user->affectation->modules) ? 
                                                    $user->affectation->modules : 
                                                    json_decode($user->affectation->modules, true)) : 
                                                [];
                                            $checked = is_array($userModules) && in_array($mod, $userModules);
                                        @endphp
                                        <label class="checkbox-item {{ $checked ? 'checked' : '' }}">
                                            <input type="checkbox" 
                                                   name="modules[]" 
                                                   value="{{ $mod }}" 
                                                   {{ $checked ? 'checked' : '' }}
                                                   class="checkbox-input">
                                            <span class="checkbox-label">
                                                {{ ucfirst($mod) }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="flex justify-center mt-8">
                                <button type="button" id="confirmBtn" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Modal de confirmation -->
    <div id="confirmModal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-icon question">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 class="modal-title">Confirmation des modifications</h3>
            <p class="modal-text">Vous allez affecter les modules suivants à :</p>
            <p class="modal-highlight" id="adminName"><!-- Nom de l'admin --></p>
            
            <div>
                <p class="modal-text">Modules sélectionnés :</p>
                <ul id="selectedModules" class="modal-list">
                    <!-- Les modules cochés seront listés ici -->
                </ul>
            </div>
            
            <p class="modal-text">Êtes-vous sûr de vouloir continuer ?</p>
            
            <div class="modal-buttons">
                <button id="cancelBtn" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </button>
                <button id="confirmYesBtn" class="btn btn-primary">
                    <i class="fas fa-check mr-2"></i>
                    Confirmer
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de succès -->
    <div id="successModal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="modal-title">Modification enregistrée</h3>
            <p class="modal-text">Les modules ont été affectés avec succès.</p>
            <div class="modal-buttons">
                <button id="okBtn" class="btn btn-success">
                    <i class="fas fa-check mr-2"></i>
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        // Récupérer les éléments DOM
        const confirmBtn = document.getElementById('confirmBtn');
        const confirmModal = document.getElementById('confirmModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmYesBtn = document.getElementById('confirmYesBtn');
        const successModal = document.getElementById('successModal');
        const okBtn = document.getElementById('okBtn');
        const updateForm = document.getElementById('updateForm');
        const adminName = document.getElementById('adminName');
        const selectedModules = document.getElementById('selectedModules');

        // Gestion des checkboxes visuelles
        // Gestion des checkboxes visuelles et modules cliquables
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Page de modification des affectations chargée avec le style Business+ Talk - Modules cliquables');
    
    const checkboxItems = document.querySelectorAll('.checkbox-item');
    checkboxItems.forEach(item => {
        const checkbox = item.querySelector('.checkbox-input');
        const label = item.querySelector('.checkbox-label');
        
        // Ajouter les classes pour les modules cliquables
        item.classList.add('clickable-module');
        label.classList.add('clickable');
        
        // Gestion du clic sur l'item entier
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Effet visuel au clic
            this.style.transform = 'translateY(-1px) scale(0.98)';
            
            // Toggle checkbox
            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change'));
            
            // Restaurer l'effet visuel
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Afficher notification du module cliqué
            const moduleName = label.textContent.trim().replace(/^\s*\w+\s*/, '');
            showModuleClickNotification(moduleName, checkbox.checked);
        });
        
        // Gestion du changement de statut
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                item.classList.add('checked');
            } else {
                item.classList.remove('checked');
            }
        });
        
        // Effet de survol amélioré
        item.addEventListener('mouseenter', function() {
            if (!this.classList.contains('checked')) {
                this.style.backgroundColor = 'rgba(26, 158, 158, 0.15)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            if (!this.classList.contains('checked')) {
                this.style.backgroundColor = '';
            }
        });
    });
});

// Fonction pour afficher une notification quand un module est cliqué
function showModuleClickNotification(moduleName, isChecked) {
    const status = isChecked ? 'activé' : 'désactivé';
    const icon = isChecked ? 'fas fa-check-circle' : 'fas fa-times-circle';
    const color = isChecked ? 'var(--success)' : 'var(--warning)';
    
    // Créer une notification temporaire
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--dark-card);
            border: 1px solid ${color};
            border-radius: 0.5rem;
            padding: 1rem;
            color: var(--light-text);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            animation: slideInRight 0.3s ease-out;
            max-width: 300px;
        ">
            <div style="display: flex; align-items: center;">
                <i class="${icon}" style="color: ${color}; margin-right: 0.5rem; font-size: 1.2rem;"></i>
                <div>
                    <div style="font-weight: bold; margin-bottom: 0.25rem;">Module ${status}</div>
                    <div style="font-size: 0.9rem; color: var(--gray-text);">${moduleName}</div>
                </div>
            </div>
        </div>
    `;
    
    // Ajouter les styles d'animation si pas déjà présents
    if (!document.getElementById('moduleNotificationStyles')) {
        const style = document.createElement('style');
        style.id = 'moduleNotificationStyles';
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Supprimer la notification après 2.5 secondes
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 2500);
}

        // Afficher la modal de confirmation
        confirmBtn.addEventListener('click', function() {
            // Afficher le nom de l'admin
            adminName.textContent = "{{ $user->name }}";
            
            // Vider la liste des modules précédemment affichés
            selectedModules.innerHTML = '';
            
            // Récupérer tous les modules cochés
            const checkedModules = document.querySelectorAll('input[name="modules[]"]:checked');
            
            // Si aucun module n'est coché
            if (checkedModules.length === 0) {
                const li = document.createElement('li');
                li.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Aucun module sélectionné';
                li.style.color = 'var(--warning)';
                selectedModules.appendChild(li);
            } else {
                // Ajouter chaque module coché à la liste
                checkedModules.forEach(function(module) {
                    const li = document.createElement('li');
                    const moduleName = module.nextElementSibling.textContent.trim();
                    li.innerHTML = `<i class="fas fa-cube mr-2"></i>${moduleName}`;
                    selectedModules.appendChild(li);
                });
            }
            
            // Afficher la modal
            confirmModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        // Cacher la modal de confirmation si annulation
        cancelBtn.addEventListener('click', function() {
            confirmModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // Soumettre le formulaire si confirmation
        confirmYesBtn.addEventListener('click', function() {
            // Cacher la modal de confirmation
            confirmModal.classList.add('hidden');
            
            // Soumission du formulaire via AJAX pour rester sur la même page
            const formData = new FormData(updateForm);
            
            fetch(updateForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher la modal de succès
                    successModal.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                // En cas d'erreur, soumettre le formulaire normalement
                updateForm.submit();
            });
        });

        // Fermer la modal de succès
        okBtn.addEventListener('click', function() {
            successModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // Fermer les modales en cliquant sur l'arrière-plan
        confirmModal.addEventListener('click', function(e) {
            if (e.target === this) {
                cancelBtn.click();
            }
        });

        successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                okBtn.click();
            }
        });

        // Fermer les modales avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!confirmModal.classList.contains('hidden')) {
                    cancelBtn.click();
                }
                if (!successModal.classList.contains('hidden')) {
                    okBtn.click();
                }
            }
        });
    </script>
</body>
</html>