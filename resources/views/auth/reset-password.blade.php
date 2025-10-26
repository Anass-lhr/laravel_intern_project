<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Business+ Talk</title>
    <style>
        :root {
            --primary-color: #1EB5AD; /* Teal color from your logo */
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--darker-bg) 100%);
        }
        
        .container {
            width: 100%;
            max-width: 450px;
        }
        
        .card {
            background-color: var(--gray-bg);
            border-radius: 0.75rem;
            overflow: hidden;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }
        
        .card-header {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 0.5rem;
        }
        
        .card-subtitle {
            font-size: 0.9rem;
            color: var(--gray-text);
        }
        
        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--light-text);
        }
        
        .text-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--darker-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            color: var(--light-text);
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }
        
        .text-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(30, 181, 173, 0.3);
        }
        
        .input-error {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            margin-bottom: 0.75rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }
        
        .primary-button {
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .primary-button:hover {
            background-color: #16a39a;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(30, 181, 173, 0.3);
        }
        
        .back-link {
            color: var(--gray-text);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-link:hover {
            color: var(--primary-color);
        }
        
        @media (max-width: 576px) {
            .card {
                padding: 1.5rem;
            }
            
            .card-title {
                font-size: 1.25rem;
            }
            
            .text-input {
                padding: 0.6rem 0.75rem;
                font-size: 0.9rem;
            }
            
            .primary-button {
                padding: 0.6rem 1.2rem;
                font-size: 0.85rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Reset Password</h2>
                <p class="card-subtitle">Create a new secure password for your account</p>
            </div>
            
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="input-label">Email</label>
                    <input id="email" class="text-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    @if($errors->get('email'))
                        <div class="input-error">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="input-label">Password</label>
                    <input id="password" class="text-input" type="password" name="password" required autocomplete="new-password">
                    @if($errors->get('password'))
                        <div class="input-error">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                
                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="input-label">Confirm Password</label>
                    <input id="password_confirmation" class="text-input" type="password" name="password_confirmation" required autocomplete="new-password">
                    @if($errors->get('password_confirmation'))
                        <div class="input-error">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
                
                <div class="btn-container">
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="fas fa-arrow-left"></i> Back to login
                    </a>
                    <button type="submit" class="primary-button">
                        Reset Password <i class="fas fa-lock"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>