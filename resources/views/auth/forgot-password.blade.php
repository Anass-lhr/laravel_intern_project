
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Forgot Password') }} - Business+ Talk</title>
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        body {
            background-color: var(--dark-bg);
            color: var(--light-text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        /* Content Area */
        .content-area {
            padding: 2rem;
            max-width: 600px;
            width: 100%;
        }

        /* Form Styles */
        .form-container {
            background-color: var(--gray-bg);
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--light-text);
        }

        .form-description {
            font-size: 0.875rem;
            color: var(--gray-text);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--light-text);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 0.5rem;
            background-color: var(--darker-bg);
            color: var(--light-text);
            font-size: 1rem;
            outline: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease, transform 0.2s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 12px var(--primary-color);
            transform: scale(1.01);
        }

        .form-input::placeholder {
            color: var(--gray-text);
            opacity: 0.7;
        }

        .form-error {
            color: #ff6b6b;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .session-status {
            background-color: rgba(30, 181, 173, 0.1);
            color: var(--primary-color);
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        /* Button Styles */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
        }

        .btn-primary:hover {
            background-color:var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-area {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .form-title {
                font-size: 1.25rem;
            }

            .form-description {
                font-size: 0.8rem;
            }

            .form-label {
                font-size: 0.8rem;
            }

            .form-input {
                padding: 0.6rem;
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Content Area -->
    <div class="content-area">
        <div class="form-container">
            <h2 class="form-title">{{ __('Forgot Your Password?') }}</h2>
            <p class="form-description">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif
            
            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('Enter your email') }}">
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">{{ __('Email Password Reset Link') }}</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
