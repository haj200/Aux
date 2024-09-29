<?php

namespace App\Http\Controllers\Admin;

use App\Models\Conjoint;
use App\Models\Auxiliaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConjointController extends Controller
{
    protected function getAuthenticatedUserId()
    {
        if (Auth::check()) {
            return auth()->guard('web')->id();
        }

        if (Auth::guard('admin')->check()) {
            return auth()->guard('admin')->id();
        }

        return null;
    }

    public function index()
    {
        $conjoints = Conjoint::with('auxiliaire')->paginate(10);
        return view('admin.conjoints.index', compact('conjoints'));
    }
    public function createKnownAux($auxiliaire_id)
    {
        // Récupérer l'auxiliaire en fonction de son ID
        $auxiliaire = Auxiliaire::findOrFail($auxiliaire_id);

        // Passer les données à la vue
        return view('admin.conjoints.createKnownAux', ['auxiliaire' => $auxiliaire]);
    }
    // Enregistrer un enfant avec l'auxiliaire_id
    public function storeKnownAux(Request $request, $auxiliaire_id)
    {
        // Validation des données
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'CNIE' => 'required|string|max:255',
        ]);

        // Récupérer l'ID de l'utilisateur authentifié
        $userId = $this->getAuthenticatedUserId(); // Utilisation de ta fonction personnalisée

        // Création de l'enfant associé à l'auxiliaire
        Conjoint::create([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'CNIE' => $request->CNIE,
            'user_id' => $userId,
            'updated_by' => $userId,
            'auxiliaire_id' => $auxiliaire_id,  // L'enfant est associé à l'auxiliaire

        ]);

        // Redirection avec un message de succès
        return redirect()->route('enfants.index')->with('success', 'Enfant ajouté avec succès.');
    }

    public function create()
    {
        $auxiliaires = Auxiliaire::all();
        return view('admin.conjoints.create', compact('auxiliaires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'CNIE' => 'required|string|max:255',
            'auxiliaire_id' => 'required|exists:auxiliaires,id',
        ]);

        $userId = $this->getAuthenticatedUserId();

        Conjoint::create([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'CNIE' => $request->CNIE,
            'user_id' => $userId,
            'updated_by' => $userId,
            'auxiliaire_id' => $request->auxiliaire_id,
        ]);

        return redirect()->route('conjoints.index')->with('success', 'Conjoint ajouté avec succès.');
    }

    public function edit($id)
    {
        $conjoint = Conjoint::find($id);
        $auxiliaires = Auxiliaire::all();
        return view('admin.conjoints.edit', compact('conjoint', 'auxiliaires'));
    }

    public function update(Request $request, Conjoint $conjoint)
    {
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'CNIE' => 'required|string|max:255',
            'auxiliaire_id' => 'required|exists:auxiliaires,id',
        ]);

        $userId = $this->getAuthenticatedUserId();

        $conjoint->update([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'CNIE' => $request->CNIE,
            'updated_by' => $userId,
            'auxiliaire_id' => $request->auxiliaire_id,
        ]);

        return redirect()->route('conjoints.index')->with('success', 'Conjoint mis à jour avec succès.');
    }

    public function destroy(Conjoint $conjoint)
    {
        $conjoint->delete();
        return redirect()->route('conjoints.index')->with('success', 'Conjoint supprimé avec succès.');
    }

    public function show(Conjoint $conjoint)
    {
        return view('admin.conjoints.show', compact('conjoint'));
    }
}
