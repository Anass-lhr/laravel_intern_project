<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        $allowedProviders = ['google', 'facebook'];
        if (!in_array($provider, $allowedProviders)) {
            return redirect()->route('login')->with('error', 'Provider non pris en charge.');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            // Récupération de l'utilisateur via Socialite
            $socialUser = Socialite::driver($provider)->user();
            Log::info('Utilisateur connecté via ' . $provider, ['email' => $socialUser->email]);

            $avatarUrl = $socialUser->avatar;
            $avatarPath = null;

            // Télécharger l'avatar si disponible
            if ($avatarUrl) {
                Log::info('Avatar trouvé pour l\'utilisateur', ['avatar_url' => $avatarUrl]);

                $response = Http::get($avatarUrl);
                if ($response->successful()) {
                    $contentType = $response->header('Content-Type');
                    $extension = 'jpg';
                    if (strpos($contentType, 'png') !== false) {
                        $extension = 'png';
                    } elseif (strpos($contentType, 'gif') !== false) {
                        $extension = 'gif';
                    }

                    $fileName = 'avatars/' . time() . '_' . $socialUser->id . '.' . $extension;
                    if (Storage::disk('public')->put($fileName, $response->body())) {
                        $avatarPath = $fileName;
                        Log::info('Avatar téléchargé et stocké', ['avatar_path' => $avatarPath]);
                    } else {
                        Log::error('Échec du téléchargement de l\'avatar');
                    }
                } else {
                    Log::error('Erreur lors du téléchargement de l\'avatar', ['status' => $response->status()]);
                }
            } else {
                Log::warning('Aucun avatar trouvé pour l\'utilisateur');
            }

            // Vérifier si l'utilisateur existe déjà dans la base
            $user = User::where('email', $socialUser->email)->first();

            if ($user) {
                Log::info('Utilisateur existant trouvé', ['user_id' => $user->id]);

                // Mettre à jour l'utilisateur avec les informations de provider
                $user->provider = $provider;
                $user->provider_id = $socialUser->id;

                // Mettre à jour l'avatar si disponible
                if ($avatarPath) {
                    $user->avatar = $avatarPath;
                }

                $user->save();
                Log::info('Utilisateur mis à jour avec succès');

                Auth::login($user, true);
            } else {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => bcrypt(uniqid()),
                    'provider' => $provider,
                    'provider_id' => $socialUser->id,
                    'avatar' => $avatarPath,
                ]);

                Log::info('Nouvel utilisateur créé', ['user_id' => $user->id]);

                Auth::login($user, true);
            }

            return redirect()->intended('/dashboard');

        } catch (Exception $e) {
            Log::error('Erreur lors de la connexion avec le provider', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', "Erreur lors de la connexion avec {$provider}.");
        }
    }
}
