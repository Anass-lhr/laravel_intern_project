<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                abort(403, 'Accès non autorisé');
            }

            $user = auth()->user();
            if ($user->role === 'superadmin' || ($user->role === 'admin' && $user->is_active && $user->affectation && in_array('config', $user->affectation->modules ?? []))) {
                return $next($request);
            }

            abort(403, 'Accès non autorisé : Vous n\'êtes pas autorisé à modifier les paramètres.');
        });
    }

    public function index()
    {
        // Récupérer ou créer les paramètres
        $settings = Setting::first() ?? Setting::create([
            'primary_color' => '#1EB5AD', // Valeur par défaut
        ]);
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            // Récupérer ou créer les paramètres
            $settings = Setting::first();
            
            if (!$settings) {
                $settings = new Setting(['primary_color' => '#1EB5AD']);
            }

            // Validation des données
            $data = $request->validate([
                'facebook_url' => 'nullable|url',
                'youtube_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
                'linkedin_url' => 'nullable|url',
                'email' => 'nullable|email|max:255',
            ]);

            // Validation additionnelle pour les superadmins ou admins avec module config
            $user = auth()->user();
            if ($user->role === 'superadmin' || ($user->role === 'admin' && $user->affectation && in_array('config', $user->affectation->modules ?? []))) {
                $request->validate([
                    'primary_color' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
                ]);

                // Ajouter la couleur principale aux données
                if ($request->filled('primary_color')) {
                    $data['primary_color'] = $request->primary_color;
                }
            }

            // Ajouter l'ID de l'utilisateur qui a fait la modification
            $data['modified_by'] = auth()->id();
            
            // Mettre à jour les paramètres
            $settings->fill($data);
            $settings->save();

            // Vider tous les caches liés aux paramètres pour refléter les changements
            Cache::forget('settings');
            Cache::forget('app_settings');
            Cache::forget('site_settings');
            
            // Log pour débogage
            \Log::info('Paramètres mis à jour avec succès : ', $settings->toArray());

            return redirect()->route('settings.index')->with('success', 'Paramètres mis à jour avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour des paramètres : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage())->withInput();
        }
    }
}