<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;
use Symfony\Component\HttpFoundation\Response;

class UserActivityLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Ne pas logger certaines routes (assets, API interne, etc.)
        if ($this->shouldSkipLogging($request)) {
            return $response;
        }

        // Déterminer l'action basée sur la route et la méthode
        $action = $this->determineAction($request, $response);
        
        if ($action) {
            $this->logUserActivity($request, $response, $action);
        }

        return $response;
    }

    private function shouldSkipLogging(Request $request): bool
    {
        $skipRoutes = [
            '_debugbar/*',
            'horizon/*',
            'telescope/*',
            'assets/*',
            '*.js',
            '*.css',
            '*.png',
            '*.jpg',
            '*.gif',
            'favicon.ico',
        ];

        $currentPath = $request->path();
        
        foreach ($skipRoutes as $pattern) {
            if (fnmatch($pattern, $currentPath)) {
                return true;
            }
        }

        return false;
    }

    private function determineAction(Request $request, Response $response): ?string
    {
        $route = $request->route();
        $routeName = $route?->getName();
        $method = $request->method();
        $statusCode = $response->getStatusCode();

        // Si la réponse n'est pas réussie, ne pas logger (sauf pour les erreurs importantes)
        if ($statusCode >= 400 && $statusCode !== 401 && $statusCode !== 403) {
            return null;
        }

        // Mapping des routes vers des actions lisibles
        $actionMappings = [
            // Authentification
            'login' => 'login',
            'logout' => 'logout',
            'register' => 'register',
            'password.email' => 'password_reset_request',
            'password.reset' => 'password_reset',
            'verification.send' => 'email_verification_sent',
            'verification.verify' => 'email_verified',

            // Profil
            'profile.edit' => 'profile_viewed',
            'profile.update' => 'profile_updated',
            'profile.destroy' => 'profile_deleted',
            'profile.remove-avatar' => 'avatar_removed',

            // Podcasts
            'podcasts.index' => 'podcasts_viewed',
            'podcasts.like' => 'podcast_liked',
            'podcasts.comment' => 'podcast_commented',
            'podcasts.reply' => 'podcast_reply_added',
            'podcasts.comment.delete' => 'podcast_comment_deleted',
            'podcasts.reply.delete' => 'podcast_reply_deleted',
            'podcasts.report' => 'podcast_reported',

            // Articles
            'articles.index' => 'articles_viewed',
            'articles.show' => 'article_viewed',
            'articles.create' => 'article_create_form_viewed',
            'articles.store' => 'article_created',
            'articles.edit' => 'article_edit_form_viewed',
            'articles.update' => 'article_updated',
            'articles.destroy' => 'article_deleted',
            'articles.publish' => 'article_published',
            'articles.restore' => 'article_restored',
            'articles.comment' => 'article_commented',
            'articles.reply' => 'article_reply_added',
            'articles.comment.delete' => 'article_comment_deleted',
            'articles.reply.delete' => 'article_reply_deleted',

            // Forum
            'forum.index' => 'forum_viewed',
            'post.show' => 'post_viewed',
            'post.create' => 'post_created',
            'post.comment' => 'post_commented',
            'post.vote' => 'post_voted',
            'comment.vote' => 'comment_voted',
            'poll.vote' => 'poll_voted',
            'user.block' => 'user_blocked',
            'user.unblock' => 'user_unblocked',
            'report.submit' => 'content_reported',
            'comment.delete' => 'comment_deleted',
            'post.delete' => 'post_deleted',

            // Administration
            'dashboard' => 'dashboard_accessed',
            'users.index' => 'users_list_viewed',
            'users.updateRole' => 'user_role_updated',
            'users.toggleActive' => 'user_status_toggled',
            'dashboard.reports' => 'reports_viewed',
            'dashboard.updateReport' => 'report_updated',
            'dashboard.blocked-users' => 'blocked_users_viewed',

            // Affectations
            'affectations.index' => 'affectations_viewed',
            'affectations.create' => 'affectation_create_form_viewed',
            'affectations.store' => 'affectation_created',
            'affectations.edit' => 'affectation_edit_form_viewed',
            'affectations.update' => 'affectation_updated',
            'affectations.destroy' => 'affectation_deleted',

            // Paramètres
            'settings.index' => 'settings_viewed',
            'settings.update' => 'settings_updated',
        ];

        // Retourner l'action mappée ou une action générique
        if (isset($actionMappings[$routeName])) {
            return $actionMappings[$routeName];
        }

        // Actions génériques basées sur la méthode HTTP
        switch ($method) {
            case 'GET':
                return 'page_viewed';
            case 'POST':
                return 'data_created';
            case 'PUT':
            case 'PATCH':
                return 'data_updated';
            case 'DELETE':
                return 'data_deleted';
            default:
                return 'unknown_action';
        }
    }

    private function logUserActivity(Request $request, Response $response, string $action): void
    {
        try {
            $route = $request->route();
            $routeName = $route?->getName();
            
            // Données de la requête (sans les informations sensibles)
            $requestData = $this->sanitizeRequestData($request->all());
            
            // Description lisible de l'action
            $description = $this->generateDescription($action, $request, $requestData);

            UserLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'route_name' => $routeName,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'request_data' => $requestData,
                'status_code' => $response->getStatusCode(),
                'description' => $description,
            ]);
        } catch (\Exception $e) {
            // Ne pas faire planter l'application si le logging échoue
            \Log::error('Erreur lors du logging de l\'activité utilisateur: ' . $e->getMessage());
        }
    }

    private function sanitizeRequestData(array $data): array
    {
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'current_password',
            '_token',
            'api_token',
        ];

        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[MASQUÉ]';
            }
        }

        return $data;
    }

    private function generateDescription(string $action, Request $request, array $requestData): string
    {
        $user = Auth::user();
        $userName = $user ? $user->name : 'Visiteur';
        
        $descriptions = [
            'login' => "Connexion de l'utilisateur",
            'logout' => "Déconnexion de l'utilisateur",
            'register' => "Inscription d'un nouvel utilisateur",
            'profile_updated' => "Mise à jour du profil",
            'podcast_liked' => "Like sur un podcast",
            'podcast_commented' => "Commentaire ajouté sur un podcast",
            'article_created' => "Création d'un nouvel article",
            'article_updated' => "Modification d'un article",
            'post_created' => "Création d'un nouveau post sur le forum",
            'user_blocked' => "Blocage d'un utilisateur",
            'user_unblocked' => "Déblocage d'un utilisateur",
            'content_reported' => "Signalement de contenu",
            'page_viewed' => "Consultation d'une page",
        ];

        $baseDescription = $descriptions[$action] ?? "Action: {$action}";
        
        return "{$userName} - {$baseDescription}";
    }
}