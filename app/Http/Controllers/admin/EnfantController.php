<?php

namespace App\Http\Controllers\Admin;

use App\Models\Enfant;
use App\Models\Auxiliaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnfantController extends Controller
{
    protected function getAuthenticatedUserId()
    {
        // Try default guard first
        if (Auth::check()) {
            return auth()->guard('web')->id();
        }

        // Fallback to admin guard
        if (Auth::guard('admin')->check()) {
            return auth()->guard('admin')->id();
        }

        // If no user is authenticated
        return null;
    }

    public function index()
    {
        $enfants = Enfant::with(['auxiliaire', 'creator', 'updater'])->paginate(10);
        return view('admin.enfants.index', compact('enfants'));
    }


    // Display the form to add an enfant with a known auxiliaire_id
    public function createKnownAux($auxiliaire_id)
{
    // Récupérer l'auxiliaire en fonction de son ID
    $auxiliaire = Auxiliaire::findOrFail($auxiliaire_id);

    // Passer les données à la vue
    return view('admin.enfants.createKnownAux', ['auxiliaire' => $auxiliaire]);
}

    // Store the enfant data and associate it with the known auxiliaire_id
    public function storeKnownAux(Request $request)
    {
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'Date_De_Naissance' => 'required|date',
            'auxiliaire_id' => 'required|exists:auxiliaires,id',
        ]);

        $userId = $this->getAuthenticatedUserId();

        Enfant::create([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'Date_De_Naissance' => $request->Date_De_Naissance,
            'auxiliaire_id' => $request->auxiliaire_id,  // Associating the enfant with the known auxiliaire
            'user_id' => $userId,
            'updated_by' => $userId,
        ]);

        return redirect()->route('enfants.index')->with('success', 'Enfant ajouté avec succès.');
    }
    public function create()
    {
        $auxiliaires = Auxiliaire::all();

        return view('admin.enfants.create' , compact('auxiliaires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'Date_De_Naissance' => 'required|date',
            'auxiliaire_id' => 'required|exists:auxiliaires,id',
        ]);

        $userId = $this->getAuthenticatedUserId();

        Enfant::create([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'Date_De_Naissance' => $request->Date_De_Naissance,
            'auxiliaire_id' => $request->auxiliaire_id,
            'user_id' => $userId,
            'updated_by' => $userId,
        ]);

        return redirect()->route('enfants.show')->with('success', 'Enfant ajouté avec succès.');
    }


    public function edit($id)
    {
        $enfant = Enfant::find($id);
        $auxiliaires = Auxiliaire::all();
        return view('admin.enfants.edit', compact('enfant', 'auxiliaires'));
    }

    public function update(Request $request, Enfant $enfant)
    {
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'Date_De_Naissance' => 'required|date',
            'auxiliaire_id' => 'required|exists:auxiliaires,id',
        ]);

        $userId = $this->getAuthenticatedUserId();

        if (!$userId) {
            return redirect()->back()->withErrors(['user' => 'Utilisateur non authentifié.'])->withInput();
        }

        $enfant->update([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'Date_De_Naissance' => $request->Date_De_Naissance,
            'auxiliaire_id' => $request->auxiliaire_id,
            'updated_by' => $userId,
        ]);

        return redirect()->route('enfants.index')->with('success', 'Enfant mis à jour avec succès.');
    }

    public function destroy(Enfant $enfant)
    {
        $enfant->delete();
        return redirect()->route('enfants.index')->with('success', 'Enfant supprimé avec succès.');
    }

    public function show(Enfant $enfant)
    {
        return view('admin.enfants.show', compact('enfant'));
    }
}
