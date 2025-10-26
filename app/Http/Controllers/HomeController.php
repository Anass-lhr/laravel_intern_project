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


           
            } catch (\Exception $e) {
            \Log::error('Erreur dans fetchYouTubeVideos', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ['error' => 'Erreur lors du chargement des vidéos : ' . $e->getMessage()];
        }
    }
}
