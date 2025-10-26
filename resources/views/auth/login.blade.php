<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Import Inter font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Animate.css for fadeIn animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        /* Dark Theme CSS */
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
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            --hover-bg: #4b4b4b;
            --error-color: #ef4444;
            --success-color: #10b981;
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

        img {
            max-width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .min-h-screen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background-color: var(--dark-bg);
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: var(--shadow);
            animation: fadeIn 0.5s ease-in-out;
        }

        .title {
            font-size: 1.75rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--light-text);
        }

        .session-message {
            background-color: var(--gray-bg);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
            font-size: 0.875rem;
        }

        .session-message.text-red-500 {
            color: var(--error-color);
            background-color: rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--light-text);
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--gray-bg);
            border: 1px solid var(--gray-bg);
            border-radius: 8px;
            color: var(--light-text);
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 181, 173, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem; /* Added spacing between form groups */
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            margin-bottom: 1.5rem; /* Added spacing below form-footer */
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: var(--light-text);
        }

        .checkbox-label input {
            margin-right: 0.5rem;
            accent-color: var(--primary-color);
        }

        .forgot-password {
            color: var(--primary-color);
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        /* .forgot-password:hover {
            color:white;
        } */

        .login-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: var(--light-text);
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.2s ease;
        }

        /* .login-btn:hover {
            background-color: #16a29f;
        } */

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: var(--gray-text);
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: var(--gray-text);
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .social-btn-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem;
            background-color: var(--gray-bg);
            color: var(--light-text);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            font-size: 0.875rem;
            text-decoration: none;
            transition: transform 0.3s ease, background-color 0.2s ease;
        }

        .social-btn svg {
            width: 24px;
            height: 24px;
            margin-right: 0.5rem;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            background-color: var(--hover-bg);
        }

        .register-link {
            display: block;
            text-align: center;
            color: var(--primary-color);
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s ease;
            margin-top: 1rem;
        }

        /* .register-link:hover {
            color: #2eccfa;
        } */

        /* Animation keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center relative px-0">
        <div class="login-card animate__animated animate__fadeIn">
            <!-- Titre -->
            <h2 class="title">Connexion</h2>

         

            <!-- Formulaire de connexion classique -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="input-label">Email</label>
                    <input 
                        id="email" 
                        class="input-field" 
                        type="email" 
                        name="email" 
                        placeholder="example@gmail.com" 
                        value="{{ old('email') }}"
                        required 
                        autofocus 
                        autocomplete="username" 
                    />
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="input-label">Mot de passe</label>
                    <input 
                        id="password" 
                        class="input-field" 
                        type="password" 
                        name="password" 
                        placeholder="••••••••" 
                        required 
                        autocomplete="current-password" 
                    />
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <label class="checkbox-label">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember" 
                            {{ old('remember') ? 'checked' : '' }}
                        />
                        <span>Se souvenir de moi</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a 
                            class="forgot-password" 
                            href="{{ route('password.request') }}" 
                            aria-label="Mot de passe oublié ?"
                        >
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- reCAPTCHA -->
                <div class="form-group">
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="login-btn">
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- Séparateur -->
            <div class="divider">
                Ou
            </div>

            <!-- Boutons de connexion sociale -->
            <div class="social-btn-container">
                <!-- Connexion avec Google -->
                <a 
                    href="{{ route('socialite.redirect', 'google') }}" 
                    class="social-btn" 
                    aria-label="Connexion avec Google"
                >
                    <svg class="w-6 h-6" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M533.5 278.4c0-17.7-1.6-35-4.7-51.6H272v97.8h147.1c-6.4 34.8-25.6 64.2-54.8 83.9v69.7h88.6c51.9-47.8 80.6-118.3 80.6-199.8z"/>
                        <path fill="#34A853" d="M272 544.3c73.5 0 135.3-24.3 180.4-65.8l-88.6-69.7c-24.6 16.6-56 26.4-91.8 26.4-70.7 0-130.6-47.7-152-111.6H29.7v70.3C74.4 482.3 167.2 544.3 272 544.3z"/>
                        <path fill="#FBBC04" d="M120 323.6c-10.8-32-10.8-66.7 0-98.7V154.6H29.7c-36.4 72.4-36.4 157.3 0 229.7L120 323.6z"/>
                        <path fill="#EA4335" d="M272 107.2c38.6-.6 75.5 13.7 103.8 39.2l77.4-77.4C404.5 24.6 340.7-.2 272 0 167.2 0 74.4 62 29.7 154.6l90.3 70.3c21.4-63.9 81.3-111.6 152-111.7z"/>
                    </svg>
                    Connexion avec Google
                </a>

                <!-- Connexion avec Facebook -->
                <a 
                    href="{{ route('socialite.redirect', 'facebook') }}" 
                    class="social-btn" 
                    aria-label="Connexion avec Facebook"
                >
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22.676 0H1.326C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.326 24h11.497v-9.294H9.691v-3.622h3.132V8.413c0-3.1 1.893-4.788 4.658-4.788 1.325 0 2.464.099 2.795.143v3.24h-1.918c-1.504 0-1.796.715-1.796 1.763v2.311h3.592l-.468 3.622h-3.124V24h6.127C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.676 0z"/>
                    </svg>
                    Connexion avec Facebook
                </a>
            </div>

            <!-- Lien vers l'inscription -->
            <a href="{{ route('register') }}" class="register-link">
                Pas de compte ? S'inscrire
            </a>
        </div>
    </div>
</body>
</html>