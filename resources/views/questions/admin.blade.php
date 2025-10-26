<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Question Management</title>
   <meta name="csrf-token" content="csrf_token_placeholder">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1EB5AD;
            --primary-hover: #16a085;
            --primary-dark: #148585;
            --primary-gradient: linear-gradient(135deg, #1EB5AD 0%, #16a085 50%, #148585 100%);
            --secondary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --dark-bg: #0F0F23;
            --darker-bg: #0A0A1A;
            --card-bg: #1A1B3A;
            --card-hover: #252654;
            --light-text: #ffffff;
            --gray-text: #B8C5D1;
            --muted-text: #8B949E;
            --accent-blue: #3B82F6;
            --accent-purple: #8B5CF6;
            --accent-pink: #EC4899;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --glass-bg: rgba(255, 255, 255, 0.02);
            --glass-border: rgba(255, 255, 255, 0.08);
            --shadow-light: rgba(30, 181, 173, 0.15);
            --shadow-dark: rgba(0, 0, 0, 0.3);
            --border-radius: 16px;
            --border-radius-lg: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--darker-bg);
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(30, 181, 173, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            color: var(--light-text);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: var(--darker-bg);
            overflow: hidden;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 25% 25%, rgba(30, 181, 173, 0.08) 0%, transparent 30%),
                radial-gradient(circle at 75% 75%, rgba(139, 92, 246, 0.08) 0%, transparent 30%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { 
                transform: translate(0, 0) rotate(0deg); 
            }
            33% { 
                transform: translate(30px, -30px) rotate(120deg); 
            }
            66% { 
                transform: translate(-20px, 20px) rotate(240deg); 
            }
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--light-text);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            background: rgba(30, 181, 173, 0.1);
            border-color: var(--primary-color);
            box-shadow: 0 8px 20px rgba(30, 181, 173, 0.2);
            color: var(--light-text);
        }

        .back-btn i {
            transition: transform 0.3s ease;
        }

        .back-btn:hover i {
            transform: translateX(-3px);
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            margin-top: 5rem;
            padding: 3rem 2rem;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            box-shadow: 
                0 20px 40px var(--shadow-dark),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary-gradient);
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            animation: slideInUp 0.8s ease;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: var(--gray-text);
            font-weight: 400;
            animation: slideInUp 0.8s ease 0.2s both;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left 0.6s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 25px 50px var(--shadow-dark),
                0 0 30px var(--shadow-light);
            border-color: var(--primary-color);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray-text);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            margin-bottom: 2rem;
            overflow: hidden;
            box-shadow: 
                0 20px 40px var(--shadow-dark),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .section-header {
            background: var(--primary-gradient);
            color: var(--light-text);
            padding: 2rem;
            font-size: 1.5rem;
            font-weight: 700;
            position: relative;
            overflow: hidden;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }
        
        .question-card {
            border-bottom: 1px solid var(--glass-border);
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
            position: relative;
            overflow: hidden;
        }

        .question-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(30, 181, 173, 0.05), transparent);
            transition: left 0.6s;
        }

        .question-card:hover::before {
            left: 100%;
        }
        
        .question-card:hover {
            background: rgba(30, 181, 173, 0.03);
            transform: translateX(8px);
            border-left: 4px solid var(--primary-color);
            padding-left: calc(2rem - 4px);
        }
        
        .question-card:last-child {
            border-bottom: none;
        }
        
        .question-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--light-text);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }
        
        .question-content {
            color: var(--gray-text);
            margin-bottom: 1.5rem;
            line-height: 1.7;
            font-size: 0.95rem;
        }
        
        .question-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.9rem;
            color: var(--muted-text);
        }

        .question-info {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .question-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            white-space: nowrap;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            color: var(--light-text);
            box-shadow: 0 8px 20px rgba(30, 181, 173, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(30, 181, 173, 0.4);
            color: var(--light-text);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--light-text);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4);
            color: var(--light-text);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
            color: var(--light-text);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
        }
        
        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
            color: var(--light-text);
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            border: 1px solid;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }
        
        .status-answered {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border-color: var(--success);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }
        
        .status-pending {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            border-color: var(--danger);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { 
                opacity: 1; 
                transform: scale(1);
            }
            50% { 
                opacity: 0.8; 
                transform: scale(1.02);
            }
        }

        .status-public {
            background: rgba(59, 130, 246, 0.15);
            color: var(--accent-blue);
            border-color: var(--accent-blue);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        }

        .status-private {
            background: rgba(236, 72, 153, 0.15);
            color: var(--accent-pink);
            border-color: var(--accent-pink);
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.2);
        }
        
        .no-questions {
            text-align: center;
            padding: 4rem;
            color: var(--muted-text);
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.02);
            border-radius: var(--border-radius);
            margin: 2rem;
        }

        .no-questions-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        
        .answer-preview {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .answer-preview:hover {
            background: rgba(30, 181, 173, 0.05);
            border-left-color: var(--accent-purple);
        }
        
        .media-count {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: var(--primary-color);
            background: rgba(30, 181, 173, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            margin-left: 1rem;
            border: 1px solid rgba(30, 181, 173, 0.3);
        }

        .loading {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { 
                transform: rotate(360deg); 
            }
        }

        /* Pagination Styles */
        .pagination-wrapper {
            padding: 2rem;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                max-width: 100%;
                padding: 1.5rem;
            }

            .back-btn {
                position: relative;
                top: 0;
                left: 0;
                margin-bottom: 1rem;
            }

            .page-header {
                margin-top: 0;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .page-header {
                padding: 2rem 1rem;
                margin-bottom: 2rem;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .section-header {
                padding: 1.5rem;
                font-size: 1.25rem;
            }

            .question-card {
                padding: 1.5rem;
            }

            .question-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .question-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .question-actions {
                width: 100%;
            }

            .btn {
                flex: 1;
                min-width: 120px;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 2rem;
            }

            .question-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .back-btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
    
    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Retour au Dashboard
    </a>
        <div class="page-header">
            <h1 class="page-title">Question Management</h1>
            <p class="page-subtitle">Manage user questions and provide comprehensive answers</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $unansweredQuestions->count() }}</div>
                <div class="stat-label">Pending Questions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $answeredQuestions->count() }}</div>
                <div class="stat-label">Answered Questions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $answeredQuestions->where('is_public', true)->count() }}</div>
                <div class="stat-label">Public Answers</div>
            </div>
        </div>

        <!-- Unanswered Questions -->
        <div class="section">
            <div class="section-header">
                ⏳ Pending Questions ({{ $unansweredQuestions->count() }})
            </div>
            
            @if($unansweredQuestions->count() > 0)
                @foreach($unansweredQuestions as $question)
                <div class="question-card">
                    <div class="question-title">{{ $question->title }}</div>
                    <div class="question-content">{{ Str::limit($question->content, 200) }}</div>
                    <div class="question-meta">
                        <div class="question-info">
                            <span><strong>Asked by:</strong> {{ $question->user->name }}</span>
                            <span>{{ $question->created_at->diffForHumans() }}</span>
                            <span class="status-badge status-pending">⚡ Pending</span>
                        </div>
                        <div class="question-actions">
                            <a href="{{ route('questions.show', $question) }}" class="btn btn-primary">
                                📝 Answer Question
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-questions">
                    <div>No pending questions at the moment.</div>
                    <p style="margin-top: 0.5rem; font-size: 0.9rem; opacity: 0.7;">All caught up! Great work.</p>
                </div>
            @endif
        </div>

        <!-- Answered Questions -->
        <div class="section">
            <div class="section-header">
                ✅ Answered Questions
            </div>
            
            @if($answeredQuestions->count() > 0)
                @foreach($answeredQuestions as $question)
                <div class="question-card">
                    <div class="question-title">{{ $question->title }}</div>
                    <div class="question-content">{{ Str::limit($question->content, 150) }}</div>
                    
                    <div class="answer-preview">
                        <strong>📋 Answer:</strong> {{ Str::limit($question->answer_content, 200) }}
                        @if($question->answer_images)
                            <span class="media-count">📷 {{ count($question->answer_images) }} images</span>
                        @endif
                        @if($question->answer_videos)
                            <span class="media-count">🎥 {{ count($question->answer_videos) }} videos</span>
                        @endif
                    </div>
                    
                    <div class="question-meta">
                        <div class="question-info">
                            <span><strong>Asked by:</strong> {{ $question->user->name }}</span>
                            <span><strong>Answered by:</strong> {{ $question->answeredBy->name }}</span>
                            <span>{{ $question->answered_at->diffForHumans() }}</span>
                            <span class="status-badge status-answered">✅ Answered</span>
                            @if($question->is_public)
                                <span class="status-badge status-public">🌍 Public</span>
                            @else
                                <span class="status-badge status-private">🔒 Private</span>
                            @endif
                        </div>
                        <div class="question-actions">
                            <a href="{{ route('questions.show', $question) }}" class="btn btn-warning">
                                ✏️ Edit Answer
                            </a>
                            <button onclick="toggleVisibility({{ $question->id }})" class="btn btn-success">
                                {{ $question->is_public ? '🔒 Make Private' : '🌍 Make Public' }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div style="padding: 2rem; text-align: center;">
                    {{ $answeredQuestions->links() }}
                </div>
            @else
                <div class="no-questions">
                    <div class="no-questions-icon">💭</div>
                    <div>No answered questions yet.</div>
                    <p style="margin-top: 0.5rem; font-size: 0.9rem; opacity: 0.7;">Start answering questions to see them here.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        async function toggleVisibility(questionId) {
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading"></span> Updating...';
            button.disabled = true;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            try {
                const response = await fetch(`/admin/questions/${questionId}/toggle-visibility`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    location.reload();
                } else {
                    throw new Error('Server returned error');
                }
            } catch (error) {
                alert('Error updating visibility. Please try again.');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }

        // Add smooth scrolling for better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Add intersection observer for animation triggers
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.section, .stat-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>