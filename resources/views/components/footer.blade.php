<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Variables CSS pour les couleurs */
        :root {
            @php
                $settings = App\Models\Setting::first();
                $primaryColor = $settings->primary_color ?? '#1EB5AD';
            @endphp
            --primary-color: {{ $primaryColor }};
            --darker-bg: #111315;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
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
        }

        /* Pied de page */
        .footer {
            background-color: var(--darker-bg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            text-align: center;
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .footer-social .social-link {
            color: var(--light-text);
            font-size: 1.5rem;
            transition: color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .footer-social .social-link:hover {
            color: var(--primary-color);
            transform: scale(1.2);
        }

        .footer-text {
            color: var(--gray-text);
            font-size: 0.875rem;
            margin-top: 1rem;
        }

        /* Ajustements responsifs */
        @media (max-width: 768px) {
            .footer-social {
                gap: 1rem;
            }

            .footer-social .social-link {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .footer-social {
                gap: 0.75rem;
            }

            .footer-social .social-link {
                font-size: 1.1rem;
            }

            .footer-text {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="footer-social">
            @php
                $settings = App\Models\Setting::first();
            @endphp
            @if ($settings && $settings->facebook_url)
                <a href="{{ $settings->facebook_url }}" target="_blank" class="social-link"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if ($settings && $settings->youtube_url)
                <a href="{{ $settings->youtube_url }}" target="_blank" class="social-link"><i class="fab fa-youtube"></i></a>
            @endif
            @if ($settings && $settings->instagram_url)
                <a href="{{ $settings->instagram_url }}" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a>
            @endif
            @if ($settings && $settings->linkedin_url)
                <a href="{{ $settings->linkedin_url }}" target="_blank" class="social-link"><i class="fab fa-linkedin-in"></i></a>
            @endif
            @if ($settings && $settings->email)
                <a href="mailto:{{ $settings->email }}" class="social-link"><i class="fas fa-envelope"></i></a>
            @endif
        </div>
        <p class="footer-text">© 2025 Business+ Talk. Tous droits réservés.</p>
    </footer>
</body>
</html>