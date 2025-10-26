<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\User;
use App\Models\AncienAdmin;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->with('affectation')->get();
        return view('affectations.index', compact('admins'));
    }

    public function create()
    {
        if (!auth()->user() || auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $admins = User::where('role', 'admin')->get();
        $modules = ['podcast', 'article', 'forum', 'config']; // modules possibles
        return view('affectations.create', compact('admins', 'modules'));
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id|unique:affectations,user_id',
        'modules' => 'required|array', 
    ]);

    Affectation::create([
        'user_id' => $request->user_id,
        'modules' => $request->modules, 
    ]);

    return redirect()->route('affectations.index')->with('success', 'Affectation enregistrée.');
}

    public function edit($id)
    {
        $user = User::with('affectation')->findOrFail($id);
        $modules = ['podcast', 'article', 'forum', 'config'];
        return view('affectations.edit', compact('user', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'modules' => 'sometimes|array',
        ]);
    
        // Si aucun module n'est sélectionné, on initialise un tableau vide
        $selectedModules = $request->modules ?? [];
        
        $affectation = $user->affectation;
    
        if ($affectation) {
            $affectation->update([
                'modules' => $selectedModules, 
            ]);
        } else {
            Affectation::create([
                'user_id' => $user->id,
                'modules' => $selectedModules, 
            ]);
        }
    
        // Si c'est une requête AJAX, retourner une réponse JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Modules mis à jour avec succès.'
            ]);
        }
    
        // Sinon, rediriger avec un message de succès (comportement par défaut)
        return redirect()->route('affectations.edit', $user->id)
            ->with('success', 'Modules mis à jour avec succès.');
    }

    public function destroy(Affectation $affectation)
    {
        if (!auth()->user() || auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $affectation->delete();
        return redirect()->route('affectations.index')->with('success', 'Affectation supprimée.');
    }
    public function anciensAdmins()
    {
        $oldAdmins = AncienAdmin::orderBy('end_date', 'desc')->get();
        return view('affectations.anciens_admins', compact('oldAdmins'));
    }
}