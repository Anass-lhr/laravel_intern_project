<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    protected $episodeController;

    public function __construct(EpisodeController $episodeController)
    {
        $this->episodeController = $episodeController;
    }

    public function index()
    {
        // Récupérer les épisodes via EpisodeController
        $episodes = $this->episodeController->fetchEpisodes();

        // Si une erreur est retournée, on peut passer l'erreur à la vue
        if (isset($episodes['error'])) {
            $episodes = [];
            $error = $episodes['error'];
        } else {
            // Limiter à 10 épisodes
            $episodes = array_slice($episodes, 0, 10);
            $error = null;
        }

        // Récupérer les vidéos YouTube
        $videos = $this->fetchYouTubeVideos();

        // Récupérer les articles publiés
        $articles = Article::query()
            ->where('is_deleted', false)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(10) // Limiter à 3 articles pour la section "Articles en vedette"
            ->get();

        return view('welcome', compact('episodes', 'error', 'videos', 'articles'));
    }

    /**
     * Récupérer les vidéos YouTube via l'API
     *
     * @return array
     */
    protected function fetchYouTubeVideos()
    {
        $apiKey = config('services.youtube.api_key', 'AIzaSyAScg-HM7-PlWLZ8HEXx6L-2y--g-6bCUQ'); // Utiliser la config
        $channelId = 'UCEZzgq43ou12Kto6mxypvfA';
        $maxVideos = 10;

        try {
            // Étape 1 : Récupérer l'ID de la playlist "Uploads" de la chaîne
            $channelResponse = Http::get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'contentDetails',
                'id' => $channelId,
                'key' => $apiKey,
            ]);

            if (!$channelResponse->successful()) {
                \Log::error('Erreur lors de la récupération des informations de la chaîne', [
                    'status' => $channelResponse->status(),
                    'response' => $channelResponse->body(),
                ]);
                return ['error' => 'Impossible de récupérer les informations de la chaîne.'];
            }

            $channelData = $channelResponse->json();
            if (empty($channelData['items'])) {
                \Log::error('Aucune information de chaîne trouvée.');
                return ['error' => 'Aucune information de chaîne trouvée.'];
            }

            $uploadsPlaylistId = $channelData['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

            // Étape 2 : Récupérer les vidéos de la playlist
            $videosResponse = Http::get('https://www.googleapis.com/youtube/v3/playlistItems', [
                'part' => 'snippet',
                'playlistId' => $uploadsPlaylistId,
                'maxResults' => $maxVideos,
                'key' => $apiKey,
            ]);

            if (!$videosResponse->successful()) {
                \Log::error('Erreur lors de la récupération des vidéos', [
                    'status' => $videosResponse->status(),
                    'response' => $videosResponse->body(),
                ]);
                return ['error' => 'Erreur lors du chargement des vidéos.'];
            }

            $videosData = $videosResponse->json();
            if (empty($videosData['items'])) {
                \Log::error('Aucune vidéo trouvée dans la chaîne.');
                return ['error' => 'Aucune vidéo disponible pour le moment.'];
            }

            // Étape 3 : Vérifier si les vidéos sont intégrables
            $videoIds = collect($videosData['items'])->pluck('snippet.resourceId.videoId')->implode(',');
            $videoDetailsResponse = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'status',
                'id' => $videoIds,
                'key' => $apiKey,
            ]);

            if (!$videoDetailsResponse->successful()) {
                \Log::error('Erreur lors de la récupération des détails des vidéos', [
                    'status' => $videoDetailsResponse->status(),
                    'response' => $videoDetailsResponse->body(),
                ]);
                return ['error' => 'Erreur lors de la vérification des vidéos.'];
            }

            $videoDetails = $videoDetailsResponse->json();

            // Filtrer les vidéos intégrables et formater les données
            $videos = collect($videosData['items'])->filter(function ($video) use ($videoDetails) {
                $videoDetail = collect($videoDetails['items'])->firstWhere('id', $video['snippet']['resourceId']['videoId']);
                return $videoDetail && $videoDetail['status']['embeddable'];
            })->map(function ($video) {
                return [
                    'videoId' => $video['snippet']['resourceId']['videoId'],
                    'title' => $video['snippet']['title'] ?? 'Titre non disponible',
                    'thumbnail' => $video['snippet']['thumbnails']['medium']['url'] ?? 'https://via.placeholder.com/400x225?text=Image+Indisponible',
                    'publishedAt' => $video['snippet']['publishedAt'] ?? now()->toIso8601String(),
                    'description' => $video['snippet']['description'] ?? '',
                ];
            })->sortByDesc('publishedAt')->values()->take($maxVideos)->toArray();

            return $videos;
        } catch (\Exception $e) {
            \Log::error('Erreur dans fetchYouTubeVideos', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ['error' => 'Erreur lors du chargement des vidéos : ' . $e->getMessage()];
        }
    }
}