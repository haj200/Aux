<?php

namespace App\Http\Controllers;

use App\Models\Auxiliaire;
use App\Models\Conjoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConjointUserController extends Controller
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
        $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Get the associated territorial entity
        $id = Auth::user()->id;
        $user = User::findOrfail($id);
        $conjoints = $user->conjoints()->paginate(10); // Get the user's children
        
        return view('account.conjoints.index', compact('conjoints','entiteTerritoriale'));
    }
    public function createKnownAux($auxiliaire_id)
    {
        // Récupérer l'auxiliaire en fonction de son ID
        $auxiliaire = Auxiliaire::findOrFail($auxiliaire_id);
        $entiteTerritoriale = Auth::user()->entiteTerritoriale;
        // Passer les données à la vue
        return view('account.conjoints.createKnownAux', compact('entiteTerritoriale','auxiliaire'));
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
        return redirect()->route('account.conjoints.index')->with('success', 'Enfant ajouté avec succès.');
    }

    public function create()
    {
        $entiteTerritoriale = Auth::user()->entiteTerritoriale;
        $auxiliaires = Auxiliaire::where('user_id', Auth::id())->get();
        return view('account.conjoints.create', compact('auxiliaires','entiteTerritoriale'));
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

        Conjoint::create([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'CNIE' => $request->CNIE,
            'user_id' => Auth::id(),
            'updated_by' => Auth::id(),
            'auxiliaire_id' => $request->auxiliaire_id,
        ]);

        return redirect()->route('account.conjoints.index')->with('success', 'Conjoint ajouté avec succès.');
    }

    public function edit($id)
    {
        $entiteTerritoriale = Auth::user()->entiteTerritoriale;
        $conjoint = Conjoint::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $auxiliaires = Auxiliaire::where('user_id', Auth::id())->get();
        return view('account.conjoints.edit', compact('conjoint', 'auxiliaires','entiteTerritoriale'));
    }

    public function update(Request $request, $id)
    {
        $conjoint = Conjoint::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'CNIE' => 'required|string|max:255' . $conjoint->id,
            'auxiliaire_id' => 'required|exists:auxiliaires,id',
        ]);

        $conjoint->update([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'CNIE' => $request->CNIE,
            'updated_by' => Auth::id(),
            'auxiliaire_id' => $request->auxiliaire_id,
        ]);

        return redirect()->route('account.conjoints.index')->with('success', 'Conjoint mis à jour avec succès.');
    }

    public function show($id)
    {
        $entiteTerritoriale = Auth::user()->entiteTerritoriale;
        $conjoint = Conjoint::with('auxiliaire')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('account.conjoints.show', compact('conjoint','entiteTerritoriale'));
    }

    public function destroy($id)
    {
        $conjoint = Conjoint::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $conjoint->delete();

        return redirect()->route('account.conjoints.index')->with('success', 'Conjoint supprimé avec succès.');
    }
}
