<?php

namespace App\Http\Controllers;

use App\Models\PodcastComment;
use App\Models\PodcastCommentReply;
use App\Models\PodcastLike;
use App\Models\PodcastsCommentReport;
use App\Models\BlockedUser;
use App\Models\DeletedCommentsPodcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    /**
     * Affiche la liste des vidéos YouTube et les éventuelles erreurs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $errorMessage = null;
        $isBlocked = false;

        // Vérifier si l'utilisateur est connecté et bloqué
        if (Auth::check()) {
            $isBlocked = BlockedUser::where('user_id', Auth::id())->exists();
        }

        // Récupérer les vidéos depuis le cache ou l'API YouTube
        $videos = Cache::remember('youtube_videos', now()->addHours(24), function () use (&$errorMessage) {
            $apiKey = config('services.youtube.api_key');
            $channelHandle = '@AbderrazakYousfi';
            $maxResults = 50;
            $videos = [];
            $nextPageToken = '';

            if (empty($apiKey)) {
                $errorMessage = 'Clé API YouTube manquante dans la configuration.';
                Log::error($errorMessage);
                return [];
            }

            try {
                // Récupérer les détails de la chaîne
                $channelResponse = Http::get('https://www.googleapis.com/youtube/v3/channels', [
                    'part' => 'contentDetails',
                    'forHandle' => $channelHandle,
                    'key' => $apiKey,
                ]);

                if (!$channelResponse->successful()) {
                    $errorMessage = 'Erreur lors de la récupération des détails de la chaîne: ' . $channelResponse->body();
                    Log::error($errorMessage);
                    return [];
                }

                $channelData = $channelResponse->json();
                if (!isset($channelData['items'][0]['contentDetails']['relatedPlaylists']['uploads'])) {
                    $errorMessage = 'Playlist des uploads non trouvée pour la chaîne.';
                    Log::error($errorMessage);
                    return [];
                }

                $uploadsPlaylistId = $channelData['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

                // Récupérer les vidéos de la playlist
                do {
                    $response = Http::get('https://www.googleapis.com/youtube/v3/playlistItems', [
                        'part' => 'snippet',
                        'playlistId' => $uploadsPlaylistId,
                        'maxResults' => $maxResults,
                        'pageToken' => $nextPageToken,
                        'key' => $apiKey,
                    ]);

                    if (!$response->successful()) {
                        $errorMessage = 'Erreur lors de la récupération des vidéos: ' . $response->body();
                        Log::error($errorMessage);
                        return [];
                    }

                    $data = $response->json();
                    foreach ($data['items'] as $item) {
                        $videos[] = [
                            'videoId' => $item['snippet']['resourceId']['videoId'],
                            'title' => $item['snippet']['title'],
                            'description' => substr($item['snippet']['description'], 0, 100) . (strlen($item['snippet']['description']) > 100 ? '...' : ''),
                            'thumbnail' => $item['snippet']['thumbnails']['medium']['url'] ?? 'https://via.placeholder.com/320x180',
                            'publishedAt' => $item['snippet']['publishedAt'],
                        ];
                    }
                    $nextPageToken = $data['nextPageToken'] ?? '';
                } while ($nextPageToken);

                return $videos;
            } catch (\Exception $e) {
                $errorMessage = 'Erreur YouTube API: ' . $e->getMessage();
                Log::error($errorMessage);
                return [];
            }
        });

        return view('podcasts', [
            'videos' => collect($videos),
            'errorMessage' => $errorMessage,
            'isBlocked' => $isBlocked,
        ]);
    }

    /**
     * Gère le "j'aime" ou "je n'aime plus" pour une vidéo.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleLike(Request $request)
    {
        $user = Auth::user();
        if ($user && BlockedUser::where('user_id', $user->id)->exists()) {
            return response()->json([], 204);
        }

        try {
            $request->validate([
                'video_id' => 'required|string',
            ]);

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour liker une vidéo.'], 401);
            }

            $videoId = $request->video_id;

            // Récupérer le nombre de "j'aime" de YouTube
            $apiKey = config('services.youtube.api_key');
            $youtubeLikeCount = 0;

            if (!empty($apiKey)) {
                $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                    'part' => 'statistics',
                    'id' => $videoId,
                    'key' => $apiKey,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['items'][0]['statistics']['likeCount'])) {
                        $youtubeLikeCount = (int) $data['items'][0]['statistics']['likeCount'];
                    } else {
                        Log::warning("Impossible de récupérer le nombre de 'j'aime' de YouTube pour la vidéo ID: {$videoId}");
                    }
                } else {
                    Log::error("Erreur lors de la récupération des statistiques de YouTube: " . $response->body());
                }
            } else {
                Log::error("Clé API YouTube manquante dans la configuration.");
            }

            // Vérifier si l'utilisateur a déjà aimé cette vidéo
            $existingLike = PodcastLike::where('user_id', $user->id)
                                      ->where('video_id', $videoId)
                                      ->first();

            $liked = false;
            if ($existingLike) {
                // Si l'utilisateur a déjà aimé, supprimer son "j'aime"
                $existingLike->delete();
            } else {
                // Sinon, ajouter un nouveau "j'aime" pour cet utilisateur
                PodcastLike::create([
                    'user_id' => $user->id,
                    'video_id' => $videoId,
                ]);
                $liked = true;
            }

            // Compter tous les "j'aime" locaux pour cette vidéo
            $localLikeCount = PodcastLike::where('video_id', $videoId)->count();

            // Calculer le nombre total de "j'aime" (YouTube + locaux)
            $totalLikeCount = $youtubeLikeCount + $localLikeCount;

            return response()->json([
                'status' => 'success',
                'liked' => $liked,
                'like_count' => $totalLikeCount,
                'youtube_likes' => $youtubeLikeCount,
                'local_likes' => $localLikeCount,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans toggleLike: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de la gestion du like: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Récupère le nombre de "j'aime" pour une vidéo.
     *
     * @param string $videoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLikeCount($videoId)
    {
        try {
            // Récupérer le nombre de "j'aime" de YouTube
            $apiKey = config('services.youtube.api_key');
            $youtubeLikeCount = 0;

            if (!empty($apiKey)) {
                $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                    'part' => 'statistics',
                    'id' => $videoId,
                    'key' => $apiKey,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['items'][0]['statistics']['likeCount'])) {
                        $youtubeLikeCount = (int) $data['items'][0]['statistics']['likeCount'];
                    }
                }
            }

            // Compter les "j'aime" locaux
            $localLikeCount = PodcastLike::where('video_id', $videoId)->count();

            // Vérifier si l'utilisateur actuel a aimé la vidéo
            $user = Auth::user();
            $liked = $user ? PodcastLike::where('user_id', $user->id)
                                       ->where('video_id', $videoId)
                                       ->exists() : false;

            // Calculer le total
            $totalLikeCount = $youtubeLikeCount + $localLikeCount;

            return response()->json([
                'status' => 'success',
                'liked' => $liked,
                'like_count' => $totalLikeCount,
                'youtube_likes' => $youtubeLikeCount,
                'local_likes' => $localLikeCount,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans getLikeCount: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de la récupération des likes: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Ajoute un commentaire à une vidéo.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request)
    {
        $user = Auth::user();
        if ($user && BlockedUser::where('user_id', $user->id)->exists()) {
            return response()->json([], 204);
        }

        try {
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour commenter.'], 401);
            }

            $request->validate([
                'video_id' => 'required|string',
                'content' => 'required|string|max:1000',
            ]);

            $comment = PodcastComment::create([
                'user_id' => $user->id,
                'video_id' => $request->video_id,
                'content' => $request->content,
            ]);

            return response()->json([
                'status' => 'success',
                'id' => $comment->id,
                'author' => $user->name,
                'avatar' => $user->avatar ? Storage::url($user->avatar) : 'https://via.placeholder.com/40',
                'content' => $comment->content,
                'timestamp' => $comment->created_at->toDateTimeString(),
                'replies' => [],
                'from_youtube' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans addComment: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de l\'ajout du commentaire: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Ajoute une réponse à un commentaire existant.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addReply(Request $request)
    {
        $user = Auth::user();
        if ($user && BlockedUser::where('user_id', $user->id)->exists()) {
            return response()->json([], 204);
        }

        try {
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour répondre.'], 401);
            }

            $validated = $request->validate([
                'comment_id' => 'required|exists:podcast_comments,id',
                'content' => 'required|string|max:1000',
            ]);

            $reply = PodcastCommentReply::create([
                'user_id' => $user->id,
                'comment_id' => $validated['comment_id'],
                'content' => $validated['content'],
            ]);

            Log::info("Réponse ajoutée - ID: {$reply->id}, Commentaire parent ID: {$validated['comment_id']}, Utilisateur ID: {$user->id}, Contenu: {$reply->content}");

            return response()->json([
                'status' => 'success',
                'id' => (int)$reply->id,
                'author' => $user->name,
                'avatar' => $user->avatar ? Storage::url($user->avatar) : 'https://via.placeholder.com/40',
                'content' => $reply->content,
                'timestamp' => $reply->created_at->toDateTimeString(),
                'parentId' => (int)$validated['comment_id'],
                'replies' => [], // No nested replies
                'from_youtube' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans addReply: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de la réponse: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Supprime un commentaire.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment($id)
    {
        $user = Auth::user();
        if ($user && BlockedUser::where('user_id', $user->id)->exists()) {
            return response()->json([], 204);
        }

        try {
            $comment = PodcastComment::findOrFail($id);
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour supprimer un commentaire.'], 401);
            }

            // Vérifier si l'utilisateur est superadmin ou un admin affecté au module podcast
            $hasPodcastPermission = $user->role === 'superadmin' ||
                                   ($user->role === 'admin' && $user->affectation && in_array('podcast', $user->affectation->modules));

            // Autoriser la suppression si :
            // - L'utilisateur est superadmin
            // - L'utilisateur est admin avec le module podcast
            // - L'utilisateur est le propriétaire du commentaire
            if ($hasPodcastPermission || $comment->user_id === $user->id) {
                // Enregistrer le commentaire dans deleted_comments_podcast
                DeletedCommentsPodcast::create([
                    'content' => $comment->content,
                    'video_id' => $comment->video_id,
                    'user_id' => $comment->user_id,
                    'parent_id' => null, // Commentaire principal, pas de parent
                    'deleted_by' => $user->id,
                    'deleted_at' => now(),
                ]);

                // Supprimer les réponses associées
                $replies = PodcastCommentReply::where('comment_id', $id)->get();
                foreach ($replies as $reply) {
                    DeletedCommentsPodcast::create([
                        'content' => $reply->content,
                        'video_id' => $comment->video_id,
                        'user_id' => $reply->user_id,
                        'parent_id' => $reply->comment_id,
                        'deleted_by' => $user->id,
                        'deleted_at' => now(),
                    ]);
                    $reply->delete();
                }

                // Supprimer le commentaire
                $comment->delete();

                Log::info("Suppression du commentaire ID: {$id} par l'utilisateur ID: {$user->id} (rôle: {$user->role})");
                return response()->json(['status' => 'success', 'message' => 'Commentaire supprimé avec succès.']);
            }

            return response()->json(['status' => 'error', 'message' => 'Vous n\'avez pas la permission de supprimer ce commentaire.'], 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Commentaire ID {$id} non trouvé.");
            return response()->json(['status' => 'error', 'message' => 'Commentaire non trouvé.'], 404);
        } catch (\Exception $e) {
            Log::error('Erreur dans deleteComment: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de la suppression du commentaire: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Supprime une réponse à un commentaire.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteReply($id)
    {
        $user = Auth::user();
        if ($user && BlockedUser::where('user_id', $user->id)->exists()) {
            return response()->json([], 204);
        }

        try {
            $reply = PodcastCommentReply::findOrFail($id);
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour supprimer une réponse.'], 401);
            }

            // Vérifier si l'utilisateur est superadmin ou un admin affecté au module podcast
            $hasPodcastPermission = $user->role === 'superadmin' ||
                                   ($user->role === 'admin' && $user->affectation && in_array('podcast', $user->affectation->modules));

            // Autoriser la suppression si :
            // - L'utilisateur est superadmin
            // - L'utilisateur est admin avec le module podcast
            // - L'utilisateur est le propriétaire de la réponse
            if ($hasPodcastPermission || $reply->user_id === $user->id) {
                // Enregistrer la réponse dans deleted_comments_podcast
                DeletedCommentsPodcast::create([
                    'content' => $reply->content,
                    'video_id' => $reply->comment->video_id,
                    'user_id' => $reply->user_id,
                    'parent_id' => $reply->comment_id,
                    'deleted_by' => $user->id,
                    'deleted_at' => now(),
                ]);

                // Supprimer la réponse
                $reply->delete();

                Log::info("Suppression de la réponse ID: {$id} par l'utilisateur ID: {$user->id} (rôle: {$user->role})");
                return response()->json(['status' => 'success', 'message' => 'Réponse supprimée avec succès.']);
            }

            return response()->json(['status' => 'error', 'message' => 'Vous n\'avez pas la permission de supprimer cette réponse.'], 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Réponse ID {$id} non trouvée.");
            return response()->json(['status' => 'error', 'message' => 'Réponse non trouvée.'], 404);
        } catch (\Exception $e) {
            Log::error('Erreur dans deleteReply: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de la suppression de la réponse: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Récupère les commentaires (locaux et YouTube) pour une vidéo.
     *
     * @param string $videoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments($videoId)
    {
        try {
            // Récupérer les commentaires locaux avec leurs réponses
            $localComments = PodcastComment::where('video_id', $videoId)
                ->with(['user', 'replies.user'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'author' => $comment->user->name,
                        'avatar' => $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://via.placeholder.com/40',
                        'content' => $comment->content,
                        'timestamp' => $comment->created_at->toDateTimeString(),
                        'replies' => $this->buildReplyTree($comment->replies),
                        'from_youtube' => false,
                    ];
                })->values();

            $apiKey = config('services.youtube.api_key');
            $comments = $localComments;

            if (!empty($apiKey)) {
                try {
                    $youtubeComments = [];
                    $nextPageToken = '';

                    do {
                        $response = Http::get('https://www.googleapis.com/youtube/v3/commentThreads', [
                            'part' => 'snippet',
                            'videoId' => $videoId,
                            'maxResults' => 50,
                            'pageToken' => $nextPageToken,
                            'key' => $apiKey,
                        ]);

                        if ($response->successful()) {
                            $data = $response->json();
                            if (isset($data['items'])) {
                                $newComments = collect($data['items'])->map(function ($item) {
                                    $comment = $item['snippet']['topLevelComment']['snippet'];
                                    return [
                                        'id' => $item['id'],
                                        'author' => $comment['authorDisplayName'],
                                        'avatar' => $comment['authorProfileImageUrl'] ?? 'https://via.placeholder.com/40',
                                        'content' => $comment['textDisplay'],
                                        'timestamp' => date('Y-m-d H:i:s', strtotime($comment['publishedAt'])),
                                        'replies' => [], // No replies for YouTube comments
                                        'from_youtube' => true,
                                    ];
                                })->values();

                                $youtubeComments = array_merge($youtubeComments, $newComments->toArray());
                            }
                            $nextPageToken = $data['nextPageToken'] ?? '';
                        } else {
                            Log::error('Erreur lors de la récupération des commentaires YouTube: ' . $response->body());
                            break;
                        }
                    } while ($nextPageToken);

                    // Fusionner les commentaires locaux et YouTube
                    $comments = collect(array_merge($localComments->toArray(), $youtubeComments))
                        ->sortByDesc('timestamp')
                        ->values();
                } catch (\Exception $e) {
                    Log::error('Erreur lors de la récupération des commentaires YouTube: ' . $e->getMessage());
                }
            }

            return response()->json(['status' => 'success', 'comments' => $comments->values()->all()]);
        } catch (\Exception $e) {
            Log::error('Erreur dans getComments: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de la récupération des commentaires: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Construit la liste des réponses (non imbriquées).
     *
     * @param \Illuminate\Database\Eloquent\Collection $replies
     * @return array
     */
    private function buildReplyTree($replies)
    {
        $result = [];

        foreach ($replies as $reply) {
            $result[] = [
                'id' => $reply->id,
                'author' => $reply->user->name,
                'avatar' => $reply->user->avatar ? Storage::url($reply->user->avatar) : 'https://via.placeholder.com/40',
                'content' => $reply->content,
                'timestamp' => $reply->created_at->toDateTimeString(),
                'parentId' => $reply->comment_id,
                'replies' => [], // No nested replies
                'from_youtube' => false,
            ];
        }

        return $result;
    }

    /**
     * Signale un commentaire ou une réponse.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportComment(Request $request)
    {
        $user = Auth::user();
        if ($user && BlockedUser::where('user_id', $user->id)->exists()) {
            return response()->json([], 204);
        }

        try {
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour signaler un commentaire.'], 401);
            }

            $request->validate([
                'comment_id' => 'nullable|integer|exists:podcast_comments,id',
                'reply_id' => 'nullable|integer|exists:podcast_comment_replies,id',
                'reason_category' => 'required|in:Contenu inapproprié,Spam,Harcèlement,Désinformation,Autre',
                'reason_details' => 'required|string|max:1000',
            ]);

            // Vérifier que soit comment_id soit reply_id est fourni, mais pas les deux
            if (!$request->comment_id && !$request->reply_id) {
                return response()->json(['status' => 'error', 'message' => 'Vous devez spécifier un commentaire ou une réponse à signaler.'], 400);
            }
            if ($request->comment_id && $request->reply_id) {
                return response()->json(['status' => 'error', 'message' => 'Vous ne pouvez signaler qu\'un commentaire ou une réponse à la fois.'], 400);
            }

            // Vérifier si l'utilisateur a déjà signalé ce commentaire ou cette réponse
            $existingReport = PodcastsCommentReport::where('user_id', $user->id)
                ->where(function ($query) use ($request) {
                    if ($request->comment_id) {
                        $query->where('comment_id', $request->comment_id);
                    }
                    if ($request->reply_id) {
                        $query->where('reply_id', $request->reply_id);
                    }
                })
                ->first();

            if ($existingReport) {
                return response()->json(['status' => 'error', 'message' => 'Vous avez déjà signalé ce commentaire ou cette réponse.'], 400);
            }

            // Créer un nouveau signalement
            $report = PodcastsCommentReport::create([
                'user_id' => $user->id,
                'comment_id' => $request->comment_id,
                'reply_id' => $request->reply_id,
                'reason_category' => $request->reason_category,
                'reason_details' => $request->reason_details,
                'status' => 'pending',
            ]);

            Log::info("Signalement créé - ID: {$report->id}, Utilisateur ID: {$user->id}, Commentaire ID: {$request->comment_id}, Réponse ID: {$request->reply_id}, Catégorie: {$request->reason_category}, Détails: {$request->reason_details}");

            return response()->json(['status' => 'success', 'message' => 'Signalement envoyé avec succès.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation dans reportComment: ' . json_encode($e->errors()));
            return response()->json(['status' => 'error', 'message' => 'Erreur de validation: ' . json_encode($e->errors())], 422);
        } catch (\Exception $e) {
            Log::error('Erreur dans reportComment: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors du signalement: ' . $e->getMessage()], 500);
        }
    }
/**
 * Affiche les commentaires supprimés pour les superadmins uniquement.
 *
 * @return \Illuminate\View\View
 */
// Remove this method from PodcastController
public function showDeletedComments()
{
    try {
        $user = Auth::user();
        if (!$user || $user->role !== 'superadmin') {
            return response()->json(['status' => 'error', 'message' => 'Vous n\'avez pas la permission d\'accéder à cette page.'], 403);
        }

        $deletedComments = \App\Models\DeletedCommentsPodcast::with(['user', 'deletedBy', 'parent'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(20);

        return view('dashboard.deleted_comments_podcast', compact('deletedComments'));
    } catch (\Exception $e) {
        Log::error('Erreur dans showDeletedComments: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Erreur lors de la récupération des commentaires supprimés: ' . $e->getMessage()], 500);
    }
}
}