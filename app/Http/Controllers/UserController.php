<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AncienAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'un admin.
     */
    public function createAdmin()
    {
        return view('users.create-admin');
    }

    /**
     * Crée un nouvel admin.
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'admin_since' => now(),
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', 'Admin créé avec succès.');
    }

    /**
     * Met à jour le rôle d'un utilisateur.
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldRole = $user->role;
        
        $request->validate([
            'role' => 'required|in:user,admin,superadmin',
        ]);
        
        // Si l'utilisateur passe d'admin à user, sauvegardons ses affectations
        if ($oldRole === 'admin' && $request->role === 'user') {
            // Vérifier si l'admin avait des affectations
            $affectation = $user->affectation;
            
            if ($affectation) {
                // Créer un enregistrement dans anciens_admins
                AncienAdmin::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'modules' => $affectation->modules, // Correction ici
                    'start_date' => $user->admin_since ?: $affectation->created_at,
                    'end_date' => now()
                ]);
                
                // Supprimer l'affectation
                $affectation->delete();
            }
            
            // Réinitialiser la date admin_since
            $user->admin_since = null;
        }
        // Si l'utilisateur passe de user à admin, enregistrer la date
        elseif ($oldRole !== 'admin' && $request->role === 'admin') {
            $user->admin_since = now();
            
            // S'assurer qu'aucune ancienne affectation ne soit restaurée
            // Si par hasard il y a une affectation, on la supprime
            if ($user->affectation) {
                $user->affectation->delete();
            }
            
            // Pas besoin de créer une nouvelle affectation ici
            // L'administrateur commencera sans modules affectés
        }
        
        // Mettre à jour le rôle
        $user->update([
            'role' => $request->role,
            'admin_since' => $user->admin_since
        ]);
        
        return redirect()->route('users.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function toggleActive(User $user)
    {
        if ($user->role !== 'admin') {
            return back()->with('error', 'Seuls les admins peuvent être activés ou désactivés.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Statut de l\'admin mis à jour.');
    }
}