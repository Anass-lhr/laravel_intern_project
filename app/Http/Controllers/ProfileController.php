<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire d'édition du profil.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Met à jour le profil de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        Log::info('Request data:', $request->all());
        Log::info('Uploaded files:', $request->files->all());

        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ], [
            'avatar.image' => 'Le fichier doit être une image (jpeg, png, jpg, gif).',
            'avatar.mimes' => 'Le fichier doit être de type : jpeg, png, jpg ou gif.',
            'avatar.max' => 'La taille de l\'image ne doit pas dépasser 2 Mo.',
        ]);

        $user = auth()->user();

        // Vérifier si l'utilisateur est connecté via Google/Facebook
        if ($user->provider) {
            // Les utilisateurs Google/Facebook ne peuvent pas modifier leur avatar
            if ($request->hasFile('avatar')) {
                Log::info('Avatar upload attempt by Google/Facebook user blocked.');
                return redirect()->route('profile.edit')->with('error', 'Les utilisateurs connectés via Google ou Facebook ne peuvent pas modifier leur photo de profil.');
            }
        } else {
            // Gérer l'upload manuel de l'avatar pour les utilisateurs non sociaux
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                Log::info('Avatar file detected:', [$request->file('avatar')->getClientOriginalName()]);
                // Supprimer l'ancien avatar s'il existe
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                    Log::info('Old avatar deleted:', [$user->avatar]);
                }

                // Stocker le nouvel avatar
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
                Log::info('New avatar stored at:', [$path]);
            }
        }

        // Mettre à jour les autres champs
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($user->save()) {
            Log::info('User saved successfully:', $user->toArray());
        } else {
            Log::info('User save failed.');
        }

        return redirect()->route('profile.edit')->with('status', 'Profil mis à jour avec succès !');
    }

    /**
     * Supprime le compte de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        // Supprimer l'avatar s'il existe (pour les utilisateurs non sociaux)
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            Log::info('Avatar deleted during account deletion:', [$user->avatar]);
        }

        // Déconnexion et suppression
        auth()->logout();
        $user->delete();

        return redirect('/')->with('status', 'Compte supprimé avec succès.');
    }

    /**
     * Supprime l'avatar de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAvatar(Request $request)
    {
        $user = auth()->user();

        // Vérifier si l'utilisateur est connecté via Google/Facebook
        if ($user->provider) {
            Log::info('Avatar deletion attempt by Google/Facebook user blocked.');
            return redirect()->route('profile.edit')->with('error', 'Les utilisateurs connectés via Google ou Facebook ne peuvent pas supprimer leur photo de profil.');
        }

        // Suppression pour les utilisateurs non sociaux
        if ($user->avatar) {
            // Supprimer l'avatar du stockage
            Storage::disk('public')->delete($user->avatar);
            Log::info('Avatar deleted:', [$user->avatar]);

            // Réinitialiser le champ avatar
            $user->avatar = null;
            $user->save();
            Log::info('User avatar field cleared.');
        }

        return redirect()->route('profile.edit')->with('status', 'Avatar supprimé avec succès !');
    }
}