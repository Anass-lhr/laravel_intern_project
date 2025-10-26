<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1EB5AD;
            --primary-color-hover: color-mix(in srgb, var(--primary-color) 80%, #000000);
            --primary-color-dark: #148585;
            --dark-bg: #1A1D21;
            --darker-bg: #111315;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
            --gray-bg: #2A2D35;
            --highlight-color: #00f0ff;
            --article-shadow: rgba(0, 240, 255, 0.05);
            --dark-border: #333333;
            --dark-element: #252525;
            --success: #10b981;
            --danger: #b91c1c;
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
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem;
        }

        .form-container {
            background-color: var(--dark-bg);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--gray-text);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background-color: var(--gray-bg);
            color: var(--light-text);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 8px var(--article-shadow);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--light-text);
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--primary-color-hover);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--dark-element);
            color: var(--light-text);
            border: 1px solid var(--dark-border);
        }

        .btn-secondary:hover {
            background-color: var(--dark-border);
            border-color: var(--primary-color);
        }

        .back-button {
            margin-bottom: 2rem;
        }

        .error {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .success-message {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--success);
        }

        .error-message {
            background-color: rgba(185, 28, 28, 0.1);
            color: var(--danger);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--danger);
        }

        .password-requirements {
            background-color: var(--dark-element);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            font-size: 0.8rem;
        }

        .password-requirements h4 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .password-requirements ul {
            list-style-type: none;
            padding: 0;
        }

        .password-requirements li {
            color: var(--gray-text);
            margin-bottom: 0.25rem;
            padding-left: 1rem;
            position: relative;
        }

        .password-requirements li:before {
            content: "•";
            color: var(--primary-color);
            position: absolute;
            left: 0;
        }

        .admin-badge {
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Retour au Dashboard
            </a>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="header">
                <div class="admin-badge">
                    <i class="fas fa-user-shield"></i>
                    CRÉATION ADMIN
                </div>
                <h1>Créer un compte Admin</h1>
                <p>Créez un nouveau compte administrateur pour votre plateforme</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Erreurs détectées :</strong>
                    <ul style="margin-top: 0.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('users.store-admin') }}">
                @csrf

                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user"></i>
                        Nom complet
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autocomplete="name" 
                           placeholder="Entrez le nom complet">
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Adresse email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           placeholder="admin@exemple.com">
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Mot de passe
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           autocomplete="new-password" 
                           placeholder="Créez un mot de passe sécurisé">
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock"></i>
                        Confirmer le mot de passe
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password" 
                           placeholder="Confirmez le mot de passe">
                    @error('password_confirmation')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Requirements -->
                <div class="password-requirements">
                    <h4><i class="fas fa-info-circle"></i> Exigences du mot de passe</h4>
                    <ul>
                        <li>Au moins 8 caractères</li>
                        <li>Une lettre majuscule et une minuscule</li>
                        <li>Au moins un chiffre</li>
                        <li>Au moins un caractère spécial</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Créer le compte Admin
                </button>
            </form>
        </div>
    </div>

    <script>
        // Form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            // Add real-time validation feedback
            confirmPasswordInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    this.style.borderColor = 'var(--danger)';
                } else {
                    this.style.borderColor = 'var(--success)';
                }
            });
        });
    </script>
</body>
</html>