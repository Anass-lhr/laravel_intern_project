<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Logs d'activité - Administration</title>
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

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--dark-card), var(--dark-element));
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .stat-card h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--light-text);
        }

        .stat-card p {
            font-size: 0.875rem;
            color: var(--gray-text);
        }

        .filter-container {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .filter-container h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 1rem;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .filter-input {
            background-color: var(--dark-element);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 0.75rem;
            color: var(--light-text);
            font-size: 0.875rem;
            width: 100%;
            outline: none;
        }

        .filter-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 158, 158, 0.1);
        }

        .filter-button {
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-button:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .table-container {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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

        .action-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-view {
            background-color: rgba(26, 158, 158, 0.15);
            color: var(--primary-color);
            border: 1px solid rgba(26, 158, 158, 0.3);
        }

        .btn-view:hover {
            background-color: rgba(26, 158, 158, 0.25);
            transform: translateY(-1px);
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

            .filter-form {
                grid-template-columns: 1fr;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 800px;
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

                .back-to-dashboard {
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

        .back-to-dashboard:hover {
            background: linear-gradient(135deg, var(--dark-element), var(--gray-bg));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
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
                Logs d'activité
            </h2>
            <a href="{{ route('dashboard') }}" class="stat-card" id="back-to-dashboard">
                <i class="fas fa-arrow-left"></i>
                Retour au Dashboard
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
        @endphp

        <div class="stats-container">
            <div class="stat-card">
                <h5>{{ number_format($stats['today_logs']) }}</h5>
                <p>Aujourd'hui</p>
            </div>
            <div class="stat-card">
                <h5>{{ number_format($stats['yesterday_logs']) }}</h5>
                <p>Hier</p>
            </div>
            <div class="stat-card">
                <h5>{{ number_format($stats['week_logs']) }}</h5>
                <p>Cette semaine</p>
            </div>
            <div class="stat-card">
                <h5>{{ number_format($stats['month_logs']) }}</h5>
                <p>Ce mois</p>
            </div>
            <div class="stat-card">
                <h5>{{ number_format($stats['total_logs']) }}</h5>
                <p>Total des logs</p>
            </div>
        </div>

        <div class="filter-container">
            <h3>Filtres</h3>
            <form method="GET" action="{{ route('dashboard.logs.index') }}" class="filter-form">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-400">Utilisateur</label>
                    <select name="user_id" id="user_id" class="filter-input">
                        <option value="">Tous les utilisateurs</option>
                        @foreach(\App\Models\User::orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-400">Action</label>
                    <input type="text" name="action" id="action" class="filter-input" value="{{ request('action') }}" placeholder="ex: login, comment">
                </div>
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-400">Date de début</label>
                    <input type="date" name="date_from" id="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-400">Date de fin</label>
                    <input type="date" name="date_to" id="date_to" class="filter-input" value="{{ request('date_to') }}">
                </div>
                <div>
                    <label for="ip_address" class="block text-sm font-medium text-gray-400">Adresse IP</label>
                    <input type="text" name="ip_address" id="ip_address" class="filter-input" value="{{ request('ip_address') }}">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="filter-button">Filtrer</button>
                </div>
            </form>
        </div>

        <div class="table-container">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Historique des activités ({{ $logs->total() }} entrées)</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-clock mr-2"></i>Date/Heure</th>
                            <th><i class="fas fa-user mr-2"></i>Utilisateur</th>
                            <th><i class="fas fa-tasks mr-2"></i>Action</th>
                            <th><i class="fas fa-info-circle mr-2"></i>Description</th>
                            <th><i class="fas fa-network-wired mr-2"></i>IP</th>
                            <th><i class="fas fa-traffic-light mr-2"></i>Status</th>
                            <th><i class="fas fa-cog mr-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    @if($log->user)
                                        <div>
                                            <strong>{{ $log->user->name }}</strong><br>
                                            <span class="text-gray-400 text-sm">{{ $log->user->email }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Visiteur</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="action-badge" style="{{ $actionColors[$log->action] ?? 'background-color: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3);' }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td>{{ $log->description ?: 'N/A' }}</td>
                                <td><code>{{ $log->ip_address }}</code></td>
                                <td>
                                    @if($log->status_code)
                                        <span class="status-badge" style="{{ $log->status_code < 400 ? 'background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);' : 'background-color: rgba(185, 28, 28, 0.15); color: #f87171; border: 1px solid rgba(185, 28, 28, 0.3);' }}">
                                            {{ $log->status_code }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.logs.show', $log) }}" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-400">Aucun log trouvé avec ces critères.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
                <div class="p-6">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>