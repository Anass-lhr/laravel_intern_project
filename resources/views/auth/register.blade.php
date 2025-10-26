<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inscription à BUSINESS+ : Créez votre compte pour accéder à des podcasts, formations et masterclasses exclusives.">
    <meta name="keywords" content="affaire, inscription, register, podcasts, formations">
    <title>BUSINESS+ - Inscription</title>
    <!-- Animate.css for animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- Poppins font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&display=swap" rel="stylesheet">
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
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            --hover-bg: #4b4b4b;
            --error-color: #ef4444;
            --success-color: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--darker-bg) 100%);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--light-text);
            overflow-x: hidden;
            background-color: var(--darker-bg);
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://via.placeholder.com/1920x1080?text=Business+Background') no-repeat center/cover;
            opacity: 0.1;
            z-index: 1;
            background-attachment: fixed;
        }

        .register-card {
          
            z-index: 2;
            background-color: var(--darker-bg);
            box-shadow: var(--shadow-light);
            border-radius: 15px;
            width: 100%;
            max-width: 350px;
            padding: 20px; /* Réduction du padding pour mieux intégrer le titre */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .title {
            color: var(--light-text);
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 15px; /* Réduction de la marge pour rapprocher du formulaire */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--light-text);
        }

        .input-field {
            background-color: var(--gray-bg);
            color: var(--light-text);
            border: 2px solid var(--gray-bg);
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-size: 14px;
            margin-bottom: 20px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .input-field:focus,
        .input-field.filled {
            outline: none;
            border-color: color-mix(in srgb, var(--primary-color) 90%, #000000);
            box-shadow: 0 0 10px rgba(30, 181, 173, 0.3);
            background-color: #ffffff;
            color: #000000;
        }

        .input-field::placeholder {
            color: var(--gray-text);
            opacity: 0.8;
        }

        .register-btn {
            background: var(--primary-color);
            color: #000000;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .register-btn:hover {
            transform: translateY(-3px);
            background-color: color-mix(in srgb, var(--primary-color) 90%, #ffffff);
        }

        .social-btn {
            background: var(--gray-bg);
            border: 2px solid var(--primary-color);
            color: var(--light-text);
            font-weight: 500;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            margin-bottom: 15px;
            transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            background: color-mix(in srgb, var(--gray-bg) 90%, #ffffff);
            box-shadow: var(--shadow-light);
        }

        .social-btn svg {
            margin-right: 10px;
            width: 20px;
            height: 20px;
        }

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

        .link {
            color: var(--light-text);
            font-size: 13px;
            text-align: center;
            display: block;
            margin-top: 15px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .link:hover {
            color: var(--primary-color);
            text-shadow: 0 0 5px rgba(30, 181, 173, 0.5);
        }

       .error-message {
    color: #ff5555;
    font-size: 12px;
    margin-top: 5px;
    text-align: left;
    font-weight: 400;
}

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="register-card animate_animated animate_fadeIn">
        <h2 class="title">Inscription</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="input-label">{{ __('Nom') }}</label>
                <input id="name" class="input-field" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Votre nom"/>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="email" class="input-label">{{ __('Email') }}</label>
                <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="example@gmail.com"/>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="password" class="input-label">{{ __('Mot de passe') }}</label>
                <input id="password" class="input-field" type="password" name="password" required autocomplete="new-password" placeholder="••••••••"/>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
    <label for="password_confirmation" class="input-label">{{ __('Confirmer le mot de passe') }}</label>
    <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"/>
    @error('password_confirmed')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>

            <!-- reCAPTCHA -->
            <div class="mt-4">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
            @error('g-recaptcha-response')
                        <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="register-btn">
                    {{ __("S'inscrire") }}
                </button>
            </div>
        </form>

        <div class="divider">
            Ou
        </div>

        <div>
            <div>
                <a href="{{ route('socialite.redirect', 'google') }}"
                   class="social-btn"
                   aria-label="Connexion avec Google">
                    <svg class="w-5 h-5" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M533.5 278.4c0-17.7-1.6-35-4.7-51.6H272v97.8h147.1c-6.4 34.8-25.6 64.2-54.8 83.9v69.7h88.6c51.9-47.8 80.6-118.3 80.6-199.8z"/>
                        <path fill="#34A853" d="M272 544.3c73.5 0 135.3-24.3 180.4-65.8l-88.6-69.7c-24.6 16.6-56 26.4-91.8 26.4-70.7 0-130.6-47.7-152-111.6H29.7v70.3C74.4 482.3 167.2 544.3 272 544.3z"/>
                        <path fill="#FBBC04" d="M120 323.6c-10.8-32-10.8-66.7 0-98.7V154.6H29.7c-36.4 72.4-36.4 157.3 0 229.7L120 323.6z"/>
                        <path fill="#EA4335" d="M272 107.2c38.6-.6 75.5 13.7 103.8 39.2l77.4-77.4C404.5 24.6 340.7-.2 272 0 167.2 0 74.4 62 29.7 154.6l90.3 70.3c21.4-63.9 81.3-111.6 152-111.7z"/>
                    </svg>
                    Connexion avec Google
                </a>
            </div>

            <div>
                <a href="{{ route('socialite.redirect', 'facebook') }}"
                   class="social-btn"
                   aria-label="Connexion avec Facebook">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22.676 0H1.326C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.326 24h11.497v-9.294H9.691v-3.622h3.132V8.413c0-3.1 1.893-4.788 4.658-4.788 1.325 0 2.464.099 2.795.143v3.24h-1.918c-1.504 0-1.796.715-1.796 1.763v2.311h3.592l-.468 3.622h-3.124V24h6.127C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.676 0z"/>
                    </svg>
                    Connexion avec Facebook
                </a>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a class="link" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }
            });
        });
    </script>
</body>
</html>
