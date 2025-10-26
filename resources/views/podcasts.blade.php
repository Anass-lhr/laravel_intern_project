<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BUSINESS+ : Découvrez nos podcasts vidéo exclusifs pour élever votre business.">
    <meta name="keywords" content="business, podcasts, vidéos, YouTube, stratégies digitales">
    <title>BUSINESS+ - Podcasts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
   
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-teal': '#00B7C3',
                        'primary-black': '#0F0F0F',
                        'dark-gray': '#1A1A1A',
                        'medium-gray': '#333333',
                        'light-gray': '#CCCCCC',
                        'accent-white': '#FFFFFF',
                        'accent-red': '#E50914',
                        'cyan-glow': '#00CED1',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'pulse-slow': 'pulse 1.8s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 4s ease-in-out infinite'
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-15px)' } },
                        pulse: { '0%, 100%': { opacity: 1, transform: 'scale(1)' }, '50%': { opacity: .6, transform: 'scale(1.1)' } }
                    }
                }
            }
        }
    </script>
        <style>
            .glow-effect-teal { box-shadow: 0 0 15px rgba(0, 183, 195, 0.4); }
.hover-glow-teal:hover { box-shadow: 0 0 25px rgba(0, 183, 195, 0.7); transform: translateY(-3px); }
.card-hover { transition: all 0.35s ease; border: 1px solid #333333; }
.card-hover:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3); border-color:var(--primary-color); }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
         /* Variables CSS unifiées pour les couleurs */
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

/* En-tête */
.header {
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    background-color: var(--darker-bg);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-logo-container {
    flex: 0 0 auto;
    display: none;
}

.header-logo {
    max-height: 50px;
    width: auto;
    margin: 0 auto;
}

.header-center {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 0 0 auto;
}

.search-container {
    position: relative;
    width: 400px;
    max-width: 100%;
    transition: width 0.3s ease-in-out, transform 0.2s ease;
}

.search-container:hover {
    width: 420px;
    transform: scale(1.02);
}

.search-input {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 1.2rem;
    border: none;
    border-radius: 1rem;
    background-color: var(--gray-bg);
    color: var(--light-text);
    font-size: 1rem;
    outline: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
}

.search-input:focus {
    background-color: var(--darker-bg);
    box-shadow: 0 0 12px var(--primary-color);
    transform: scale(1.01);
}

.search-input::placeholder {
    color: var(--gray-text);
    opacity: 0.7;
    font-style: italic;
}

.search-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-text);
    font-size: 1.2rem;
    transition: color 0.3s ease, transform 0.2s ease;
}

.search-container:hover .search-icon {
    color: var(--primary-color);
    transform: translateY(-50%) scale(1.1);
}

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

.btn-outline {
    background: transparent;
    color: var(--light-text);
    border: 2px solid rgba(255, 255, 255, 0.15);
}

.btn-outline:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px var(--primary-color);
}

.btn-primary {
    background-color: var(--primary-color);
    color: var(--light-text);
    border: none;
}

.btn-primary:hover {
    background-color: color-mix(in srgb, var(--primary-color) 80%, #000000);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px var(--primary-color);
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--primary-color);
    transition: transform 0.3s ease;
}

.initial-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--gray-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    color: var(--light-text);
    text-transform: uppercase;
}

.user-avatar:hover, .initial-avatar:hover {
    transform: scale(1.1);
}

.user-name {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--light-text);
    transition: color 0.3s ease;
}

.user-profile:hover .user-name {
    color: var(--primary-color);
}

.hidden {
    display: none;
}

.auth-buttons a {
    margin-right: 1rem;
}

.auth-buttons a:last-child {
    margin-right: 0;
}

/* Barre latérale */
/* Sidebar */
.sidebar {
    width: 280px;
    background-color: var(--darker-bg);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    padding: 2rem 0;
    position: fixed; /* Keep fixed positioning */
    height: 100vh;
    overflow-y: auto;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.4);
    display: flex;
    flex-direction: column;
    transition: width 0.3s ease;
    z-index: 10; /* Ensure it stays above other content */
}

.logo-container {
    padding: 0 2rem 2rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 2rem;
    text-align: center;
}

.logo {
    max-width: 200px;
    height: auto;
    margin: 0 auto;
}

.sidebar-menu {
    flex-grow: 1;
    list-style: none;
    padding: 0 0.75rem;
}

.sidebar-menu li {
    margin-bottom: 0.75rem;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: var(--gray-text);
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    position: relative;
}

.sidebar-menu a:hover {
    color: var(--light-text);
    background-color: color-mix(in srgb, var(--primary-color) 15%, transparent);
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.sidebar-menu a.active {
    color: var(--light-text);
    border-left: 4px solid var(--primary-color);
    background: linear-gradient(90deg, var(--primary-color), rgba(0, 0, 0, 0.1));
    transform: scale(1.03);
    border-radius: 0.75rem;
}

.sidebar-menu a i {
    color: var(--light-text);
    margin-right: 1rem;
    font-size: 1.5rem;
    transition: transform 0.3s ease;
}

.sidebar-menu a:hover i {
    transform: scale(1.2);
}

/* Main Content */
.main-content {
    margin-left: 280px; /* Match default sidebar width */
    padding: 2rem;
    transition: margin-left 0.3s ease;
    min-height: calc(100vh - 70px - 100px); /* Adjust for header and footer */
}

/* Responsive Adjustments */
@media (min-width: 769px) and (max-width: 992px) {
    .sidebar {
        width: 80px;
        padding: 1.5rem 0;
    }
    .logo-container {
        padding: 0 1rem 1.5rem;
    }
    .logo {
        max-width: 60px;
    }
    .sidebar-menu a {
        padding: 0.8rem;
        font-size: 1rem;
        justify-content: center;
    }
    .sidebar-menu a i {
        margin-right: 0;
        font-size: 1.2rem;
    }
    .sidebar-menu a span {
        display: none;
    }
    .main-content {
        margin-left: 80px; /* Match sidebar width */
        padding: 1.5rem;
        align-items: center; /* Ensure centering */
    }
}

@media (min-width: 577px) and (max-width: 768px) {
    .sidebar {
        width: 60px;
        padding: 1rem 0;
    }
    .logo-container {
        padding: 0 1rem 1rem;
    }
    .logo {
        max-width: 50px;
    }
    .sidebar-menu a {
        padding: 0.6rem;
        font-size: 0.9rem;
        justify-content: center;
    }
    .sidebar-menu a i {
        margin-right: 0;
        font-size: 1.1rem;
    }
    .sidebar-menu a span {
        display: none;
    }
    .main-content {
        margin-left: 60px; /* Match sidebar width */
        padding: 1rem;
        align-items: center; /* Ensure centering */
    }
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

/* Contenu principal */
.main-content {
    margin-left: 280px;
    padding: 2rem;
    transition: margin-left 0.3s ease;
    min-height: calc(100vh - 70px - 100px); /* Ajuster pour header (70px) et footer (est. 100px) */
}

/* Titre des podcasts */
.podcast-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--light-text);
    text-align: center;
    margin-bottom: 2rem;
    animation: fadeIn 0.5s ease-out;
    width: 100%; /* Ensure it takes full width for centering */
}

.plus-square {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: var(--primary-color);
    color: #FFFFFF;
    width: 28px;
    height: 28px;
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 1;
    box-shadow: 0 0 10px var(--primary-color);
}

.user-profile-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.user-profile-container:hover {
    transform: scale(1.05);
}

.video-card {
    border: 1px solid #333333;
    padding: 10px;
    margin: 10px 0; /* Remove horizontal margin to allow centering */
    width: 100%;
    max-width: 600px; /* Optional: Limit width for better centering */
    text-align: center;
    box-sizing: border-box; /* Ensure padding doesn't affect width */
}
.video-card img {
    width: 100%;
    height: auto; /* Let the height adjust naturally */
    object-fit: cover; /* Use 'cover' to fill the container, cropping if necessary */
    border-radius: 8px 8px 0 0;
    aspect-ratio: 16 / 9; /* Enforce a consistent aspect ratio (adjust as needed) */
}

.back-btn {
    background-color: #333333;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    font-weight: 500;
    border-radius: 5px;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
}

.back-btn:hover {
    background-color: #444444;
}

.video-player-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 20px;
    background-color: #1A1A1A;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

#video-player iframe {
    width: 100%;
    max-width: 1280px;
    height: 500px;
    border: none;
    border-radius: 8px;
}

#video-info {
    max-width: 1280px;
    margin: 30px auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #FFFFFF;
}

#video-info h3 {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 0;
}

.video-actions {
    display: flex;
    gap: 20px;
}

.video-actions button {
    background: none;
    border: none;
    color: #AAAAAA;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.3s;
}

.video-actions button:hover {
    color: #FFFFFF;
}

.video-actions button.liked {
    color: var(--primary-color);
}

#bio-container {
    max-width: 1280px;
    margin: 20px auto;
    padding: 20px;
    background-color: #1A1A1A;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    color: #FFFFFF;
}

#bio-container p {
    color: #CCCCCC;
    font-size: 0.9rem;
    line-height: 1.6;
    white-space: pre-wrap;
}

#bio-container .video-stats {
    color: #AAAAAA;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

#bio-container .description-container {
    position: relative;
}

#bio-container .description-text {
    transition: max-height 0.3s ease;
    overflow: hidden;
}

#bio-container .description-text.collapsed {
    max-height: 3.6rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

#bio-container .description-text.expanded {
    max-height: none;
    display: block;
}

#bio-container .toggle-btn {
    background: none;
    border: none;
    color: #AAAAAA;
    cursor: pointer;
    font-size: 0.9rem;
    margin-top: 5px;
    padding: 0;
    display: inline;
    font-weight: 500;
    text-transform: uppercase;
    transition: color 0.3s ease;
}

#bio-container .toggle-btn:hover {
    color: #FFFFFF;
}

#bio-container .toggle-btn::before {
    content: '...';
    color: #AAAAAA;
    margin-right: 4px;
}

#bio-container .toggle-btn.expanded::before {
    content: '';
    margin-right: 0;
}

.description-container {
    position: relative;
}

.description-text {
    transition: max-height 0.3s ease;
    overflow: hidden;
}

.description-text.collapsed {
    max-height: 3.6rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.description-text.expanded {
    max-height: none;
    display: block;
}

.toggle-btn {
    background: none;
    border: none;
    color: #AAAAAA;
    cursor: pointer;
    font-size: 0.9rem;
    margin-top: 5px;
    padding: 0;
    display: inline;
    font-weight: 500;
    text-transform: uppercase;
    transition: color 0.3s ease;
}

.toggle-btn:hover {
    color: #FFFFFF;
}

.toggle-btn::before {
    content: '...';
    color: #AAAAAA;
    margin-right: 4px;
}

.toggle-btn.expanded::before {
    content: '';
    margin-right: 0;
}

#comment-form {
    max-width: 1280px;
    margin: 20px auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
    background-color: #1A1A1A;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

#comment-form textarea {
    width: 100%;
    padding: 12px;
    background-color: #222222;
    border: 1px solid #333333;
    color: #FFFFFF;
    resize: none;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: border-color 0.3s ease;
}

#comment-form textarea:focus {
    border-color: var(--primary-color);
    outline: none;
}

.comment-form-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

#comment-form button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
}

#comment-form button:hover {
    background-color: #1A1D21;
}

#comment-form .cancel-btn {
    background-color: #333333;
}

#comment-form .cancel-btn:hover {
    background-color: #444444;
}

#google-signin-btn {
    background-color: #4285F4;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
}

#google-signin-btn:hover {
    background-color: #3578E5;
}

.comment-form .text-center {
    padding: 20px;
    background-color: #222222;
    border-radius: 8px;
    border: 1px solid #333333;
}

.comment-form .text-center p {
    font-size: 1rem;
    color: #CCCCCC;
    margin-bottom: 16px;
}

.comment-form #google-signin-btn {
    background-color: #4285F4;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
}

.comment-form #google-signin-btn:hover {
    background-color: #3578E5;
}

#comments-container {
    max-width: 1280px;
    margin: 20px auto;
    padding: 20px;
    border-top: 2px solid var(--primary-color);
}

.comment {
    display: flex;
    gap: 15px;
    padding: 15px;
    margin-bottom: 15px;
    background-color: #1A1A1A;
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    align-items: flex-start;
}

.comment.reply {
    margin-left: 40px;
    border-left: 2px solid var(--primary-color);
    padding-left: 15px;
}

.comment:hover {
    transform: translateY(-3px);
}

.comment-avatar-container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
}

.comment-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.initial-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #2a2a2a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    color: #ffffff;
    text-transform: uppercase;
}

.comment-content {
    flex: 1;
    position: relative;
    display: flex;
    flex-direction: column;
}

.comment-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}

.comment-author {
    font-weight: bold;
    color: #FFFFFF;
    font-size: 1rem;
    margin: 0;
}

.comment-text {
    color: #CCCCCC;
    font-size: 0.9rem;
    line-height: 1.4;
}

.comment-meta {
    color: #AAAAAA;
    font-size: 0.8rem;
    margin-top: 5px;
}

.comment-actions {
    margin-top: 5px;
    display: flex;
    gap: 10px;
}

.comment-actions button {
    background: none;
    border: none;
    color: #AAAAAA;
    cursor: pointer;
    font-size: 0.8rem;
    transition: color 0.3s ease;
}

.comment-actions button:hover {
    color: #FFFFFF;
}

.comment-actions .delete-btn:hover {
    color: #E50914;
}

.comment-actions-wrapper {
    position: absolute;
    top: 0;
    right: 0;
    display: flex;
    align-items: center;
}

.more-actions-btn {
    padding: 2px 5px;
    margin-right: 5px;
    background: none;
    border: none;
    color: #AAAAAA;
    cursor: pointer;
}

.dropdown-menu {
    transition: all 0.2s ease;
}

.dropdown-item {
    font-size: 14px;
}

.dropdown-item:hover {
    background-color: #555 !important;
}

.dropdown-item.report-btn,
.dropdown-item.delete-btn {
    color: rgb(250, 245, 245) !important;
    background-color: #ff0000;
    border: none;
    padding: 8px 12px;
    text-align: left;
    width: 100%;
    cursor: pointer;
    font-size: 14px;
    margin: 0;
    line-height: 1;
}

.dropdown-item.report-btn:hover,
.dropdown-item.delete-btn:hover {
    background-color: #e60000 !important;
}

.report-btn {
    background-color: #e53e3e;
    color: #ffffff;
    padding: 4px 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 600;
    margin-left: 8px;
}

.report-btn:hover {
    background-color: #c53030;
}

.reply-btn {
    color: var(--primary-color);
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    background: none;
    border: none;
    padding: 0;
    transition: color 0.3s ease;
}

.reply-btn:hover {
    color: var(--primary-color);
}

.reply-btn::before {
    content: '▼';
    margin-right: 4px;
    font-size: 0.7rem;
    color: var(--primary-color);
    transition: transform 0.3s ease, color 0.3s ease;
}

.reply-btn.active::before {
    transform: rotate(180deg);
}

.reply-btn:hover::before {
    color: rgb(66, 121, 158);
}

.reply-form {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.reply-form textarea {
    width: 100%;
    padding: 8px;
    background-color: #222222;
    border: 1px solid #333333;
    color: #FFFFFF;
    resize: none;
    border-radius: 5px;
    font-size: 0.9rem;
}

.reply-form textarea:focus {
    border-color: var(--primary-color);
    outline: none;
}

.reply-form-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.reply-form button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 0.9rem;
}

.reply-form button:hover {
    background-color: #1A1D21;
}

.reply-form .cancel-reply-btn {
    background-color: #333333;
}

.reply-form .cancel-reply-btn:hover {
    background-color: #444444;
}

.error-message {
    color: #E50914;
    text-align: center;
    padding: 20px;
    font-size: 1.1rem;
    background-color: #1A1A1A;
    border: 1px solid #E50914;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    margin: 20px auto;
    max-width: 1280px;
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease-out;
}

.error-message.temporary {
    animation: pulse-slow 1.8s ease-in-out infinite;
}

.pagination-container {
    max-width: 1280px;
    margin: 30px auto;
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.pagination-btn {
    background-color: #333333;
    color: #FFFFFF;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
}

.pagination-btn:hover {
    background-color: #444444;
}

.pagination-btn.active {
    background-color: #E50914;
    font-weight: bold;
}

.pagination-btn:disabled {
    background-color: #222222;
    color: #666666;
    cursor: not-allowed;
}

.replies-toggle {
    color: #1DA1F2;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    margin-top: 8px;
    display: inline-flex;
    align-items: center;
    transition: color 0.3s ease;
}

.replies-toggle:hover {
    color: #0C87D8;
}

.replies-toggle::before {
    content: '▼';
    margin-right: 6px;
    font-size: 0.7rem;
    color: #1DA1F2;
    transition: transform 0.3s ease, color 0.3s ease;
}

.replies-toggle:hover::before {
    color: #0C87D8;
}

.replies-toggle.collapsed::before {
    content: '▼';
    transform: rotate(0deg);
}

.replies-toggle:not(.collapsed)::before {
    transform: rotate(180deg);
}

.replies-toggle span {
    font-weight: 700;
    margin-right: 4px;
}

.replies-container {
    display: none;
    margin-top: 10px;
    margin-left: 40px;
}

.replies-container.visible {
    display: block;
}

.from-youtube {
    display: inline-block;
    background-color: #E50914;
    color: #FFFFFF;
    font-size: 0.7rem;
    padding: 2px 6px;
    border-radius: 3px;
    margin-left: 8px;
    vertical-align: middle;
}

.replies-toggle {
    cursor: pointer;
    color: #007bff;
    margin-top: 5px;
}

.replies-toggle:hover {
    text-decoration: underline;
}

.replies-toggle.active {
    color: #0056b3;
}

.comment-deleted {
    opacity: 0.5;
    transition: all 0.5s ease;
    transform: translateX(30px);
}

.delete-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.delete-btn {
    color: #e53e3e;
    font-weight: 500;
    transition: all 0.2s ease;
}

.delete-btn:hover:not(:disabled) {
    background-color: rgba(229, 62, 62, 0.1);
    border-radius: 4px;
}

.confirm-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #1a1a1a;
    border: 1px solid #333;
    border-radius: 8px;
    padding: 20px;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    max-width: 400px;
    width: 90%;
}

.confirm-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 999;
}

.confirm-modal-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: #fff;
}

.confirm-modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.confirm-modal-buttons button {
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.confirm-modal-cancel {
    background: transparent;
    border: 1px solid #555;
    color: #ddd;
}

.confirm-modal-confirm {
    background: #e53e3e;
    border: none;
    color: white;
}

.confirm-modal-cancel:hover {
    background: rgba(255, 255, 255, 0.1);
}

.confirm-modal-confirm:hover {
    background: #c53030;
}

/* Keyframes */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes pulse-slow {
    0% { transform: scale(1); box-shadow: 0 0 8px rgba(229, 9, 20, 0.7); }
    50% { transform: scale(1.2); box-shadow: 0 0 12px rgba(229, 9, 20, 1); }
    100% { transform: scale(1); box-shadow: 0 0 8px rgba(229, 9, 20, 0.7); }
}





@media (min-width: 401px) and (max-width: 576px) {
    .sidebar {
        width: 0; /* Hide sidebar */
        padding: 0;
        overflow: hidden;
    }
    .logo-container {
        padding: 0;
    }
    .logo {
        display: none;
    }
    .sidebar-menu {
        display: none;
    }
    .main-content {
        margin-left: 0; /* No margin since sidebar is hidden */
        padding: 0.75rem;
        align-items: center; /* Ensure centering */
    }
    .header {
        padding: 0 0.75rem;
    }
    .search-container {
        width: 200px;
    }
    .search-container:hover {
        width: 220px;
    }
    .search-input {
        font-size: 0.9rem;
        padding: 0.6rem 2rem 0.6rem 1rem;
    }
    .search-icon {
        font-size: 1rem;
        right: 0.8rem;
    }
    .user-avatar, .initial-avatar {
        width: 35px;
        height: 35px;
    }
    .user-name {
        font-size: 0.85rem;
    }
    .podcast-title {
        font-size: 1.3rem;
    }
    .video-card {
        margin: 5px 0;
        padding: 5px;
        max-width: 100%; /* Ensure it fits within the centered layout */
    }
    .video-card img {
        height: auto;
        object-fit: cover; /* Ensure the image fills the container */
        aspect-ratio: 16 / 9; /* Maintain aspect ratio */
    }
    #video-player iframe {
        height: auto;
        aspect-ratio: 16 / 9; /* Ensure the video player maintains proportions */
    }
    #video-info h3 {
        font-size: 1.2rem;
    }
    #bio-container p {
        font-size: 0.8rem;
    }
    #comment-form textarea {
        font-size: 0.8rem;
    }
    .comment-author {
        font-size: 0.85rem;
    }
    .comment-text {
        font-size: 0.8rem;
    }
    .comment-meta {
        font-size: 0.75rem;
    }
}

@media (max-width: 400px) {
    .sidebar {
        width: 0; /* Hide sidebar */
        padding: 0;
        overflow: hidden;
    }
    .logo-container {
        padding: 0;
    }
    .logo {
        display: none;
    }
    .sidebar-menu {
        display: none;
    }
    .main-content {
        margin-left: 0; /* Remove margin to center content */
        padding: 0.5rem;
        align-items: center; /* Ensure centering */
    }
    .header {
        padding: 0 0.5rem;
    }
    .search-container {
        width: 150px;
    }
    .search-container:hover {
        width: 160px;
    }
    .search-input {
        font-size: 0.8rem;
        padding: 0.5rem 1.5rem 0.5rem 0.8rem;
    }
    .search-icon {
        font-size: 0.9rem;
        right: 0.6rem;
    }
    .user-avatar, .initial-avatar {
        width: 30px;
        height: 30px;
    }
    .user-name {
        font-size: 0.8rem;
    }
    .podcast-title {
        font-size: 1.2rem;
    }
    .video-card {
        margin: 4px 0;
        padding: 4px;
        max-width: 100%; /* Ensure it fits within the centered layout */
    }
    .video-card img {
        height: auto;
        object-fit: cover; /* Ensure the image fills the container */
        aspect-ratio: 16 / 9; /* Maintain aspect ratio */
    }
    #video-player iframe {
        height: auto;
        aspect-ratio: 16 / 9; /* Ensure the video player maintains proportions */
    }
    #video-info h3 {
        font-size: 1.1rem;
    }
    #bio-container p {
        font-size: 0.75rem;
    }
    #comment-form textarea {
        font-size: 0.75rem;
    }
    #comment-form button {
        padding: 8px 16px;
        font-size: 0.8rem;
    }
    .comment-author {
        font-size: 0.8rem;
    }
    .comment-text {
        font-size: 0.75rem;
    }
    .comment-meta {
        font-size: 0.7rem;
    }
    .comment-actions button {
        font-size: 0.7rem;
    }
    .footer-social {
        gap: 1rem;
    }
    .footer-social .social-link {
        font-size: 1.2rem;
    }
    .footer-text {
        font-size: 0.75rem;
    }
}

@media (max-width: 400px) {
    .sidebar {
        width: 0; /* Hide sidebar */
        padding: 0;
        overflow: hidden;
    }
    .logo-container {
        padding: 0;
    }
    .logo {
        display: none;
    }
    .sidebar-menu {
        display: none;
    }
    .main-content {
        margin-left: 0; /* Remove margin to center content */
        padding: 0.5rem;
        align-items: center; /* Ensure centering */
    }
    .header {
        padding: 0 0.5rem;
    }
    .search-container {
        width: 150px;
    }
    .search-container:hover {
        width: 160px;
    }
    .search-input {
        font-size: 0.8rem;
        padding: 0.5rem 1.5rem 0.5rem 0.8rem;
    }
    .search-icon {
        font-size: 0.9rem;
        right: 0.6rem;
    }
    .user-avatar, .initial-avatar {
        width: 30px;
        height: 30px;
    }
    .user-name {
        font-size: 0.8rem;
    }
    .podcast-title {
        font-size: 1.2rem;
    }
    .video-card {
        margin: 4px 0;
        padding: 4px;
        max-width: 100%; /* Ensure it fits within the centered layout */
    }
    .video-card img {
        height: auto;
    }
    #video-player iframe {
        height: auto;
    }
    #video-info h3 {
        font-size: 1.1rem;
    }
    #bio-container p {
        font-size: 0.75rem;
    }
    #comment-form textarea {
        font-size: 0.75rem;
    }
    #comment-form button {
        padding: 8px 16px;
        font-size: 0.8rem;
    }
    .comment-author {
        font-size: 0.8rem;
    }
    .comment-text {
        font-size: 0.75rem;
    }
    .comment-meta {
        font-size: 0.7rem;
    }
    .comment-actions button {
        font-size: 0.7rem;
    }
    .footer-social {
        gap: 1rem;
    }
    .footer-social .social-link {
        font-size: 1.2rem;
    }
    .footer-text {
        font-size: 0.75rem;
    }
}
/* Adjust padding for main content when video player is active */
main.py-20 {
    padding-top: 2rem; /* Reduced from 5rem (py-20) to 2rem */
    padding-bottom: 2rem;
}

/* Reduce padding on video player container */
.video-player-container {
    padding: 10px; /* Reduced from 20px to 10px */
}

/* Responsive adjustments for smaller screens */
@media (max-width: 576px) {
    main.py-20 {
        padding-top: 1rem; /* Further reduced for smaller screens */
        padding-bottom: 1rem;
    }

    .video-player-container {
        padding: 5px; /* Further reduced for smaller screens */
    }
}
.success-message {
    color: var(--primary-color); /* Utilisation de --primary-color */
    text-align: center;
    padding: 20px;
    font-size: 1.1rem;
    background-color: #1A1A1A;
  
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    margin: 20px auto;
    max-width: 1280px;
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease-out;
}

.success-message.temporary {
    animation: pulse-slow 1.8s ease-in-out infinite;
}

    </style>
</head>
<body class="bg-primary-black text-light-gray font-sans">
   @include('components.sidebar')
   <div class="main-content">
     @include('components.header')
  <main class="py-20 bg-primary-black">
    <div class="container mx-auto px-4">
       @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
    <div class="error-message">
        Vous êtes bloqué et ne pouvez pas interagir avec le contenu. Si vous avez des questions, veuillez nous contacter : <a href="mailto:businessplus@gmail.com" class="text-accent-teal underline ">businessplus@gmail.com</a>.
    </div>
@endif
        
        <h2 class="text-3xl md:text-4xl font-bold mb-16 text-center text-accent-white animate__animated animate__fadeIn">NOS PODCASTS</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10" id="videos-container"></div>
        <div id="pagination-container" class="pagination-container"></div>
        <div id="video-player" class="video-player-container"></div>
        <div id="video-info"></div>
        <div id="bio-container"></div>
        <div id="comment-form" class="comment-form"></div>
        <div id="comments-container"></div>
    </div>
</main>
 @include('components.footer')
</div>

    
<script>
const API_KEY = "AIzaSyAScg-HM7-PlWLZ8HEXx6L-2y--g-6bCUQ";
let videosData = [];
window.videosData = videosData; // Rendre accessible globalement
let currentVideo = null;
let localComments = [];
let currentPage = 1;
window.currentPage = currentPage; // Rendre accessible globalement pour la recherche
const videosPerPage = 9;
let isVideoPlayerActive = false;
let allComments = [];

const currentUser = {
    name: @auth "{{ auth()->user()->name }}" @else null @endauth,
    avatar: @auth 
        @if (auth()->user()->avatar)
            "{{ Storage::url(auth()->user()->avatar) }}"
        @elseif (auth()->user()->provider)
            "https://via.placeholder.com/40"
        @else
            null
        @endif
    @else
        "https://via.placeholder.com/40"
    @endauth,
    avatarInitial: @auth 
        @if (!auth()->user()->avatar && !auth()->user()->provider)
            "{{ substr(auth()->user()->name, 0, 1) }}"
        @else
            null
        @endif
    @else
        null
    @endauth,
    role: @auth "{{ auth()->user()->role }}" @else null @endauth,
    is_active: @auth {{ auth()->user()->is_active ? 'true' : 'false' }} @else null @endauth
};

function getUrlParams() {
    const params = new URLSearchParams(window.location.search);
    const videoId = params.get('videoId');
    const title = decodeURIComponent(params.get('title') || '');
    const description = decodeURIComponent(params.get('description') || '');
    const publishedAt = params.get('publishedAt');
    console.log('URL Parameters after redirect:', { videoId, title, description, publishedAt });
    return { videoId, title, description, publishedAt };
}

function updateUrl(videoId, title, description, publishedAt) {
    const params = new URLSearchParams();
    if (videoId) {
        params.set('videoId', videoId);
        params.set('title', encodeURIComponent(title));
        params.set('description', encodeURIComponent(description));
        params.set('publishedAt', publishedAt);
    }
    const newUrl = `${window.location.pathname}${params.toString() ? '?' + params.toString() : ''}`;
    window.history.pushState({}, '', newUrl);
    console.log('Updated URL:', newUrl);
}

function signIn() {
    console.log("Redirection vers la page de connexion...");
    window.location.href = '/login';
}

function updateSignInStatus() {
    console.log("Mise à jour de l'état de connexion. Utilisateur local :", currentUser.name);
    const commentFormDiv = document.getElementById('comment-form');
    if (!commentFormDiv) {
        console.error("Erreur : Le conteneur #comment-form est introuvable.");
        return;
    }

const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));
    if (currentUser.name) {
        if (isBlocked) {
            commentFormDiv.innerHTML = `
                <textarea id="comment-input" placeholder="Vous êtes bloqué et ne pouvez pas commenter." rows="4" readonly></textarea>
                <div class="comment-form-buttons">
                    <button class="cancel-btn" onclick="document.getElementById('comment-input').value = ''; console.log('Commentaire annulé');" disabled>Annuler</button>
                    <button disabled>Commenter</button>
                </div>
            `;
            const textarea = document.getElementById('comment-input');
            textarea.style.backgroundColor = '#2a2a2a';
            textarea.style.cursor = 'not-allowed';
        } else {
            commentFormDiv.innerHTML = `
                <textarea id="comment-input" placeholder="Ajouter un commentaire..." rows="4"></textarea>
                <div class="comment-form-buttons">
                    <button class="cancel-btn" onclick="document.getElementById('comment-input').value = ''; console.log('Commentaire annulé');">Annuler</button>
                    <button onclick="addComment('${currentVideo?.id || ''}', null)">Commenter</button>
                </div>
            `;
        }
    } else {
        commentFormDiv.innerHTML = `
            <div class="text-center text-light-gray">
                <p class="mb-4">Vous devez être connecté pour laisser un commentaire.</p>
                <a href="/login" class="btn-dynamic bg-[var(--primary-color)] text-accent-white px-4 py-2 rounded-lg">Connexion</a>
            </div>
        `;
    }
}

async function fetchVideos() {
    try {
        console.log("Récupération des informations de la chaîne...");
        
        // Option 1: If you have the channel ID, use it directly
        // const channelId = 'YOUR_CHANNEL_ID_HERE';
        
        // Option 2: Search for the channel by name
        const channelResponse = await fetch(
            `https://www.googleapis.com/youtube/v3/search?part=snippet&q=AbderrazakYousfi&type=channel&key=${API_KEY}`
        );
        
        if (!channelResponse.ok) {
            throw new Error(`Erreur HTTP ${channelResponse.status}: ${channelResponse.statusText}`);
        }
        
        const channelData = await channelResponse.json();
        console.log("Channel search response:", channelData);
        
        if (!channelData.items || channelData.items.length === 0) {
            throw new Error("Impossible de récupérer les informations de la chaîne.");
        }
        
        const channelId = channelData.items[0].id.channelId;
        console.log("Channel ID found:", channelId);
        
        // Get channel details to find the uploads playlist
        const channelDetailsResponse = await fetch(
            `https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id=${channelId}&key=${API_KEY}`
        );
        
        if (!channelDetailsResponse.ok) {
            throw new Error(`Erreur HTTP ${channelDetailsResponse.status}: ${channelDetailsResponse.statusText}`);
        }
        
        const channelDetailsData = await channelDetailsResponse.json();
        console.log("Channel details response:", channelDetailsData);
        
        if (!channelDetailsData.items || channelDetailsData.items.length === 0) {
            throw new Error("Impossible de récupérer les détails de la chaîne.");
        }
        
        const uploadsPlaylistId = channelDetailsData.items[0].contentDetails.relatedPlaylists.uploads;
        console.log("Uploads playlist ID:", uploadsPlaylistId);

        console.log("Récupération des vidéos...");
        let allVideos = [];
        let nextPageToken = '';
        
        do {
            const videosResponse = await fetch(
                `https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=${uploadsPlaylistId}&maxResults=50&key=${API_KEY}&pageToken=${nextPageToken}`
            );
            
            if (!videosResponse.ok) {
                throw new Error(`Erreur HTTP ${videosResponse.status}: ${videosResponse.statusText}`);
            }
            
            const videosDataResponse = await videosResponse.json();
            console.log("Videos response:", videosDataResponse);
            
            if (!videosDataResponse.items || videosDataResponse.items.length === 0) {
                console.log("Aucune vidéo trouvée dans cette page.");
                break;
            }
            
            allVideos = allVideos.concat(videosDataResponse.items);
            nextPageToken = videosDataResponse.nextPageToken || '';
            
        } while (nextPageToken);

        console.log("Total videos found:", allVideos.length);

        // Filter out videos that might be deleted or private
        const validVideos = allVideos.filter(video => {
            const videoId = video.snippet.resourceId?.videoId;
            const title = video.snippet?.title;
            
            // Skip videos that are deleted, private, or have invalid data
            if (!videoId || !title || title === 'Deleted video' || title === 'Private video') {
                console.warn(`Vidéo ignorée (supprimée/privée) : ${title || 'Titre inconnu'}, ID: ${videoId || 'ID inconnu'}`);
                return false;
            }
            return true;
        });

        console.log(`Vidéos valides trouvées : ${validVideos.length} sur ${allVideos.length}`);

        // Get video details to check if they're embeddable (process in batches to avoid large requests)
        const batchSize = 50;
        let newVideos = [];
        
        for (let i = 0; i < validVideos.length; i += batchSize) {
            const batch = validVideos.slice(i, i + batchSize);
            const videoIds = batch.map(video => video.snippet.resourceId.videoId).join(',');
            
            try {
                const videoDetailsResponse = await fetch(
                    `https://www.googleapis.com/youtube/v3/videos?part=status&id=${videoIds}&key=${API_KEY}`
                );
                
                if (!videoDetailsResponse.ok) {
                    console.error(`Erreur lors de la récupération des détails pour le batch ${i/batchSize + 1}`);
                    // Continue with the next batch instead of stopping completely
                    continue;
                }
                
                const videoDetails = await videoDetailsResponse.json();
                console.log(`Batch ${i/batchSize + 1} - Détails vidéo récupérés:`, videoDetails.items?.length || 0);

                const batchValidVideos = batch.filter(video => {
                    const videoDetail = videoDetails.items.find(item => item.id === video.snippet.resourceId.videoId);
                    if (!videoDetail) {
                        console.warn(`Vidéo non trouvée dans les détails : ${video.snippet.title}, ID: ${video.snippet.resourceId.videoId}`);
                        return false;
                    }
                    if (!videoDetail.status.embeddable) {
                        console.warn(`Vidéo non intégrable : ${video.snippet.title}, ID: ${video.snippet.resourceId.videoId}`);
                        return false;
                    }
                    return true;
                });
                
                newVideos = newVideos.concat(batchValidVideos);
                
            } catch (error) {
                console.error(`Erreur lors du traitement du batch ${i/batchSize + 1}:`, error);
                // Continue with the next batch
                continue;
            }
        }

        console.log(`Total des vidéos intégrables : ${newVideos.length}`);

        if (newVideos.length > 0) {
            const existingVideoIds = new Set(videosData.map(video => video.snippet.resourceId.videoId));
            const videosToAdd = newVideos.filter(video => !existingVideoIds.has(video.snippet.resourceId.videoId));

            if (videosToAdd.length > 0) {
                console.log(`Nouvelles vidéos détectées : ${videosToAdd.length}`);
                videosData = [...videosData, ...videosToAdd];
                window.videosData = videosData; // Mettre à jour la variable globale
                console.log("Nombre total de vidéos avant tri :", videosData.length);

                videosData.sort((a, b) => new Date(b.snippet.publishedAt) - new Date(a.snippet.publishedAt));
                console.log("Vidéos triées par date de publication (du plus récent au plus ancien).");
                console.log("Nombre total de vidéos intégrables après mise à jour et tri :", videosData.length);

                if (!isVideoPlayerActive) {
                    displayVideos();
                }
            } else {
                console.log("Aucune nouvelle vidéo détectée.");
            }
        } else {
            console.log("Aucune vidéo intégrable trouvée.");
            if (!isVideoPlayerActive) {
                displayVideos(); // Display empty state
            }
        }

        const { videoId, title, description, publishedAt } = getUrlParams();
        if (videoId && title && description && publishedAt) {
            console.log(`Rechargement de la vidéo depuis l'URL : ID=${videoId}, Titre=${title}`);
            loadVideo(videoId, title, description, publishedAt);
        } else {
            console.log("Aucun paramètre de vidéo trouvé dans l'URL, affichage de la liste des vidéos.");
        }
        
    } catch (error) {
        console.error("Erreur dans fetchVideos :", error);
        if (!isVideoPlayerActive) {
            document.getElementById('videos-container').innerHTML = `<div class="error-message">Erreur lors du chargement des vidéos : ${error.message}</div>`;
        }
    }
}
window.displayFilteredVideos = function(videosToDisplay) {
    const videosContainer = document.getElementById('videos-container');
    if (!videosContainer) {
        console.error('videosContainer non trouvé');
        return;
    }

    const videoPlayerDiv = document.getElementById('video-player');
    const videoInfoDiv = document.getElementById('video-info');
    const bioContainer = document.getElementById('bio-container');
    const commentFormDiv = document.getElementById('comment-form');
    const commentsContainer = document.getElementById('comments-container');

    videosContainer.innerHTML = '';
    videoPlayerDiv.innerHTML = '';
    videoInfoDiv.innerHTML = '';
    bioContainer.innerHTML = '';
    commentFormDiv.innerHTML = '';
    commentsContainer.innerHTML = '';
    document.querySelector('h2').style.display = 'block';

    console.log('Affichage de', videosToDisplay.length, 'vidéos filtrées');
    const startIndex = (window.currentPage - 1) * videosPerPage;
    const endIndex = startIndex + videosPerPage;
    const paginatedVideos = videosToDisplay.slice(startIndex, endIndex);

    if (paginatedVideos.length === 0) {
        videosContainer.innerHTML = '<div class="error-message" style="color: red;">Aucun podcast trouvé pour cette recherche.</div>';
        return;
    }

    paginatedVideos.forEach((video, index) => {
        if (!video.snippet || !video.snippet.resourceId || !video.snippet.resourceId.videoId) {
            console.warn(`Vidéo ${startIndex + index + 1} ignorée : Données manquantes`, video);
            return;
        }

        const videoId = video.snippet.resourceId.videoId;
        const title = video.snippet.title || 'Titre non disponible';
        const thumbnail = video.snippet.thumbnails?.medium?.url || 'https://via.placeholder.com/320x180?text=Thumbnail+Indisponible';
        const description = video.snippet.description || 'Aucune description disponible.';
        const publishedAt = video.snippet.publishedAt || new Date().toISOString();

        const videoCard = document.createElement('div');
        videoCard.className = 'card-hover bg-dark-gray rounded-lg overflow-hidden animate__animated animate__fadeInUp video-card';
        videoCard.style.cursor = 'pointer'; // Indicate the card is clickable
        videoCard.innerHTML = `
            <a href="javascript:void(0)" class="video-link" data-video-id="${videoId}" data-title="${encodeURIComponent(title)}" data-description="${encodeURIComponent(description)}" data-published-at="${publishedAt}">
                <img src="${thumbnail}" alt="${title}" class="w-full h-full object-cover">
            </a>
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-2 text-accent-white">${title}</h3>
                <div class="description-container">
                    <p id="description-text-${videoId}" class="description-text collapsed" style="max-height: 3rem; overflow: hidden;">${description}</p>    
                    <button id="toggle-description-${videoId}" class="toggle-btn" onclick="event.stopPropagation(); loadVideo('${videoId}', '${title.replace(/'/g, "\\'")}', '${description.replace(/'/g, "\\'")}', '${publishedAt}')">VOIR PLUS</button>
                </div>
            </div>
        `;

        // Add click event to the entire card
        videoCard.addEventListener('click', () => {
            console.log(`Clic sur la carte vidéo : ${videoId}`);
            loadVideo(videoId, title, description, publishedAt);
        });

        // Add click event to the video link to prevent duplicate triggers
        const videoLink = videoCard.querySelector('.video-link');
        if (videoLink) {
            videoLink.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent the card's click event from firing
                console.log(`Clic sur le lien vidéo : ${videoId}`);
                loadVideo(videoId, title, description, publishedAt);
            });
        }

        videosContainer.appendChild(videoCard);
    });
    document.querySelectorAll('.video-link').forEach(link => {
        link.addEventListener('click', (e) => {
            const videoId = e.currentTarget.getAttribute('data-video-id');
            const title = decodeURIComponent(e.currentTarget.getAttribute('data-title'));
            const description = decodeURIComponent(e.currentTarget.getAttribute('data-description'));
            const publishedAt = e.currentTarget.getAttribute('data-published-at');
            loadVideo(videoId, title, description, publishedAt);
        });
    });
};

window.displayPagination = function(videos = window.videosData) {
    const paginationContainer = document.getElementById('pagination-container');
    if (!paginationContainer) {
        console.error('paginationContainer non trouvé');
        return;
    }

    paginationContainer.innerHTML = '';

    const totalPages = Math.ceil(videos.length / videosPerPage);
    console.log('Total pages:', totalPages, 'pour', videos.length, 'vidéos');
    if (totalPages <= 1) return;

    if (window.currentPage > totalPages) {
        window.currentPage = totalPages;
    }

    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.className = `pagination-btn ${i === window.currentPage ? 'active' : ''}`;
        pageBtn.textContent = i;
        pageBtn.onclick = () => {
            window.currentPage = i;
            console.log(`Changement de page vers ${window.currentPage}`);
            updateUrl(null, null, null, null);
            window.displayFilteredVideos(videos);
            window.displayPagination(videos); // Re-rendre la pagination pour mettre à jour la classe active
        };
        paginationContainer.appendChild(pageBtn);
    }

    const nextBtn = document.createElement('button');
    nextBtn.className = 'pagination-btn';
    nextBtn.textContent = 'NEXT >';
    nextBtn.disabled = window.currentPage === totalPages;
    nextBtn.onclick = () => {
        if (window.currentPage < totalPages) {
            window.currentPage++;
            console.log(`Changement de page vers ${window.currentPage} (NEXT)`);
            updateUrl(null, null, null, null);
            window.displayFilteredVideos(videos);
            window.displayPagination(videos); // Re-rendre la pagination pour mettre à jour la classe active
        }
    };
    paginationContainer.appendChild(nextBtn);

    const lastBtn = document.createElement('button');
    lastBtn.className = 'pagination-btn';
    lastBtn.textContent = 'LAST >';
    lastBtn.disabled = window.currentPage === totalPages;
    lastBtn.onclick = () => {
        window.currentPage = totalPages;
        console.log(`Changement de page vers ${window.currentPage} (LAST)`);
        updateUrl(null, null, null, null);
        window.displayFilteredVideos(videos);
        window.displayPagination(videos); // Re-rendre la pagination pour mettre à jour la classe active
    };
    paginationContainer.appendChild(lastBtn);
};

function displayVideos() {
    window.displayFilteredVideos(window.videosData);
    window.displayPagination(window.videosData);
}

async function loadVideo(videoId, title, description, publishedAt) {
    console.log(`Démarrage de loadVideo : ID=${videoId}, Titre=${title}`);
    const videosContainer = document.getElementById('videos-container');
    const videoPlayerDiv = document.getElementById('video-player');
    const videoInfoDiv = document.getElementById('video-info');
    const bioContainer = document.getElementById('bio-container');
    const commentFormDiv = document.getElementById('comment-form');
    const commentsContainer = document.getElementById('comments-container');
    const paginationContainer = document.getElementById('pagination-container');

    if (!videoPlayerDiv) {
        console.error("Erreur : Le conteneur #video-player est introuvable.");
        return;
    }

    if (!videoId) {
        console.error("Erreur : videoId est vide ou non défini.");
        videoPlayerDiv.innerHTML = `<div class="error-message">Erreur : ID de la vidéo non valide.</div>`;
        return;
    }

    updateUrl(videoId, title, description, publishedAt);

    isVideoPlayerActive = true;
    document.querySelector('h2').style.display = 'none';
    videosContainer.innerHTML = '';
    videoPlayerDiv.innerHTML = '';
    videoInfoDiv.innerHTML = '';
    bioContainer.innerHTML = '';
    commentFormDiv.innerHTML = '';
    commentsContainer.innerHTML = '';
    paginationContainer.innerHTML = '';

    allComments = [];
    console.log("Réinitialisation de allComments pour la nouvelle vidéo:", allComments);

    console.log("Ajout du bouton Retour...");
    const backButton = document.createElement('button');
    backButton.className = 'back-btn';
    backButton.innerHTML = `
        Retour à la liste
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    `;
    backButton.onclick = () => {
        console.log("Clic sur le bouton Retour");
        isVideoPlayerActive = false;
        updateUrl(null, null, null, null);
        displayVideos();
    };
    videoPlayerDiv.appendChild(backButton);

    try {
        console.log(`Création de l'iframe pour la vidéo ID: ${videoId}`);
        const iframe = document.createElement('iframe');
        iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&fs=1`;
        iframe.allow = 'fullscreen';
        iframe.title = 'YouTube Video Player';
        iframe.style.borderRadius = '8px';
        iframe.onload = () => {
            console.log(`Iframe chargé avec succès pour la vidéo ID: ${videoId}`);
        };
        iframe.onerror = () => {
            console.error(`Erreur lors du chargement de l'iframe pour la vidéo ID: ${videoId}`);
            videoPlayerDiv.innerHTML = `
                <div class="error-message">
                    Impossible de charger la vidéo (peut-être une restriction d'intégration ou une vidéo non disponible).
                    <br>
                    <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank" class="text-primary-teal hover:text-teal-300 font-medium flex items-center justify-center transition-colors mt-2">
                        Regarder sur YouTube
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            `;
        };
        videoPlayerDiv.appendChild(iframe);

        let initialLikeData = { liked: false, like_count: 0 };
        try {
            const response = await fetch(`/podcasts/likes/${videoId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            });
            if (!response.ok) {
                throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}`);
            }
            initialLikeData = await response.json();
            if (initialLikeData.error) {
                throw new Error(initialLikeData.error);
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des likes initiaux:", error);
        }

        console.log("Mise à jour des informations de la vidéo...");
        videoInfoDiv.innerHTML = `
            <h3>${title}</h3>
            <div class="video-actions">
                <button id="like-btn" class="${initialLikeData.liked ? 'liked' : ''}" onclick="toggleLike('${videoId}')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                    <span id="like-count">${initialLikeData.like_count.toLocaleString()}</span>
                </button>
            </div>
        `;

        const publishedDate = new Date(publishedAt).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
        const hasDescription = description && description !== '';
        
        // Compter le nombre de lignes dans la description
        const lineCount = description ? description.split('\n').length : 0;
        // Vérifier si la description a plus de 2 lignes
        const isDescriptionLong = hasDescription && lineCount > 2;

        // Ajouter un ID unique au conteneur de description pour éviter les conflits
        const descriptionId = `description-${videoId}`;

        // Échapper les caractères HTML et préserver les sauts de ligne
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        const escapedDescription = escapeHtml(description || 'Aucune description disponible.');
        const formattedDescription = escapedDescription.replace(/\n/g, '<br>');

        bioContainer.innerHTML = `
            <div class="video-stats" id="video-stats">
                ${publishedDate} • <span id="view-count">0</span> vues
            </div>
            <div class="description-container">
                <p dir="auto" id="description-text-${descriptionId}" class="description-text ${isDescriptionLong ? 'collapsed' : ''}">${formattedDescription}</p>
                ${isDescriptionLong ? `
                    <button id="toggle-description-${descriptionId}" class="toggle-btn" onclick="toggleDescription('${descriptionId}')">afficher plus</button>
                ` : ''}
            </div>
        `;

        currentVideo = { id: videoId };
        updateSignInStatus();

        console.log("Défilement vers le lecteur vidéo...");
        setTimeout(() => {
            videoPlayerDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 500);

        console.log(`Vidéo ID: ${videoId} chargée avec succès`);
        fetchVideoStats(videoId);
        fetchComments(videoId);
    } catch (error) {
        console.error("Erreur dans loadVideo :", error);
        videoPlayerDiv.innerHTML = `<div class="error-message">Erreur lors du chargement de la vidéo : ${error.message}</div>`;
    }
}

function toggleDescription(descriptionId) {
    const descriptionText = document.getElementById(`description-text-${descriptionId}`);
    const toggleBtn = document.getElementById(`toggle-description-${descriptionId}`);
    
    if (!descriptionText || !toggleBtn) {
        console.error(`Erreur : description-text-${descriptionId} ou toggle-description-${descriptionId} introuvable.`);
        return;
    }

    const isCollapsed = descriptionText.classList.contains('collapsed');
    if (isCollapsed) {
        // Calculer la hauteur réelle pour une transition fluide
        const fullHeight = descriptionText.scrollHeight + 'px';
        descriptionText.classList.remove('collapsed');
        descriptionText.classList.add('expanded');
        descriptionText.style.maxHeight = fullHeight;
        toggleBtn.textContent = 'afficher moins';
        toggleBtn.classList.add('expanded');
    } else {
        descriptionText.classList.remove('expanded');
        descriptionText.classList.add('collapsed');
        descriptionText.style.maxHeight = '3.6rem';
        toggleBtn.textContent = 'afficher plus';
        toggleBtn.classList.remove('expanded');
    }
}
async function toggleLike(videoId) {
    console.log(`Toggle like pour la vidéo ID: ${videoId}`);
    const likeBtn = document.getElementById('like-btn');
    const likeCountSpan = document.getElementById('like-count');

    // Check if the user is logged in
    if (!currentUser.name) {
        console.log("Utilisateur non connecté, redirection vers la page de connexion...");
        const params = new URLSearchParams(window.location.search);
        const redirectUrl = `/login?redirect=${encodeURIComponent(window.location.pathname + window.location.search)}`;
        window.location.href = redirectUrl;
        return;
    }

    // Check if the user is blocked
    const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));
    if (isBlocked) {
        console.log("Utilisateur bloqué, action de like annulée.");
        likeBtn.disabled = true;
        likeBtn.style.cursor = 'not-allowed';
        likeBtn.style.backgroundColor = '#2a2a2a';
        likeBtn.title = 'Vous êtes bloqué et ne pouvez pas aimer.';
        return;
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        console.log('CSRF Token:', csrfToken);
        if (!csrfToken) {
            throw new Error('Token CSRF manquant dans la page.');
        }

        const response = await fetch('/podcasts/like', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ video_id: videoId }),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erreur serveur:', response.status, errorText);
            throw new Error(`Erreur HTTP ${response.status}: ${errorText}`);
        }

        const data = await response.json();
        if (data.error) {
            throw new Error(data.error);
        }

        likeBtn.classList.toggle('liked', data.liked);
        likeCountSpan.textContent = data.like_count.toLocaleString();
    } catch (error) {
        console.error('Erreur lors du toggle like:', error);
        alert('Erreur lors de la gestion du like: ' + error.message);
    }
}


async function addComment(videoId, parentCommentId = null, parentReplyId = null, path = []) {
    console.log(`Ajout d'un commentaire pour la vidéo ID: ${videoId}, Parent Comment ID: ${parentCommentId}, Parent Reply ID: ${parentReplyId}, Path: ${path.join(' > ')}`);

    // Check if the user is blocked
   const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));
if (isBlocked) {
    console.log("Utilisateur bloqué, ajout de commentaire annulé.");
    return;
}

    if (!currentUser.name) {
        console.log("Utilisateur non connecté, redirection vers la page de connexion...");
        window.location.href = '/login';
        return;
    }

    let commentInputId = 'comment-input';
    if (parentReplyId) commentInputId = `reply-input-${parentReplyId}`;
    else if (parentCommentId) commentInputId = `reply-input-${parentCommentId}`;
    const commentInput = document.getElementById(commentInputId);
    if (!commentInput) {
        console.error(`Champ de commentaire non trouvé: ${commentInputId}`);
        return;
    }

    const commentText = commentInput.value.trim();
    if (commentText === '') {
        console.log("Commentaire vide, ajout annulé");
        return;
    }

    try {
        commentInput.disabled = true;
        const submitButton = commentInput.parentElement.querySelector('button:last-child');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Envoi...';
        }

        const parsedParentId = parentCommentId ? parseInt(parentCommentId, 10) : null;
        const parsedParentReplyId = parentReplyId ? parseInt(parentReplyId, 10) : null;
        const endpoint = parsedParentId ? '/podcasts/reply' : '/podcasts/comment';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        if (!csrfToken) {
            throw new Error('Token CSRF manquant dans la page.');
        }

        const body = parsedParentId
            ? { comment_id: parsedParentId, content: commentText, parent_reply_id: parsedParentReplyId }
            : { video_id: videoId, content: commentText };

        console.log('Données envoyées au serveur:', body);

        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(body),
        });

        const responseText = await response.text();
        console.log('Réponse brute du serveur:', responseText);

        if (!response.ok) {
            throw new Error(`Erreur HTTP ${response.status}: ${responseText}`);
        }

        let newComment;
        try {
            newComment = JSON.parse(responseText);
        } catch (e) {
            console.error('Erreur lors du parsing de la réponse JSON:', e);
            throw new Error('La réponse du serveur n\'est pas au format JSON valide');
        }

        if (newComment.error) {
            throw new Error(newComment.error);
        }

        if (!newComment.id || !newComment.author || !newComment.content || !newComment.timestamp) {
            console.error('Réponse mal formée:', newComment);
            throw new Error('La réponse du serveur est mal formée.');
        }

        console.log('Nouveau commentaire/réponse reçu:', newComment);

        // Add the new comment/reply to the allComments structure
        if (parsedParentId) {
            newComment.parentId = parsedParentId;
            newComment.parent_id = parsedParentId;
            let currentLevel = allComments;
            for (const id of path) {
                const comment = currentLevel.find(c => parseInt(c.id) === parseInt(id));
                if (!comment) {
                    console.error(`Chemin invalide: Commentaire ID ${id} non trouvé`);
                    return;
                }
                currentLevel = comment.replies = comment.replies || [];
            }
            const parentComment = currentLevel.find(comment => parseInt(comment.id) === parsedParentId);
            if (parentComment) {
                parentComment.replies = parentComment.replies || [];
                if (parsedParentReplyId) {
                    function findAndAddReply(replies, replyId, newReply) {
                        for (let reply of replies) {
                            if (parseInt(reply.id) === replyId) {
                                reply.replies = reply.replies || [];
                                reply.replies.push(newReply);
                                reply.replies.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
                                return true;
                            }
                            if (reply.replies && reply.replies.length > 0) {
                                if (findAndAddReply(reply.replies, replyId, newReply)) return true;
                            }
                        }
                        return false;
                    }
                    if (!findAndAddReply(parentComment.replies, parsedParentReplyId, newComment)) {
                        console.error(`Réponse parent ID ${parsedParentReplyId} non trouvée`);
                    }
                } else {
                    parentComment.replies.push(newComment);
                    parentComment.replies.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
                }
            } else {
                console.error(`Commentaire parent ID ${parsedParentId} non trouvé dans allComments`);
            }
        } else {
            allComments.push(newComment);
            allComments.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
        }

        console.log('État de allComments après ajout:', JSON.parse(JSON.stringify(allComments)));
        displayComments(allComments);
        commentInput.value = '';

        if (parsedParentId) {
            const replyForm = document.getElementById(`reply-form-${parentReplyId || parentCommentId}`);
            if (replyForm) {
                replyForm.style.display = 'none';
            }
            const replyBtn = document.querySelector(`button.reply-btn[data-comment-id="${parentReplyId || parentCommentId}"]`);
            if (replyBtn) {
                replyBtn.classList.remove('active');
            }
            const topLevelCommentId = path.length > 0 ? path[0] : parentCommentId;
            const repliesContainer = document.getElementById(`replies-container-${topLevelCommentId}`);
            const toggleButton = document.getElementById(`replies-toggle-${topLevelCommentId}`);
            if (repliesContainer && toggleButton) {
                repliesContainer.style.display = 'block';
                toggleButton.classList.add('active');
            }
        }
    } catch (error) {
        console.error('Erreur lors de l\'ajout du commentaire:', error);
        alert('Erreur lors de l\'ajout du commentaire: ' + error.message);
    } finally {
        if (commentInput) {
            commentInput.disabled = false;
        }
        const submitButton = commentInput?.parentElement.querySelector('button:last-child');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = (parentCommentId || parentReplyId) ? 'Répondre' : 'Commenter';
        }
    }
}
function debugComments() {
    console.log("==== DÉBUG DES COMMENTAIRES ====");
    console.log("Nombre total de commentaires:", allComments.length);
    
    function logReplies(replies, level = 0) {
        if (Array.isArray(replies)) {
            replies.forEach((reply, index) => {
                const replyId = String(reply.id);
                const replyIsFromYouTube = reply.fromYouTube || reply.from_youtube || false;
                console.log(`${'  '.repeat(level)}-- Réponse #${index + 1} (ID: ${replyId}):`, {
                    id: replyId,
                    type: typeof reply.id,
                    parentId: reply.parentId || reply.parent_id || null,
                    parentIdType: reply.parentId ? typeof reply.parentId : (reply.parent_id ? typeof reply.parent_id : null),
                    author: reply.author,
                    content: reply.content || reply.text,
                    isFromYouTube: replyIsFromYouTube,
                    hasSubReplies: Array.isArray(reply.replies) && reply.replies.length > 0,
                    subReplyCount: Array.isArray(reply.replies) ? reply.replies.length : 0
                });
                logReplies(reply.replies, level + 1);
            });
        }
    }

    allComments.forEach((comment, index) => {
        const commentId = String(comment.id);
        const isFromYouTube = comment.fromYouTube || comment.from_youtube || false;
        
        console.log(`Commentaire #${index + 1}:`, {
            id: commentId,
            type: typeof comment.id,
            author: comment.author,
            content: comment.content || comment.text,
            isFromYouTube: isFromYouTube,
            hasReplies: Array.isArray(comment.replies) && comment.replies.length > 0,
            replyCount: Array.isArray(comment.replies) ? comment.replies.length : 0
        });
        
        const replyForm = document.getElementById(`reply-form-${commentId}`);
        console.log(`  Formulaire de réponse pour ${commentId} existe: ${replyForm ? 'Oui' : 'Non'}`);
        
        logReplies(comment.replies);
    });
    
    console.log("================================");
}

function checkCommentIdCompatibility() {
    console.log("Vérification de la compatibilité des IDs de commentaires...");
    
    function normalizeIds(item) {
        item.id = String(item.id);
        if (item.parentId || item.parent_id) {
            item.parentId = String(item.parentId || item.parent_id);
            item.parent_id = String(item.parentId || item.parent_id);
        }
        if (Array.isArray(item.replies)) {
            item.replies.forEach(normalizeIds);
        }
    }

    allComments.forEach(normalizeIds);
    
    const allIds = new Set();
    function collectIds(items) {
        items.forEach(item => {
            allIds.add(String(item.id));
            if (Array.isArray(item.replies)) collectIds(item.replies);
        });
    }
    collectIds(allComments);
    
    let orphanedReplies = 0;
    
    function checkReplies(replies, parentId) {
        if (Array.isArray(replies)) {
            replies.forEach(reply => {
                const replyParentId = reply.parentId || reply.parent_id;
                if (replyParentId && !allIds.has(String(replyParentId))) {
                    console.warn(`Réponse orpheline détectée: Reply ID ${reply.id} a un parentId ${replyParentId} qui n'existe pas`);
                    orphanedReplies++;
                }
                checkReplies(reply.replies, reply.id);
            });
        }
    }

    allComments.forEach(comment => {
        checkReplies(comment.replies, comment.id);
    });
    
    if (orphanedReplies > 0) {
        console.warn(`ATTENTION: ${orphanedReplies} réponses orphelines détectées!`);
    } else {
        console.log("Toutes les relations parent-enfant sont valides.");
    }
    
    console.log("Vérification de compatibilité terminée.");
}

async function deleteComment(commentId, path = []) {
    const strCommentId = String(commentId);
    console.log(`Suppression du commentaire ID: ${strCommentId}, Path: ${path.join(' > ')}`);
    
    const deleteBtn = document.querySelector(`button.delete-btn[data-comment-id="${strCommentId}"]`);
    if (deleteBtn) {
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = 'Suppression...';
    }
    
    try {
        const endpoint = path.length > 0 ? `/podcasts/reply/${strCommentId}` : `/podcasts/comment/${strCommentId}`;
        console.log(`Envoi de la requête DELETE à : ${endpoint}`);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            throw new Error('Token CSRF introuvable');
        }
        
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000);
        
        const response = await fetch(endpoint, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            signal: controller.signal
        });
        
        clearTimeout(timeoutId);
        
        const responseText = await response.text();
        console.log('Réponse brute:', responseText);
        
        if (!response.ok) {
            throw new Error(`Erreur HTTP ${response.status}: ${responseText}`);
        }
        
        console.log('Suppression réussie sur le serveur. Mise à jour de l\'interface...');
        
        // Navigate to the correct position using the path and collect nested replies to remove
        let currentLevel = allComments;
        let parentLevel = null;
        for (let i = 0; i < path.length; i++) {
            const id = path[i];
            parentLevel = currentLevel;
            const comment = currentLevel.find(c => String(c.id) === String(id));
            if (!comment) {
                console.error(`Chemin invalide: Commentaire ID ${id} non trouvé`);
                return;
            }
            currentLevel = comment.replies = comment.replies || [];
        }

        // Recursively remove the comment and its nested replies
        function removeNestedReplies(commentIdToRemove, replies) {
            return replies.filter(reply => {
                if (String(reply.id) === String(commentIdToRemove)) {
                    return false; // Remove this reply
                }
                if (Array.isArray(reply.replies)) {
                    reply.replies = removeNestedReplies(commentIdToRemove, reply.replies);
                }
                return true; // Keep this reply if not the one to remove
            });
        }

        if (path.length === 0) {
            // Top-level comment
            allComments = removeNestedReplies(strCommentId, allComments);
        } else {
            // Nested reply
            const parentIndex = parentLevel.findIndex(item => String(item.id) === String(path[path.length - 1]));
            if (parentIndex !== -1) {
                parentLevel[parentIndex].replies = removeNestedReplies(strCommentId, parentLevel[parentIndex].replies || []);
            }
        }

        // Re-render comments to update the UI
        displayComments(allComments);

        // Ajouter un message de succès temporaire
        const commentsContainer = document.getElementById('comments-container');
        if (commentsContainer) {
            const successDiv = document.createElement('div');
            successDiv.className = 'success-message temporary';
            successDiv.textContent = 'Commentaire supprimé avec succès.';
            commentsContainer.prepend(successDiv);
            setTimeout(() => successDiv.remove(), 5000); // Le message disparaît après 5 secondes
        }

        // Update the replies toggle if deleting a reply
        if (path.length > 0) {
            const topLevelCommentId = path[0];
            const parentComment = allComments.find(c => String(c.id) === String(topLevelCommentId));
            if (parentComment) {
                const totalReplies = countReplies(parentComment.replies);
                const repliesToggle = document.getElementById(`replies-toggle-${topLevelCommentId}`);
                if (repliesToggle) {
                    repliesToggle.innerHTML = `<span>${totalReplies}</span> réponse${totalReplies !== 1 ? 's' : ''}`;
                    if (totalReplies === 0) {
                        repliesToggle.style.display = 'none';
                        const repliesContainer = document.getElementById(`replies-container-${topLevelCommentId}`);
                        if (repliesContainer) {
                            repliesContainer.style.display = 'none';
                        }
                    }
                }
            }
        }
        
        console.log('État local des commentaires mis à jour:', allComments);
    } catch (error) {
        console.error('Erreur lors de la suppression du commentaire:', error);
        alert(`Erreur lors de la suppression: ${error.message}`);
        
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = 'Supprimer';
        }
    }
}

function toggleReplyForm(commentId) {
    const strCommentId = String(commentId);
    console.log(`Toggling reply form for comment ID: ${strCommentId}`);

    // Check if the user is blocked
const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));
    document.querySelectorAll('.reply-form').forEach(form => {
        if (form.id !== `reply-form-${strCommentId}`) {
            form.style.display = 'none';
        }
    });

    document.querySelectorAll('.reply-btn').forEach(btn => {
        if (btn.getAttribute('data-comment-id') !== strCommentId) {
            btn.classList.remove('active');
        }
    });

    const replyForm = document.getElementById(`reply-form-${strCommentId}`);
    if (!replyForm) {
        console.error(`Form not found: reply-form-${strCommentId}`);
        return;
    }

    const replyBtn = document.querySelector(`button.reply-btn[data-comment-id="${strCommentId}"]`);
    const isVisible = replyForm.style.display === 'block';

    if (isVisible) {
        replyForm.style.display = 'none';
        if (replyBtn) replyBtn.classList.remove('active');
    } else {
        replyForm.style.display = 'block';
        if (replyBtn) {
            replyBtn.classList.add('active');
            setTimeout(() => {
                const textarea = document.getElementById(`reply-input-${strCommentId}`);
                if (textarea) textarea.focus();
            }, 100);
        }

        // If the user is blocked, make the textarea read-only
  const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));
if (isBlocked) {
    const textarea = document.getElementById(`reply-input-${strCommentId}`);
    if (textarea) {
        textarea.setAttribute('readonly', 'readonly');
        textarea.placeholder = "Vous êtes bloqué et ne pouvez pas répondre.";
        textarea.style.backgroundColor = '#2a2a2a';
        textarea.style.cursor = 'not-allowed';
    }
    const submitBtn = replyForm.querySelector('button:last-child');
    if (submitBtn) {
        submitBtn.disabled = true;
    }
    const cancelBtn = replyForm.querySelector('.cancel-reply-btn');
    if (cancelBtn) {
        cancelBtn.disabled = true;
    }
}
    }
}
function toggleReplies(commentId) {
    const strCommentId = String(commentId);
    const repliesContainer = document.getElementById(`replies-container-${strCommentId}`);
    const toggleButton = document.getElementById(`replies-toggle-${strCommentId}`);
    
    if (!repliesContainer || !toggleButton) {
        console.error(`Impossible de trouver les éléments pour commentId: ${strCommentId}`);
        return;
    }
    
    const isHidden = repliesContainer.style.display === 'none' || repliesContainer.style.display === '';
    repliesContainer.style.display = isHidden ? 'block' : 'none';
    
    if (isHidden) {
        toggleButton.classList.add('active');
    } else {
        toggleButton.classList.remove('active');
    }
}

async function fetchYouTubeComments(videoId, retryCount = 3) {
    console.log(`Récupération des commentaires YouTube pour la vidéo ID: ${videoId}, Tentative ${4 - retryCount}/3`);
    try {
        let youtubeComments = [];
        let nextPageToken = '';

        // Étape 1 : Récupérer les commentaires de premier niveau
        do {
            const response = await fetch(
                `https://www.googleapis.com/youtube/v3/commentThreads?part=snippet&videoId=${videoId}&maxResults=50&key=${API_KEY}&pageToken=${nextPageToken}`
            );
            if (!response.ok) {
                if (response.status === 403) {
                    throw new Error("Les commentaires sont désactivés pour cette vidéo ou la clé API n'a pas les autorisations nécessaires.");
                }
                if (retryCount > 1) {
                    console.log('Nouvelle tentative pour les commentaires YouTube...');
                    return setTimeout(() => fetchYouTubeComments(videoId, retryCount - 1), 2000);
                }
                throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            if (!data.items) {
                console.warn("Aucun commentaire YouTube trouvé pour cette vidéo.");
                break;
            }

            const comments = data.items.map(item => {
                const snippet = item.snippet.topLevelComment.snippet;
                return {
                    id: item.id,
                    author: snippet.authorDisplayName || 'Anonyme',
                    avatar: snippet.authorProfileImageUrl || 'https://via.placeholder.com/40',
                    content: snippet.textDisplay || '',
                    timestamp: snippet.publishedAt || new Date().toISOString(),
                    fromYouTube: true,
                    replies: [] // Initialiser un tableau pour les réponses
                };
            });

            youtubeComments = youtubeComments.concat(comments);
            nextPageToken = data.nextPageToken || '';
        } while (nextPageToken);

        // Étape 2 : Récupérer les réponses pour chaque commentaire de premier niveau
        for (let comment of youtubeComments) {
            let replyNextPageToken = '';
            do {
                const replyResponse = await fetch(
                    `https://www.googleapis.com/youtube/v3/comments?part=snippet&parentId=${comment.id}&maxResults=50&key=${API_KEY}&pageToken=${replyNextPageToken}`
                );
                if (!replyResponse.ok) {
                    console.warn(`Erreur lors de la récupération des réponses pour le commentaire ${comment.id}: ${replyResponse.status}`);
                    break;
                }

                const replyData = await replyResponse.json();
                if (replyData.items && replyData.items.length > 0) {
                    const replies = replyData.items.map(reply => ({
                        id: reply.id,
                        author: reply.snippet.authorDisplayName || 'Anonyme',
                        avatar: reply.snippet.authorProfileImageUrl || 'https://via.placeholder.com/40',
                        content: reply.snippet.textDisplay || '',
                        timestamp: reply.snippet.publishedAt || new Date().toISOString(),
                        fromYouTube: true,
                        parentId: comment.id,
                        parent_id: comment.id,
                        replies: [] // Les réponses YouTube ne prennent pas en charge les sous-réponses
                    }));
                    comment.replies = comment.replies.concat(replies);
                }
                replyNextPageToken = replyData.nextPageToken || '';
            } while (replyNextPageToken);
        }

        console.log(`Nombre de commentaires YouTube récupérés : ${youtubeComments.length}`);
        console.log(`Nombre total de réponses récupérées : ${youtubeComments.reduce((sum, c) => sum + c.replies.length, 0)}`);
        return youtubeComments;
    } catch (error) {
        console.error('Erreur lors de la récupération des commentaires YouTube:', error);
        return [];
    }
}

async function fetchComments(videoId, retryCount = 3) {
    console.log(`Récupération des commentaires pour la vidéo ID: ${videoId}, Tentative ${4 - retryCount}/3`);
    const commentsContainer = document.getElementById('comments-container');
    
    try {
        const localResponse = await fetch(`/podcasts/comments/${videoId}`, {
            headers: { 'Accept': 'application/json' },
            signal: AbortSignal.timeout(10000)
        });
        
        let localCommentsData = [];
        if (localResponse.ok) {
            const responseText = await localResponse.text();
            console.log('Réponse brute du serveur (local) :', responseText);
            
            try {
                const data = JSON.parse(responseText);
                if (data.error) {
                    throw new Error(data.error);
                }
                function normalizeReplies(replies, parentId) {
                    if (!Array.isArray(replies)) return [];
                    return replies.map(reply => ({
                        ...reply,
                        id: String(reply.id),
                        parentId: String(parentId),
                        parent_id: String(parentId),
                        replies: normalizeReplies(reply.replies || [], reply.id)
                    }));
                }

                localCommentsData = (data.comments || []).map(comment => ({
                    ...comment,
                    id: String(comment.id),
                    fromYouTube: comment.fromYouTube || comment.from_youtube || false,
                    replies: normalizeReplies(comment.replies || [], comment.id)
                }));
            } catch (e) {
                console.error('Erreur lors du parsing de la réponse JSON (local) :', e);
                if (retryCount > 1) {
                    console.log('Nouvelle tentative pour les commentaires locaux...');
                    return setTimeout(() => fetchComments(videoId, retryCount - 1), 2000);
                }
                throw new Error('La réponse du serveur local n\'est pas au format JSON valide');
            }
        } else {
            const errorText = await localResponse.text();
            console.error('Erreur serveur (local) :', localResponse.status, errorText);
            if (retryCount > 1) {
                console.log('Nouvelle tentative pour les commentaires locaux...');
                return setTimeout(() => fetchComments(videoId, retryCount - 1), 2000);
            }
            throw new Error(`Erreur HTTP ${localResponse.status}: ${errorText}`);
        }

        console.log("Récupération des commentaires YouTube...");
        const youtubeCommentsData = await fetchYouTubeComments(videoId);

        const youtubeCommentIds = new Set(youtubeCommentsData.map(c => c.id));
        const localCommentsWithoutYouTube = localCommentsData.filter(c => !c.fromYouTube && !youtubeCommentIds.has(c.id));
        allComments = [...localCommentsWithoutYouTube, ...youtubeCommentsData];

        allComments.forEach(comment => {
            if (Array.isArray(comment.replies)) {
                const sortReplies = replies => {
                    if (!Array.isArray(replies)) return;
                    replies.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
                    replies.forEach(reply => sortReplies(reply.replies));
                };
                sortReplies(comment.replies);
            }
        });

        allComments.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
        
        debugComments();
        checkCommentIdCompatibility();
        
        displayComments(allComments);
    } catch (error) {
        console.error('Erreur dans fetchComments:', error);
        commentsContainer.innerHTML = `
            <div class="error-message">
                Erreur lors du chargement des commentaires : ${error.message}
                <button onclick="fetchComments('${videoId}')" class="retry-btn">Réessayer</button>
            </div>
        `;
    }
}

function countReplies(replies) {
    if (!Array.isArray(replies)) return 0;
    let count = replies.length;
    replies.forEach(reply => {
        count += countReplies(reply.replies);
    });
    return count;
}

// New function to show a custom confirmation dialog
function showConfirmation(message, onConfirm) {
    console.log('Affichage de la boîte de confirmation pour:', message);
    
    // Remove any existing confirmation dialog
    const existingDialog = document.getElementById('confirmation-dialog');
    if (existingDialog) existingDialog.remove();
    
    // Create dialog container
    const dialog = document.createElement('div');
    dialog.id = 'confirmation-dialog';
    dialog.style.position = 'fixed';
    dialog.style.top = '50%';
    dialog.style.left = '50%';
    dialog.style.transform = 'translate(-50%, -50%)';
    dialog.style.backgroundColor = '#2d2d2d'; // Match dark theme
    dialog.style.padding = '20px';
    dialog.style.borderRadius = '8px';
    dialog.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
    dialog.style.zIndex = '1000';
    dialog.style.color = '#ffffff';
    dialog.style.fontFamily = 'Arial, sans-serif';
    
    // Create message
    const messageDiv = document.createElement('p');
    messageDiv.textContent = message;
    messageDiv.style.marginBottom = '20px';
    messageDiv.style.textAlign = 'center';
    
    // Create buttons container
    const buttonsDiv = document.createElement('div');
    buttonsDiv.style.display = 'flex';
    buttonsDiv.style.justifyContent = 'center';
    buttonsDiv.style.gap = '10px';
    
    // Create Confirm button
    const confirmBtn = document.createElement('button');
    confirmBtn.textContent = 'Confirmer';
    confirmBtn.style.backgroundColor = 'var(--primary-color)'; // Match primary-teal
    confirmBtn.style.color = '#ffffff';
    confirmBtn.style.padding = '8px 16px';
    confirmBtn.style.border = 'none';
    confirmBtn.style.borderRadius = '4px';
    confirmBtn.style.cursor = 'pointer';
    confirmBtn.style.fontWeight = '600';
    confirmBtn.onmouseover = () => confirmBtn.style.backgroundColor = 'var(--primary-color)';
    confirmBtn.onmouseout = () => confirmBtn.style.backgroundColor = 'var(--primary-color)';
    confirmBtn.onclick = () => {
        console.log('Confirmation acceptée');
        onConfirm();
        dialog.remove();
    };
    
    // Create Cancel button
    const cancelBtn = document.createElement('button');
    cancelBtn.textContent = 'Annuler';
    cancelBtn.style.backgroundColor = '#4b4b4b'; // Match cancel-btn
    cancelBtn.style.color = '#ffffff';
    cancelBtn.style.padding = '8px 16px';
    cancelBtn.style.border = 'none';
    cancelBtn.style.borderRadius = '4px';
    cancelBtn.style.cursor = 'pointer';
    cancelBtn.style.fontWeight = '600';
    cancelBtn.onmouseover = () => cancelBtn.style.backgroundColor = '#5c5c5c';
    cancelBtn.onmouseout = () => cancelBtn.style.backgroundColor = '#4b4b4b';
    cancelBtn.onclick = () => {
        console.log('Confirmation annulée');
        dialog.remove();
    };
    
    // Append elements
    buttonsDiv.appendChild(confirmBtn);
    buttonsDiv.appendChild(cancelBtn);
    dialog.appendChild(messageDiv);
    dialog.appendChild(buttonsDiv);
    document.body.appendChild(dialog);
}

function displayComments(comments) {
    const commentsContainer = document.getElementById('comments-container');
    if (!commentsContainer) return;

    // Vérifier si l'utilisateur est bloqué
    const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));
    commentsContainer.innerHTML = '';

    if (!comments || comments.length === 0) {
        commentsContainer.innerHTML = '<div class="no-comments">Aucun commentaire pour le moment. Soyez le premier à commenter!</div>';
        return;
    }

    function renderComment(comment, level = 0, path = []) {
        const commentId = String(comment.id);
        const isOwnComment = comment.author === currentUser.name && !(comment.fromYouTube || comment.from_youtube);
        const canDelete = !isBlocked && (isOwnComment || (
            (currentUser.role === 'superadmin') || 
            (currentUser.role === 'admin' && currentUser.is_active)
        ));
        const isFromYouTube = comment.fromYouTube || comment.from_youtube || false;
        const parentId = String(comment.parentId || comment.parent_id || '');

        let parentAuthor = null;
        if (level > 0) {
            let currentLevel = allComments;
            for (let i = 0; i < path.length - 1; i++) {
                const id = path[i];
                const found = currentLevel.find(c => String(c.id) === String(id));
                if (!found) break;
                currentLevel = found.replies || [];
            }
            const parentComment = currentLevel.find(c => String(c.id) === parentId);
            parentAuthor = parentComment ? parentComment.author : null;
        }

        const commentContent = comment.content || comment.text || comment.textDisplay || '';
        const displayText = level > 0 && parentAuthor ? `@${parentAuthor} ${commentContent}` : commentContent;

        const commentElement = document.createElement('div');
        commentElement.className = `comment ${level > 0 ? 'reply' : ''}`;
        commentElement.id = `comment-${commentId}`;
        commentElement.style.marginLeft = `${level * 40}px`;

        const avatarContainer = document.createElement('div');
        avatarContainer.className = 'comment-avatar-container';
        console.log(`Rendu de l'avatar pour le commentaire ID: ${commentId}, isOwnComment: ${isOwnComment}, avatar: ${isOwnComment ? currentUser.avatar : comment.avatar}, author: ${comment.author}`);

        let avatarSrc = null;
        let avatarInitial = null;
        const authorName = comment.author || 'Anonyme';

        if (isOwnComment) {
            avatarSrc = currentUser.avatar || 'https://via.placeholder.com/40';
            avatarInitial = !currentUser.avatar || currentUser.avatar === 'https://via.placeholder.com/40'
                ? (currentUser.avatarInitial || (currentUser.name ? currentUser.name[0].toUpperCase() : 'A'))
                : null;
        } else {
            avatarSrc = comment.avatar || 'https://via.placeholder.com/40';
            avatarInitial = (!comment.avatar || comment.avatar === 'https://via.placeholder.com/40') && comment.author
                ? comment.author[0].toUpperCase()
                : null;
        }

        if (avatarSrc && avatarSrc !== 'https://via.placeholder.com/40') {
            const avatarImg = document.createElement('img');
            avatarImg.src = avatarSrc;
            avatarImg.alt = authorName;
            avatarImg.className = 'comment-avatar';
            avatarImg.onerror = function() { 
                this.src = 'https://via.placeholder.com/40'; 
                console.log(`Fallback to placeholder for ${commentId} due to avatar load error`);
            };
            avatarContainer.appendChild(avatarImg);
        } else if (avatarInitial) {
            const initialDiv = document.createElement('div');
            initialDiv.className = 'initial-avatar';
            initialDiv.textContent = avatarInitial;
            avatarContainer.appendChild(initialDiv);
        } else {
            const avatarImg = document.createElement('img');
            avatarImg.src = 'https://via.placeholder.com/40';
            avatarImg.alt = authorName;
            avatarImg.className = 'comment-avatar';
            avatarImg.onerror = function() { this.src = 'https://via.placeholder.com/40'; };
            avatarContainer.appendChild(avatarImg);
        }

        const contentDiv = document.createElement('div');
        contentDiv.className = 'comment-content';
        contentDiv.style.position = 'relative';

        const authorDiv = document.createElement('div');
        authorDiv.className = 'comment-author';
        authorDiv.textContent = authorName;

        if (isFromYouTube) {
            const youtubeSpan = document.createElement('span');
            youtubeSpan.className = 'from-youtube';
            youtubeSpan.textContent = 'From YouTube';
            authorDiv.appendChild(youtubeSpan);
        }

        const textDiv = document.createElement('div');
        textDiv.className = 'comment-text';
        textDiv.textContent = displayText || 'Aucun contenu';

        const metaDiv = document.createElement('div');
        metaDiv.className = 'comment-meta';
        try {
            const timestamp = comment.timestamp ? new Date(comment.timestamp) : new Date();
            metaDiv.textContent = timestamp.toLocaleString('fr-FR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (e) {
            console.error('Erreur de formatage de date:', e);
            metaDiv.textContent = comment.timestamp || 'Date inconnue';
        }

        const actionsWrapper = document.createElement('div');
        actionsWrapper.className = 'comment-actions-wrapper';
        actionsWrapper.style.position = 'absolute';
        actionsWrapper.style.top = '0';
        actionsWrapper.style.right = '0';
        actionsWrapper.style.display = 'flex';
        actionsWrapper.style.alignItems = 'center';

        const actionsDiv = document.createElement('div');
        actionsDiv.className = 'comment-actions';

        // Ajouter le bouton de réponse uniquement pour les commentaires non-YouTube
        if (!isFromYouTube && !isBlocked) {
            const replyBtn = document.createElement('button');
            replyBtn.className = 'reply-btn';
            replyBtn.textContent = 'Réponse';
            replyBtn.setAttribute('data-comment-id', commentId);
            replyBtn.onclick = function() { toggleReplyForm(commentId); };
            actionsDiv.appendChild(replyBtn);
        }

        // Ajouter le menu à trois points uniquement pour les commentaires non-YouTube avec permissions
        // Ne pas afficher le menu pour les utilisateurs bloqués, même pour leurs propres commentaires
        if (!isFromYouTube && !isBlocked && (canDelete || (currentUser.name && !isOwnComment))) {
            const moreBtn = document.createElement('button');
            moreBtn.className = 'more-actions-btn';
            moreBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M12 12v.01M12 18v.01" />
                </svg>
            `;
            moreBtn.style.cursor = 'pointer';
            moreBtn.style.background = 'none';
            moreBtn.style.border = 'none';
            moreBtn.style.color = '#ffffff';
            moreBtn.setAttribute('data-comment-id', commentId);

            const dropdownMenu = document.createElement('div');
            dropdownMenu.className = 'dropdown-menu';
            dropdownMenu.id = `dropdown-menu-${commentId}`;
            dropdownMenu.style.position = 'absolute';
            dropdownMenu.style.top = '100%';
            dropdownMenu.style.right = '0';
            dropdownMenu.style.backgroundColor = '#3a3a3a';
            dropdownMenu.style.border = '1px solid #555';
            dropdownMenu.style.borderRadius = '4px';
            dropdownMenu.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';
            dropdownMenu.style.display = 'none';
            dropdownMenu.style.zIndex = '10';
            dropdownMenu.style.padding = '5px 0';
            dropdownMenu.style.minWidth = '120px';

            if (canDelete) {
                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'dropdown-item delete-btn';
                deleteBtn.textContent = 'Supprimer';
                deleteBtn.setAttribute('data-comment-id', commentId);
                deleteBtn.onclick = function() {
                    showConfirmation('Êtes-vous sûr de vouloir supprimer ce commentaire ?', () => {
                        deleteComment(commentId, path);
                    });
                    dropdownMenu.style.display = 'none';
                };
                deleteBtn.style.display = 'block';
                deleteBtn.style.padding = '8px 12px';
                deleteBtn.style.background = 'none';
                deleteBtn.style.border = 'none';
                deleteBtn.style.color = '#ffffff';
                deleteBtn.style.textAlign = 'left';
                deleteBtn.style.width = '100%';
                deleteBtn.style.cursor = 'pointer';
                deleteBtn.onmouseover = () => deleteBtn.style.backgroundColor = '#555';
                deleteBtn.onmouseout = () => deleteBtn.style.backgroundColor = 'transparent';
                dropdownMenu.appendChild(deleteBtn);
            }

            if (currentUser.name && !isOwnComment) {
                const reportBtn = document.createElement('button');
                reportBtn.className = 'dropdown-item report-btn';
                reportBtn.textContent = 'Signaler';
                reportBtn.setAttribute('data-comment-id', commentId);
                reportBtn.setAttribute('data-is-reply', level > 0 ? 'true' : 'false');
                reportBtn.onclick = function() {
                    showReportForm(commentId, level > 0, path);
                    dropdownMenu.style.display = 'none';
                };
                reportBtn.style.display = 'block';
                reportBtn.style.padding = '8px 12px';
                reportBtn.style.background = 'none';
                reportBtn.style.border = 'none';
                reportBtn.style.color = '#ffffff';
                reportBtn.style.textAlign = 'left';
                reportBtn.style.width = '100%';
                reportBtn.style.cursor = 'pointer';
                reportBtn.onmouseover = () => reportBtn.style.backgroundColor = '#555';
                reportBtn.onmouseout = () => reportBtn.style.backgroundColor = 'transparent';
                dropdownMenu.appendChild(reportBtn);
            }

            moreBtn.onclick = function(e) {
                e.stopPropagation();
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (menu.id !== `dropdown-menu-${commentId}`) {
                        menu.style.display = 'none';
                    }
                });
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            };

            document.addEventListener('click', function closeMenu(e) {
                if (!moreBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.style.display = 'none';
                }
            });

            actionsWrapper.appendChild(moreBtn);
            actionsWrapper.appendChild(dropdownMenu);
        }

        contentDiv.appendChild(actionsWrapper);
        contentDiv.appendChild(authorDiv);
        contentDiv.appendChild(textDiv);
        contentDiv.appendChild(metaDiv);
        contentDiv.appendChild(actionsDiv);

        if (comment.replies && comment.replies.length > 0) {
            const totalReplies = countReplies(comment.replies);
            const repliesToggle = document.createElement('button');
            repliesToggle.className = 'replies-toggle';
            repliesToggle.id = `replies-toggle-${commentId}`;
            repliesToggle.innerHTML = `<span>${totalReplies}</span> réponse${totalReplies !== 1 ? 's' : ''}`;
            repliesToggle.setAttribute('data-comment-id', commentId);
            repliesToggle.onclick = function() { toggleReplies(commentId); };

            const repliesContainer = document.createElement('div');
            repliesContainer.className = 'replies-container';
            repliesContainer.id = `replies-container-${commentId}`;
            repliesContainer.dataset.replyCount = totalReplies;
            repliesContainer.style.display = 'none';

            comment.replies.forEach(reply => {
                repliesContainer.appendChild(renderComment(reply, level + 1, [...path, commentId]));
            });

            contentDiv.appendChild(repliesToggle);
            contentDiv.appendChild(repliesContainer);
        }

        if (!isFromYouTube && !isBlocked) {
            const replyFormDiv = document.createElement('div');
            replyFormDiv.id = `reply-form-${commentId}`;
            replyFormDiv.className = 'reply-form';
            replyFormDiv.style.display = 'none';
            replyFormDiv.style.marginLeft = `${level * 40}px`;

            const replyTextarea = document.createElement('textarea');
            replyTextarea.id = `reply-input-${commentId}`;
            replyTextarea.placeholder = `Répondre à ${comment.author}...`;
            replyTextarea.rows = 3;

            const replyFormButtons = document.createElement('div');
            replyFormButtons.className = 'reply-form-buttons';

            const cancelReplyBtn = document.createElement('button');
            cancelReplyBtn.className = 'cancel-reply-btn';
            cancelReplyBtn.textContent = 'Annuler';
            cancelReplyBtn.onclick = function() { toggleReplyForm(commentId); };

            const submitReplyBtn = document.createElement('button');
            submitReplyBtn.textContent = 'Répondre';
            submitReplyBtn.setAttribute('data-comment-id', commentId);
            submitReplyBtn.onclick = function() {
                if (level === 0) {
                    addComment(currentVideo?.id || '', commentId, null, [commentId]);
                } else {
                    addComment(currentVideo?.id || '', path[0], commentId, path);
                }
            };

            replyFormButtons.appendChild(cancelReplyBtn);
            replyFormButtons.appendChild(submitReplyBtn);

            replyFormDiv.appendChild(replyTextarea);
            replyFormDiv.appendChild(replyFormButtons);
            contentDiv.appendChild(replyFormDiv);
        }

        commentElement.appendChild(avatarContainer);
        commentElement.appendChild(contentDiv);

        return commentElement;
    }

    const mainComments = comments.filter(comment =>
        !comment.parentId && !comment.parent_id
    );

    console.log('Affichage des commentaires principaux:', mainComments);
    mainComments.forEach(comment => {
        const renderedComment = renderComment(comment);
        console.log(`Rendu du commentaire ID: ${comment.id}`, renderedComment);
        commentsContainer.appendChild(renderedComment);
    });
}

function refreshComments(videoId) {
    if (!videoId && currentVideo && currentVideo.id) {
        videoId = currentVideo.id;
    }
    
    if (!videoId) {
        console.error("Impossible de rafraîchir les commentaires: ID de la vidéo non disponible");
        return;
    }
    
    console.log(`Rafraîchissement forcé des commentaires pour la vidéo ID: ${videoId}`);
    fetchComments(videoId);
}

async function fetchVideoStats(videoId) {
    console.log(`Récupération des statistiques pour la vidéo ID: ${videoId}`);
    const statsContainer = document.getElementById('video-stats');
    try {
        const response = await fetch(
            `https://www.googleapis.com/youtube/v3/videos?part=statistics&id=${videoId}&key=${API_KEY}`
        );
        if (!response.ok) {
            throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}`);
        }
        const data = await response.json();
        if (!data.items || data.items.length === 0) {
            throw new Error("Aucune statistique trouvée pour cette vidéo.");
        }
        const stats = data.items[0].statistics;
        currentVideo.stats = stats;
        document.getElementById('view-count').textContent = parseInt(stats.viewCount).toLocaleString();
    } catch (error) {
        console.error("Erreur dans fetchVideoStats :", error);
        statsContainer.innerHTML += ` • Erreur lors du chargement des statistiques`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    fetchVideos();
    setInterval(fetchVideos, 3600000);

    // Ajout de la logique de recherche
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            console.log('Recherche :', searchTerm);

            if (window.videosData) {
                console.log('Nombre total de vidéos dans videosData:', window.videosData.length);
                const filteredVideos = window.videosData.filter(video => {
                    const title = (video.snippet.title || '').toLowerCase();
                    const description = (video.snippet.description || '').toLowerCase();
                    const publishedAt = video.snippet.publishedAt 
                        ? new Date(video.snippet.publishedAt).toLocaleDateString('fr-FR').toLowerCase() 
                        : '';
                    console.log('Vérification pour vidéo:', { title, description, publishedAt });
                    return title.includes(searchTerm) || description.includes(searchTerm) || publishedAt.includes(searchTerm);
                });
                console.log('Nombre de vidéos filtrées:', filteredVideos.length);

                window.currentPage = 1; // Réinitialiser la page pour la recherche
                window.displayFilteredVideos(filteredVideos);
                window.displayPagination(filteredVideos);
            } else {
                console.error('window.videosData non trouvé');
            }
        });
    } else {
        console.error('Élément .search-input non trouvé dans le DOM');
    }
});
function showReportForm(commentId, isReply, path) {
    console.log(`Affichage du formulaire de signalement pour ID: ${commentId}, isReply: ${isReply}, Path: ${path.join(' > ')}`);

    // Check if the user is blocked or is an inactive admin
    const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));

    const existingForm = document.getElementById('report-form-dialog');
    if (existingForm) existingForm.remove();

    const dialog = document.createElement('div');
    dialog.id = 'report-form-dialog';
    dialog.style.position = 'fixed';
    dialog.style.top = '50%';
    dialog.style.left = '50%';
    dialog.style.transform = 'translate(-50%, -50%)';
    dialog.style.backgroundColor = '#2d2d2d';
    dialog.style.padding = '20px';
    dialog.style.borderRadius = '8px';
    dialog.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
    dialog.style.zIndex = '1000';
    dialog.style.color = '#ffffff';
    dialog.style.fontFamily = 'Arial, sans-serif';
    dialog.style.width = '400px';
    dialog.style.maxWidth = '90%';

    const title = document.createElement('h3');
    title.textContent = 'Signaler un commentaire';
    title.style.marginBottom = '15px';
    title.style.textAlign = 'center';

    const selectLabel = document.createElement('label');
    selectLabel.textContent = 'Raison du signalement :';
    selectLabel.style.display = 'block';
    selectLabel.style.marginBottom = '5px';

    const select = document.createElement('select');
    select.id = 'report-reason-category';
    select.style.width = '100%';
    select.style.backgroundColor = '#3a3a3a';
    select.style.border = '1px solid #555';
    select.style.borderRadius = '4px';
    select.style.padding = '10px';
    select.style.color = '#fff';
    select.style.marginBottom = '15px';

    const categories = [
        'Contenu inapproprié',
        'Spam',
        'Harcèlement',
        'Désinformation',
        'Autre',
    ];

    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        select.appendChild(option);
    });

    const textarea = document.createElement('textarea');
    textarea.id = 'report-reason-details';
    textarea.placeholder = isBlocked ? 'Vous êtes bloqué et ne pouvez pas signaler.' : 'Veuillez fournir des détails sur le signalement...';
    textarea.rows = 5;
    textarea.style.width = '100%';
    textarea.style.backgroundColor = '#3a3a3a';
    textarea.style.border = '1px solid #555';
    textarea.style.borderRadius = '4px';
    textarea.style.padding = '10px';
    textarea.style.color = '#fff';
    textarea.style.marginBottom = '15px';

    const buttonsDiv = document.createElement('div');
    buttonsDiv.style.display = 'flex';
    buttonsDiv.style.justifyContent = 'center';
    buttonsDiv.style.gap = '10px';

    const submitBtn = document.createElement('button');
    submitBtn.textContent = 'Envoyer';
    submitBtn.style.backgroundColor = 'var(--primary-color)';
    submitBtn.style.color = '#ffffff';
    submitBtn.style.padding = '8px 16px';
    submitBtn.style.border = 'none';
    submitBtn.style.borderRadius = '4px';
    submitBtn.style.cursor = 'pointer';
    submitBtn.style.fontWeight = '600';
    submitBtn.onmouseover = () => submitBtn.style.backgroundColor = 'var(--primary-color)';
    submitBtn.onmouseout = () => submitBtn.style.backgroundColor = 'var(--primary-color)';

    const cancelBtn = document.createElement('button');
    cancelBtn.textContent = 'Annuler';
    cancelBtn.style.backgroundColor = '#4b4b4b';
    cancelBtn.style.color = '#ffffff';
    cancelBtn.style.padding = '8px 16px';
    cancelBtn.style.border = 'none';
    cancelBtn.style.borderRadius = '4px';
    cancelBtn.style.cursor = 'pointer';
    cancelBtn.style.fontWeight = '600';
    cancelBtn.onmouseover = () => cancelBtn.style.backgroundColor = '#5c5c5c';
    cancelBtn.onmouseout = () => cancelBtn.style.backgroundColor = '#4b4b4b';
    cancelBtn.onclick = () => {
        console.log('Signalement annulé');
        dialog.remove();
    };

    if (isBlocked) {
        // Disable the form for blocked users or inactive admins
        select.disabled = true;
        textarea.setAttribute('readonly', 'readonly');
        textarea.style.backgroundColor = '#2a2a2a';
        textarea.style.cursor = 'not-allowed';
        submitBtn.disabled = true;
        submitBtn.style.backgroundColor = '#555';
        submitBtn.style.cursor = 'not-allowed';
        submitBtn.onmouseover = null;
        submitBtn.onmouseout = null;
    } else {
        submitBtn.onclick = () => {
            submitReport(commentId, isReply, select.value, textarea.value, path);
            dialog.remove();
        };
    }

    buttonsDiv.appendChild(submitBtn);
    buttonsDiv.appendChild(cancelBtn);
    dialog.appendChild(title);
    dialog.appendChild(selectLabel);
    dialog.appendChild(select);
    dialog.appendChild(textarea);
    dialog.appendChild(buttonsDiv);
    document.body.appendChild(dialog);

    setTimeout(() => select.focus(), 100);
}
async function submitReport(commentId, isReply, reasonCategory, reasonDetails, path) {
    console.log(`Envoi du signalement pour ID: ${commentId}, isReply: ${isReply}, Catégorie: ${reasonCategory}, Détails: ${reasonDetails}, Path: ${path.join(' > ')}`);

    // Check if the user is blocked
const isBlocked = @json(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active));    if (isBlocked) {
        console.log("Utilisateur bloqué, signalement annulé.");
        return; // Exit the function without attempting to send a request
    }

    // Vérification des champs requis
    if (!reasonCategory || !reasonDetails.trim()) {
        const dialog = document.getElementById('report-form-dialog');
        if (dialog) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message temporary';
            errorDiv.textContent = 'Veuillez sélectionner une catégorie et fournir des détails pour le signalement.';
            dialog.prepend(errorDiv);
            setTimeout(() => errorDiv.remove(), 5000);
        }
        return;
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        if (!csrfToken) {
            throw new Error('Token CSRF manquant dans la page.');
        }

        const body = isReply
            ? { reply_id: commentId, reason_category: reasonCategory, reason_details: reasonDetails }
            : { comment_id: commentId, reason_category: reasonCategory, reason_details: reasonDetails };

        const response = await fetch('/podcasts/report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(body),
        });

        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.message || `Erreur HTTP ${response.status}`);
        }

        console.log('Signalement envoyé avec succès:', data);
        const commentsContainer = document.getElementById('comments-container');
        if (commentsContainer) {
            const successDiv = document.createElement('div');
            successDiv.className = 'error-message temporary';
            successDiv.style.color = 'var(--primary-color)'; // Utiliser la couleur primaire pour le succès
            successDiv.textContent = 'Signalement envoyé avec succès. Merci de votre contribution.';
            commentsContainer.prepend(successDiv);
            setTimeout(() => successDiv.remove(), 5000);
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi du signalement:', error);
        const commentsContainer = document.getElementById('comments-container');
        if (commentsContainer) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message temporary';
            errorDiv.textContent = 'Erreur lors de l\'envoi du signalement : ' + error.message;
            commentsContainer.prepend(errorDiv);
            setTimeout(() => errorDiv.remove(), 5000);
        }
    }
}
</script>
</body>
</html> 