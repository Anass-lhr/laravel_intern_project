<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration Générale - Business+ Talk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
}

/* Zone de contenu */
.content-area {
    padding: 2rem;
    flex: 1;
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

.btn-success {
    background-color: var(--success);
    color: var(--light-text);
}

.btn-success:hover {
    background-color: #059669;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* Styles pour la nouvelle disposition header */
.header-section {
    padding: 1rem 0;
}

/* Styles pour les cartes */
.form-card {
    background-color: var(--dark-card);
    border: 1px solid var(--dark-border);
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 1.5rem;
    padding: 2rem;
}

.form-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

/* Styles pour les champs de formulaire */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: var(--light-text);
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    letter-spacing: 0.025em;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    background-color: var(--dark-element);
    border: 1px solid var(--dark-border);
    border-radius: 0.5rem;
    color: var(--light-text);
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(26, 158, 158, 0.1);
    transform: translateY(-1px);
}

.form-input::placeholder {
    color: var(--gray-text);
    opacity: 0.7;
}

.color-input {
    height: 3rem;
    padding: 0.25rem;
    cursor: pointer;
}

.color-input:hover {
    transform: scale(1.05);
}

/* Styles pour les messages de succès/erreur */
.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid;
    font-size: 0.9rem;
}

.alert-success {
    background-color: rgba(16, 185, 129, 0.1);
    border-left-color: var(--success);
    color: #34d399;
}

.alert-error {
    background-color: rgba(185, 28, 28, 0.1);
    border-left-color: var(--danger);
    color: #f87171;
}

.error-text {
    color: #f87171;
    font-size: 0.8rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
}

.error-text i {
    margin-right: 0.25rem;
}

/* Section superadmin */
.superadmin-section {
    background: linear-gradient(135deg, rgba(185, 28, 28, 0.1), rgba(180, 83, 9, 0.1));
    border: 1px solid rgba(185, 28, 28, 0.3);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    position: relative;
}

.superadmin-section::before {
    content: '';
    position: absolute;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: -1px;
    background: linear-gradient(135deg, var(--danger), var(--warning));
    border-radius: 0.75rem;
    z-index: -1;
    opacity: 0.3;
}

.superadmin-badge {
    display: inline-flex;
    align-items: center;
    background-color: var(--danger);
    color: var(--light-text);
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    margin-bottom: 1rem;
    font-weight: 600;
}

/* Sections de liens sociaux */
.social-section {
    background-color: var(--dark-element);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.social-title {
    color: var(--light-text);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.social-title i {
    margin-right: 0.5rem;
    color: var(--primary-color);
}

.social-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

/* Informations de modification */
.modification-info {
    background-color: var(--dark-element);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-top: 1.5rem;
    border-left: 4px solid var(--primary-color);
}

.modification-info .text-sm {
    color: var(--gray-text);
    font-size: 0.85rem;
}

.modification-info .font-medium {
    color: var(--light-text);
    font-weight: 600;
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

/* Ajustements responsifs */
@media (max-width: 768px) {
    .content-area {
        padding: 1rem;
    }
    
    .form-card {
        padding: 1.5rem;
    }
    
    .social-grid {
        grid-template-columns: 1fr;
    }
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

/* Animation pour les champs de formulaire */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.form-group {
    animation: slideIn 0.3s ease-out;
}

.form-group:nth-child(even) {
    animation-delay: 0.1s;
}

.form-group:nth-child(odd) {
    animation-delay: 0.2s;
}
</style>
</head>
<body>
    <div class="container">
    <div class="main-content">
        <div class="content-area">
            <div class="max-w-4xl mx-auto">
                
                <div class="header-section mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <form action="{{ route('dashboard') }}" method="get">
                            <button class="btn btn-outline" type="submit">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour
                            </button>
                        </form>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold" style="color: var(--light-text);">
                            <i class="fas fa-cogs mr-3" style="color: var(--primary-color);"></i>
                            Configuration Générale
                        </h1>
                        <p class="text-gray-400 mt-2">
                            Personnalisez les paramètres de votre application Business+ Talk
                        </p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success fade-in">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="form-card fade-in">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


            <!-- Couleur principale (réservée au superadmin) -->
            @if (Auth::user()->role === 'superadmin')
    <div class="superadmin-section">
        <div class="superadmin-badge">
            <i class="fas fa-crown mr-1"></i>
            Réservé au Superadmin
        </div>
        
        <div class="form-group">
            <label for="primary_color" class="form-label">
                <i class="fas fa-palette mr-2"></i>
                Couleur principale
            </label>
            <input type="color" 
                   name="primary_color" 
                   id="primary_color" 
                   value="{{ $settings->primary_color ?? '#1EB5AD' }}" 
                   class="form-input color-input">
            @error('primary_color')
                <div class="error-text">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
@endif

            <div class="social-section">
    <h3 class="social-title">
        <i class="fas fa-share-alt"></i>
        Réseaux Sociaux
    </h3>
    
    <div class="social-grid">
        <div class="form-group">
            <label for="facebook_url" class="form-label">
                Lien Facebook
            </label>
            <input type="url" name="facebook_url" id="facebook_url" value="{{ $settings->facebook_url }}" class="form-input" placeholder="https://www.facebook.com/...">
            @error('facebook_url')
                <div class="error-text">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="youtube_url" class="form-label">Lien YouTube</label>
            <input type="url" name="youtube_url" id="youtube_url" value="{{ $settings->youtube_url }}" class="form-input" placeholder="https://www.youtube.com/...">
            @error('youtube_url')
                <div class="error-text">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="instagram_url" class="form-label">Lien Instagram</label>
            <input type="url" name="instagram_url" id="instagram_url" value="{{ $settings->instagram_url }}" class="form-input"placeholder="https://www.instagram.com/...">
            @error('instagram_url')
                <div class="error-text">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="linkedin_url" class="form-label">Lien LinkedIn</label>
            <input type="url" name="linkedin_url" id="linkedin_url" value="{{ $settings->linkedin_url }}" class="form-input" placeholder="https://www.linkedin.com/...">
            @error('linkedin_url')
                <div class="error-text">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" name="email" id="email" value="{{ $settings->email }}" class="form-input" placeholder="exemple@domaine.com">
            @error('email')
                <div class="error-text">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
        
    </div>
</div>

           

            <!-- Submit Button with Adjusted Styling -->
            <div class="flex justify-center mt-8">
    <button type="submit" class="btn btn-success">
        <i class="fas fa-save mr-2"></i>
        Appliquer les modifications
    </button>
</div>
        </form>

        <!-- Afficher le dernier modificateur -->
        @if ($settings->modified_by)
    <div class="modification-info">
        <div class="text-sm">
            <i class="fas fa-user-edit mr-2"></i>
            Dernière modification par : 
            <span class="font-medium">{{ $settings->modifier->name }}</span>
        </div>
    </div>
@endif
    </div>
</form>
                </div>
                
            </div>
        </div>

    </div>
</div>
    
    <script>
        // Animation d'entrée pour les éléments
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Page de configuration chargée avec le style Business+ Talk');
    
    // Ajouter des animations lors du focus sur les champs
    const formInputs = document.querySelectorAll('.form-input');
    
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    // Animation pour le bouton de soumission
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
        });
        
        submitButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }

    // Validation en temps réel pour les URLs
    const urlInputs = document.querySelectorAll('input[type="url"]');
    urlInputs.forEach(input => {
        input.addEventListener('input', function() {
            const value = this.value.trim();
            if (value && !isValidUrl(value)) {
                this.style.borderColor = 'var(--danger)';
                showValidationMessage(this, 'URL invalide', 'error');
            } else {
                this.style.borderColor = 'var(--dark-border)';
                hideValidationMessage(this);
            }
        });
    });

    // Validation en temps réel pour l'email
    const emailInput = document.querySelector('input[type="email"]');
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            const value = this.value.trim();
            if (value && !isValidEmail(value)) {
                this.style.borderColor = 'var(--danger)';
                showValidationMessage(this, 'Email invalide', 'error');
            } else {
                this.style.borderColor = 'var(--dark-border)';
                hideValidationMessage(this);
            }
        });
    }

    // Prévisualisation de la couleur
    const colorInput = document.querySelector('#primary_color');
    if (colorInput) {
        colorInput.addEventListener('input', function() {
            const color = this.value;
            // Appliquer temporairement la nouvelle couleur pour prévisualisation
            document.documentElement.style.setProperty('--primary-color', color);
            
            // Afficher un message de prévisualisation
            showPreviewMessage();
        });
    }

    // Fonctions utilitaires
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showValidationMessage(input, message, type) {
        hideValidationMessage(input); // Supprimer l'ancien message
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `validation-message validation-${type}`;
        messageDiv.innerHTML = `<i class="fas fa-exclamation-triangle mr-1"></i>${message}`;
        messageDiv.style.cssText = `
            color: ${type === 'error' ? '#f87171' : '#34d399'};
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            animation: fadeIn 0.3s ease;
        `;
        
        input.parentNode.appendChild(messageDiv);
    }

    function hideValidationMessage(input) {
        const existingMessage = input.parentNode.querySelector('.validation-message');
        if (existingMessage) {
            existingMessage.remove();
        }
    }

    function showPreviewMessage() {
        let previewMessage = document.getElementById('color-preview-message');
        if (!previewMessage) {
            previewMessage = document.createElement('div');
            previewMessage.id = 'color-preview-message';
            previewMessage.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: var(--success);
                color: var(--light-text);
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                font-size: 0.85rem;
                z-index: 1000;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                transition: opacity 0.3s ease;
                display: flex;
                align-items: center;
            `;
            previewMessage.innerHTML = '<i class="fas fa-eye mr-2"></i>Prévisualisation appliquée';
            document.body.appendChild(previewMessage);
        }
        
        // Réinitialiser l'opacité et masquer après 3 secondes
        previewMessage.style.opacity = '1';
        setTimeout(() => {
            previewMessage.style.opacity = '0';
        }, 3000);
    }

    // Amélioration de l'expérience utilisateur
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach((group, index) => {
        // Animation d'entrée décalée
        group.style.opacity = '0';
        group.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            group.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            group.style.opacity = '1';
            group.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Raccourcis clavier
    document.addEventListener('keydown', function(e) {
        // Ctrl+S pour sauvegarder
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            if (submitButton) {
                submitButton.click();
            }
        }
        
        // Escape pour revenir
        if (e.key === 'Escape') {
            const backButton = document.querySelector('.btn-outline');
            if (backButton) {
                backButton.click();
            }
        }
    });

    // Gestion du formulaire avant soumission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Ajouter un indicateur de chargement
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sauvegarde...';
                submitButton.disabled = true;
                
                // Restaurer en cas d'erreur (après 5 secondes)
                setTimeout(() => {
                    if (submitButton.disabled) {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }
                }, 5000);
            }
        });
    }

    // Ajouter des tooltips informatifs
    addTooltips();

    function addTooltips() {
        const tooltipData = {
            'primary_color': 'Cette couleur sera utilisée pour tous les éléments principaux de l\'interface',
            'facebook_url': 'Lien vers votre page Facebook officielle',
            'youtube_url': 'Lien vers votre chaîne YouTube',
            'instagram_url': 'Lien vers votre profil Instagram',
            'linkedin_url': 'Lien vers votre page LinkedIn',
            'email': 'Adresse email de contact principal'
        };

        Object.keys(tooltipData).forEach(inputId => {
            const input = document.getElementById(inputId);
            if (input) {
                input.title = tooltipData[inputId];
                input.addEventListener('mouseenter', function() {
                    showTooltip(this, tooltipData[inputId]);
                });
                input.addEventListener('mouseleave', hideTooltip);
            }
        });
    }

    function showTooltip(element, text) {
        const tooltip = document.createElement('div');
        tooltip.className = 'custom-tooltip';
        tooltip.textContent = text;
        tooltip.style.cssText = `
            position: absolute;
            background-color: var(--dark-element);
            color: var(--light-text);
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.8rem;
            z-index: 1000;
            max-width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--dark-border);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        `;
        
        document.body.appendChild(tooltip);
        
        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + 'px';
        tooltip.style.top = (rect.bottom + 5) + 'px';
        
        setTimeout(() => {
            tooltip.style.opacity = '1';
        }, 100);
        
        element._tooltip = tooltip;
    }

    function hideTooltip(e) {
        if (e.target._tooltip) {
            e.target._tooltip.remove();
            delete e.target._tooltip;
        }
    }
});
</script>
</body>
</html>