<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class EpisodeController extends Controller
{
    public function index(Request $request)
    {
        $episodes = $this->fetchEpisodes();
        $selectedEpisodeId = $request->query('selected_episode_id');

        if (isset($episodes['error'])) {
            return view('episodes.index', ['error' => $episodes['error']]);
        }
        $episodeCount = count($episodes); // Nombre total d'épisodes
        return view('episodes.index', compact('episodes', 'selectedEpisodeId', 'episodeCount'));
    }

    // Nouvelle méthode pour récupérer les épisodes, réutilisable
        public function fetchEpisodes()
    {
        $cacheKey = 'spotify_episodes_diary_of_a_ceo';
        try {
            $episodes = Cache::remember($cacheKey, now()->addHours(24), function () {
                $api = new SpotifyWebAPI();
                $accessToken = $this->getSpotifyAccessToken();
                $api->setAccessToken($accessToken);
                $showId = '0CRsFPnSw5cPULORbAT0dE';
                $allEpisodes = [];
                $offset = 0;
                $limit = 50;

                do {
                    $response = $api->getShowEpisodes($showId, [
                        'market' => 'FR',
                        'limit' => $limit,
                        'offset' => $offset,
                    ]);
                    $allEpisodes = array_merge($allEpisodes, $response->items);
                    $offset += $limit;
                } while ($response->next !== null); // Continue tant qu'il y a une page suivante

                \Log::info('Episodes fetched:', ['count' => count($allEpisodes), 'episodes' => $allEpisodes]);
                return $allEpisodes;
            });
            return $episodes;
        } catch (\Exception $e) {
            \Log::error('Error fetching episodes: ' . $e->getMessage());
            return ['error' => 'Erreur lors du chargement des épisodes : ' . $e->getMessage()];
        }
    }

    private function getSpotifyAccessToken()
    {
        $session = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET')
        );

        if (!$session->getAccessToken() || $session->getTokenExpired()) {
            $session->requestCredentialsToken();
        }

        return $session->getAccessToken();
    }
}