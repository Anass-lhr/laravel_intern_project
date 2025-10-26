<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Questions & Answers</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ===== CSS VARIABLES ===== */
        :root {
            @php
                $settings = App\Models\Setting::first();
                $primaryColor = $settings->primary_color ?? '#1EB5AD';
            @endphp
            --primary-color: {{ $primaryColor }};
            --primary-color-hover: color-mix(in srgb, var(--primary-color) 85%, #000000);
            --primary-color-light: color-mix(in srgb, var(--primary-color) 20%, transparent);
            --primary-color-dark: color-mix(in srgb, var(--primary-color) 80%, #000000);
            
            --dark-bg: #1A1D21;
            --darker-bg: #111315;
            --darkest-bg: #0D0F11;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
            --gray-light: #D1D5DB;
            --gray-bg: #2A2D35;
            --gray-border: #374151;
            
            --highlight-color: #00f0ff;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== RESET & BASE STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, var(--darker-bg) 0%, var(--darkest-bg) 100%);
            color: var(--light-text);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ===== LAYOUT CONTAINER ===== */
        .main-layout {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: 280px;
            transition: var(--transition);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* ===== HEADER STYLES ===== */
        .header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(17, 19, 21, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 0;
            margin-bottom: 3rem;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .header-logo-container {
            display: none;
        }

        .header-center {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .search-container {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .search-input {
            width: 100%;
            padding: 1rem 3rem 1rem 1.5rem;
            background: var(--gray-bg);
            border: 2px solid transparent;
            border-radius: var(--radius-lg);
            color: var(--light-text);
            font-size: 1rem;
            outline: none;
            transition: var(--transition);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px var(--primary-color-light);
            background: var(--darker-bg);
        }

        .search-input::placeholder {
            color: var(--gray-text);
        }

        .search-icon {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-text);
            font-size: 1.25rem;
            transition: var(--transition);
        }

        .search-container:focus-within .search-icon {
            color: var(--primary-color);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* ===== SIDEBAR STYLES ===== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: var(--darker-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
            overflow-y: auto;
            z-index: 40;
            transition: var(--transition);
        }

        .logo-container {
            padding: 0 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .logo {
            max-width: 180px;
            height: auto;
            margin: 0 auto;
            filter: brightness(1.1);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--gray-text);
            text-decoration: none;
            font-weight: 500;
            border-radius: var(--radius-md);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .sidebar-menu a:hover::before {
            width: 100%;
        }

        .sidebar-menu a:hover {
            color: var(--light-text);
            transform: translateX(8px);
        }

        .sidebar-menu a.active {
            color: var(--light-text);
            background: linear-gradient(135deg, var(--primary-color), var(--primary-color-dark));
            box-shadow: var(--shadow-md);
        }

        .sidebar-menu a i {
            margin-right: 1rem;
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
            border-radius: 2px;
        }

        .page-header h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--light-text), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .page-header p {
            font-size: 1.25rem;
            color: var(--gray-text);
            max-width: 600px;
            margin: 0 auto;
        }

        /* ===== TAB NAVIGATION ===== */
        .tab-navigation {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            padding: 0.5rem;
            background: var(--gray-bg);
            border-radius: var(--radius-xl);
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .tab-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: transparent;
            color: var(--gray-text);
            border: none;
            border-radius: var(--radius-lg);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .tab-btn:hover {
            color: var(--light-text);
            background: rgba(255, 255, 255, 0.1);
        }

        .tab-btn.active {
            background: var(--primary-color);
            color: var(--light-text);
            box-shadow: var(--shadow-md);
        }

        .tab-btn i {
            font-size: 1.1rem;
        }

        /* ===== TAB CONTENT ===== */
        .tab-content {
            display: none;
            animation: fadeInUp 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== Q&A ITEMS ===== */
        .qa-item {
            background: var(--dark-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .qa-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--highlight-color));
            opacity: 0;
            transition: var(--transition);
        }

        .qa-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-color);
        }

        .qa-item:hover::before {
            opacity: 1;
        }

        .question-section {
            padding: 2.5rem;
            background: linear-gradient(135deg, var(--gray-bg), var(--dark-bg));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .question-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--light-text);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .question-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray-light);
            margin-bottom: 1.5rem;
        }

        .question-meta {
            font-size: 0.95rem;
            color: var(--gray-text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .question-meta strong {
            color: var(--primary-color);
        }

        .answer-section {
            padding: 2.5rem;
        }

        .answer-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .answer-badge {
            background: linear-gradient(135deg, var(--success), var(--primary-color));
            color: var(--light-text);
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-xl);
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-md);
        }

        .answer-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--light-text);
            margin-bottom: 2rem;
            white-space: pre-line;
        }

        .answer-content code {
            background: var(--gray-bg);
            padding: 0.375rem 0.75rem;
            border-radius: var(--radius-sm);
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            color: var(--highlight-color);
            font-size: 0.95em;
        }

        .answer-meta {
            font-size: 0.95rem;
            color: var(--gray-text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .answer-meta strong {
            color: var(--primary-color);
        }

        /* ===== MEDIA GRID ===== */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .media-item {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: var(--gray-bg);
        }

        .media-item img,
        .media-item video {
            width: 100%;
            height: 200px;
            object-fit: cover;
            cursor: pointer;
            transition: var(--transition);
            border-radius: var(--radius-lg);
        }

        .media-item:hover img {
            transform: scale(1.05);
        }

        /* ===== FORM STYLES ===== */
        .form-container {
            background: var(--dark-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            padding: 3rem;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--highlight-color));
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            background: var(--gray-bg);
            color: var(--light-text);
            border: 2px solid transparent;
            border-radius: var(--radius-lg);
            font-size: 1rem;
            font-family: inherit;
            transition: var(--transition);
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px var(--primary-color-light);
            background: var(--darker-bg);
        }

        .form-group textarea {
            min-height: 150px;
            line-height: 1.6;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border: none;
            border-radius: var(--radius-lg);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-color-dark));
            color: var(--light-text);
            width: 100%;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: var(--light-text);
        }

        /* ===== MESSAGES ===== */
        .success-message {
            display: none;
            background: linear-gradient(135deg, var(--success), var(--primary-color));
            color: var(--light-text);
            padding: 2rem;
            border-radius: var(--radius-lg);
            text-align: center;
            margin-top: 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .success-message h3 {
            margin-bottom: 0.75rem;
            font-size: 1.5rem;
        }

        .error-message {
            display: none;
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            padding: 1.25rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--danger);
        }

        /* ===== AUTH NOTICE ===== */
        .auth-notice {
            background: var(--dark-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            padding: 3rem;
            text-align: center;
            box-shadow: var(--shadow-xl);
        }

        .auth-notice h3 {
            color: var(--light-text);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .auth-notice p {
            color: var(--gray-text);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .auth-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        /* ===== NO QUESTIONS STATE ===== */
        .no-questions {
            text-align: center;
            background: var(--dark-bg);
            border: 2px dashed rgba(255, 255, 255, 0.2);
            padding: 4rem 2rem;
            border-radius: var(--radius-xl);
        }

        .no-questions h3 {
            font-size: 1.75rem;
            color: var(--light-text);
            margin-bottom: 1rem;
        }

        .no-questions p {
            color: var(--gray-text);
            font-size: 1.2rem;
        }

        /* ===== MODAL STYLES ===== */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 90%;
            border-radius: var(--radius-lg);
            animation: modalZoom 0.3s ease-out;
        }

        @keyframes modalZoom {
            from {
                transform: scale(0.7);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: var(--light-text);
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            background: rgba(0, 0, 0, 0.5);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: var(--primary-color);
            background: rgba(0, 0, 0, 0.8);
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1200px) {
            .content-wrapper {
                margin-left: 80px;
            }
            
            .sidebar {
                width: 80px;
            }
            
            .logo-container {
                display: none;
            }
            
            .sidebar-menu a span {
                display: none;
            }
            
            .sidebar-menu a {
                justify-content: center;
                padding: 1rem;
            }
            
            .sidebar-menu a i {
                margin-right: 0;
                font-size: 1.5rem;
            }
            
            .header-logo-container {
                display: block;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-bottom: 80px;
            }
            
            .content-wrapper {
                margin-left: 0;
            }
            
            .sidebar {
                width: 100%;
                height: 80px;
                bottom: 0;
                top: auto;
                border-right: none;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding: 0;
                flex-direction: row;
                justify-content: space-around;
                align-items: center;
            }
            
            .logo-container {
                display: none;
            }
            
            .sidebar-menu {
                display: flex;
                width: 100%;
                padding: 0;
                justify-content: space-around;
                align-items: center;
                height: 100%;
            }
            
            .sidebar-menu li {
                margin: 0;
                flex: 1;
            }
            
            .sidebar-menu a {
                justify-content: center;
                padding: 1rem 0.5rem;   
                border-radius: 0;
                height: 100%;
            }
            
            .sidebar-menu a span {
                display: none;
            }
            
            .sidebar-menu a.active {
                border-left: none;
                border-top: 3px solid var(--primary-color);
                background: transparent;
            }
            
            .container {
                padding: 1rem;
            }
            
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .tab-navigation {
                flex-direction: column;
                width: 100%;
                background: transparent;
                padding: 0;
            }
            
            .tab-btn {
                width: 100%;
                justify-content: center;
                padding: 1.25rem;
                background: var(--gray-bg);
                margin-bottom: 0.5rem;
                border-radius: var(--radius-lg);
            }
            
            .question-section,
            .answer-section,
            .form-container {
                padding: 1.5rem;
            }
            
            .media-grid {
                grid-template-columns: 1fr;
            }
            
            .auth-links {
                flex-direction: column;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .header-actions {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .question-section,
            .answer-section,
            .form-container {
                padding: 1rem;
            }
            
            .sidebar {
                height: 70px;
            }
            
            body {
                padding-bottom: 70px;
            }
            
            .sidebar-menu a i {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>

<div class="main-layout">
    @include('components.sidebar')
    <div class="content-wrapper">
        @include('components.header')
        <div class="container">
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="showTab('questions', event)">
                    <i class="fas fa-list"></i>
                    Browse Questions
                </button>
                <button class="tab-btn" onclick="showTab('ask', event)">
                    <i class="fas fa-plus-circle"></i>
                    Ask Question
                </button>
            </div>

            <!-- Browse Questions Tab -->
            <div id="questions-tab" class="tab-content active">
                @if($questions->count() > 0)
                    @foreach($questions as $question)
                    <div class="qa-item">
                        <div class="question-section">
                            <div class="question-title">{{ $question->title }}</div>
                            <div class="question-content">{{ $question->content }}</div>
                            <div class="question-meta">
                                Asked by <strong>{{ $question->user->name }}</strong> • {{ $question->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="answer-section">
                            <div class="answer-header">
                                <div class="answer-badge">
                                    <i class="fas fa-check"></i>
                                    Answered
                                </div>
                            </div>
                            <div class="answer-content">
                                {!! nl2br(e($question->answer_content)) !!}
                            </div>
                            @if($question->answer_images && count($question->answer_images) > 0)
                            <div class="media-grid">
                                @foreach($question->answer_images as $image)
                                <div class="media-item">
                                    <img src="{{ asset('storage/questions/images/' . $image) }}" alt="Answer Image" onclick="openModal(this.src)">
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @if($question->answer_videos && count($question->answer_videos) > 0)
                            <div class="media-grid">
                                @foreach($question->answer_videos as $video)
                                <div class="media-item">
                                    <video controls>
                                        <source src="{{ asset('storage/questions/videos/' . $video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <div class="answer-meta">
                                Answered by <strong>{{ $question->answeredBy->name }}</strong> • {{ $question->answered_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="pagination">
                        {{ $questions->links() }}
                    </div>
                @else
                    <div class="no-questions">
                        <h3>No Questions Yet</h3>
                        <p>Be the first to ask a question!</p>
                    </div>
                @endif
            </div>

            <!-- Ask Question Tab -->
            <div id="ask-tab" class="tab-content">
                @guest
                    <div class="auth-notice">
                        <h3><i class="fas fa-lock"></i> Login Required</h3>
                        <p>You need to be logged in to ask a question. Please login or create an account to continue.</p>
                        <div class="auth-links">
                            <a href="{{ route('login') }}" class="login-btn">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="register-btn">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </div>
                    </div>
                @else
                    <div class="form-container">
                        <div class="error-message" id="errorMessage"></div>
                        <form id="questionForm">
                            @csrf
                            <div class="form-group">
                                <label for="title">
                                    <i class="fas fa-heading"></i>
                                    Question Title
                                </label>
                                <input type="text" id="title" name="title" placeholder="Enter a brief title for your question" required>
                            </div>
                            <div class="form-group">
                                <label for="content">
                                    <i class="fas fa-edit"></i>
                                    Your Question
                                </label>
                                <textarea id="content" name="content" placeholder="Please provide details about your question..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-paper-plane"></i>
                                Send Question
                            </button>
                        </form>
                        <div class="success-message" id="successMessage">
                            <h3><i class="fas fa-check-circle"></i> Question Submitted Successfully!</h3>
                            <p>Thank you for your question. Our team will review and respond shortly.</p>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="modal">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<style>
.pagination {
    margin: 2rem 0;
    display: flex;
    justify-content: center;
}
</style>

<script>
    // Tab switching functionality
    function showTab(tabName, event) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        // Show selected tab
        document.getElementById(tabName + '-tab').classList.add('active');
        // Add active class to clicked button
        if (event) event.target.classList.add('active');
    }

    // Form submission functionality
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('questionForm');
        if (!form) return; // Exit if form doesn't exist (user not logged in)
        
        const submitBtn = document.getElementById('submitBtn');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            errorMessage.style.display = 'none';

            try {
                const response = await fetch('{{ route("questions.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    form.style.display = 'none';
                    successMessage.style.display = 'block';
                    
                    // Reset form after delay
                    setTimeout(() => {
                        form.reset();
                        form.style.display = 'block';
                        successMessage.style.display = 'none';
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Question';
                    }, 3000);
                } else {
                    throw new Error(data.message || 'An error occurred');
                }
            } catch (error) {
                errorMessage.textContent = error.message;
                errorMessage.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Question';
            }
        });
    });

    // Modal functionality
    function openModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.style.display = 'block';
        modalImg.src = imageSrc;
    }

    // Close modal when clicking the close button or outside the image
    document.querySelector('.modal-close').onclick = function() {
        document.getElementById('imageModal').style.display = 'none';
    }

    document.getElementById('imageModal').onclick = function(event) {
        if (event.target === this) {
            this.style.display = 'none';
        }
    }
</script>
</body>
</html>