<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Détail du log - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1a9e9e',
                            hover: '#25c4c4',
                            dark: '#148585',
                        },
                        danger: '#b91c1c',
                        warning: '#b45309',
                        success: '#10b981',
                        dark: {
                            DEFAULT: '#121212',
                            card: '#1e1e1e',
                            element: '#252525',
                            border: '#333333',
                        },
                    },
                }
            }
        }
    </script>
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
        --dark-element: #252525;
        --dark-border: #333333;
        --dark-card: #1e1e1e;
        --success: #10b981;
        --danger: #b91c1c;
        --warning: #b45309;
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--dark-border);
        }

        .header h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--light-text);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header h2 i {
            background: linear-gradient(135deg, var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .back-btn {
            background: linear-gradient(135deg, var(--gray-bg), var(--dark-element));
            color: var(--light-text);
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--dark-border);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, var(--dark-element), var(--gray-bg));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }

        .info-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            justify-items:center;
        }

        .info-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 1rem;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th {
            text-align: left;
            padding: 0.75rem 0;
            color: var(--gray-text);
            font-weight: 500;
            font-size: 0.875rem;
        }

        .info-table td {
            padding: 0.75rem 0;
            color: var(--light-text);
            font-size: 0.875rem;
        }

        .action-badge, .status-badge, .method-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .data-container {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .data-container pre {
            background-color: var(--dark-element);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 1rem;
            max-height: 400px;
            overflow-y: auto;
            font-size: 0.875rem;
        }

        .recent-logs-container {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .recent-logs-container h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: linear-gradient(135deg, var(--dark-element), var(--gray-bg));
        }

        .table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-text);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--dark-border);
        }

        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--dark-border);
            color: var(--light-text);
            font-size: 0.875rem;
        }

        .table tbody tr:hover {
            background-color: rgba(26, 158, 158, 0.05);
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 767px) {
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .header h2 {
                font-size: 1.875rem;
                justify-content: center;
            }

            .info-container {
                grid-template-columns: 1fr;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 600px;
            }
        }

        @media (max-width: 479px) {
            .header h2 {
                font-size: 1.5rem;
            }

            .table th, .table td {
                padding: 0.5rem 0.625rem;
                font-size: 0.6875rem;
            }
        }
                #back-to-dashboard:hover{
            border:1px solid var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="header">
            <h2>
                <i class="fas fa-clipboard-list"></i>
                Détail du log #{{ $log->id }}
            </h2>
            <a href="{{ route('dashboard.logs.index') }}" class="back-btn" id="back-to-dashboard">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>

        @php
            $actionColors = [
                'login' => 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);',
                'logout' => 'background-color: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);',
                'register' => 'background-color: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);',
                'password_reset' => 'background-color: rgba(180, 83, 9, 0.15); color: #f59e0b; border: 1px solid rgba(180, 83, 9, 0.3);',
                'profile_updated' => 'background-color: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);',
                'article_created' => 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);',
                'article_updated' => 'background-color: rgba(180, 83, 9, 0.15); color: #f59e0b; border: 1px solid rgba(180, 83, 9, 0.3);',
                'article_deleted' => 'background-color: rgba(185, 28, 28, 0.15); color: #f87171; border: 1px solid rgba(185, 28, 28, 0.3);',
                'comment_deleted' => 'background-color: rgba(185, 28, 28, 0.15); color: #f87171; border: 1px solid rgba(185, 28, 28, 0.3);',
                'user_blocked' => 'background-color: rgba(185, 28, 28, 0.15); color: #f87171; border: 1px solid rgba(185, 28, 28, 0.3);',
                'user_unblocked' => 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);',
                'content_reported' => 'background-color: rgba(180, 83, 9, 0.15); color: #f59e0b; border: 1px solid rgba(180, 83, 9, 0.3);',
                'podcast_liked' => 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);',
                'post_voted' => 'background-color: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);',
                'page_viewed' => 'background-color: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3);',
            ];
            $methodColors = [
                'GET' => 'background-color: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);',
                'POST' => 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);',
                'PUT' => 'background-color: rgba(180, 83, 9, 0.15); color: #f59e0b; border: 1px solid rgba(180, 83, 9, 0.3);',
                'PATCH' => 'background-color: rgba utf-8 180, 83, 9, 0.15); color: #f59e0b; border: 1px solid rgba(180, 83, 9, 0.3);',
                'DELETE' => 'background-color: rgba(185, 28, 28, 0.15); color: #f87171; border: 1px solid rgba(185, 28, 28, 0.3);',
            ];
        @endphp

        <div class="info-container">
            <div class="info-card">
                <h3 class="info-card">Informations générales</h3>
                <table class="info-table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $log->id }}</td>
                    </tr>
                    <tr>
                        <th>Date/Heure</th>
                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Action</th>
                        <td>
                            <span class="action-badge" style="{{ $actionColors[$log->action] ?? 'background-color: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3);' }}">
                                {{ $log->action }}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $log->description ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Code de statut</th>
                        <td>
                            @if ($log->status_code)
                                <span class="status-badge" style="{{ $log->status_code < 400 ? 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);' : 'background-color: rgba(185, 28, 28, 0.15); color: #f87171; border: 1px solid rgba(185, 28, 28, 0.3);' }}">
                                    {{ $log->status_code }}
                                </span>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="info-card">
                <h3 class="info-card">Informations utilisateur</h3>
                @if($log->user)
                    <table class="info-table">
                        <tr>
                            <th>Nom</th>
                            <td>{{ $log->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $log->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Rôle</th>
                            <td>
                                <span class="action-badge" style="background-color: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">
                                    {{ $log->user->role }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                <span class="status-badge" style="{{ $log->user->is_active ? 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);' : 'background-color: rgba(185, 28, 28, 0.15); color: #f87171; border: 1px solid rgba(185, 28, 28, 0.3);' }}">
                                    {{ $log->user->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                @else
                    <p class="text-gray-400">Visiteur non connecté</p>
                @endif
            </div>

            <div class="info-card">
                <h3 class="info-card">Informations techniques</h3>
                <table class="info-table">
                    <tr>
                        <th>Adresse IP</th>
                        <td><code>{{ $log->ip_address }}</code></td>
                    </tr>
                    <tr>
                        <th>Méthode HTTP</th>
                        <td>
                            <span class="method-badge" style="{{ $methodColors[$log->method] ?? 'background-color: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3);' }}">
                                {{ $log->method }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Route</th>
                        <td><code>{{ $log->route_name ?: 'N/A' }}</code></td>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <td class="break-all"><code>{{ $log->url }}</code></td>
                    </tr>
                </table>
            </div>

            <div class="info-card">
                <h3 class="info-card">Navigateur</h3>
                @if($log->user_agent)
                    <p class="break-all mb-4"><code>{{ $log->user_agent }}</code></p>
                    <p class="text-sm text-gray-400">Informations détaillées du navigateur non disponibles sans analyse supplémentaire.</p>
                @else
                    <p class="text-gray-400">Non disponible</p>
                @endif
            </div>
        </div>

        @if($log->request_data && count($log->request_data) > 0)
            <div class="data-container">
                <h3>Données de la requête</h3>
                <pre><code>{{ json_encode($log->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
            </div>
        @endif

        @if($log->response_data && count($log->response_data) > 0)
            <div class="data-container">
                <h3>Données de réponse</h3>
                <pre><code>{{ json_encode($log->response_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
            </div>
        @endif

        @if($log->user)
            <div class="recent-logs-container">
                <h3 class="info-card">Autres activités récentes de {{ $log->user->name }}</h3>
                @php
                    $recentLogs = \App\Models\UserLog::where('user_id', $log->user->id)
                        ->where('id', '!=', $log->id)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
                @endphp
                @if($recentLogs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-clock mr-2"></i>Date</th>
                                    <th><i class="fas fa-tasks mr-2"></i>Action</th>
                                    <th><i class="fas fa-info-circle mr-2"></i>Description</th>
                                    <th><i class="fas fa-network-wired mr-2"></i>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentLogs as $recentLog)
                                    <tr>
                                        <td>{{ $recentLog->created_at->format('d/m H:i') }}</td>
                                        <td>
                                            <span class="action-badge" style="{{ $actionColors[$recentLog->action] ?? 'background-color: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3);' }}">
                                                {{ $recentLog->action }}
                                            </span>
                                        </td>
                                        <td>{{ $recentLog->description }}</td>
                                        <td><code>{{ $recentLog->ip_address }}</code></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-400">Aucune autre activité récente.</p>
                @endif
            </div>
        @endif
    </div>
</body>
</html>