<?php

namespace App\Http\Controllers;

use App\Models\Auxiliaire;
use App\Models\Enfant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnfantUserController extends Controller
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
        $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Get the associated territorial entity
        $id = Auth::user()->id;
        $user = User::findOrfail($id);
        $enfants = $user->enfants()->paginate(10); // Get the user's children
        return view('account.enfants.index', compact('enfants', 'entiteTerritoriale'));
    }

    public function create()
    {
        $auxiliaires = Auxiliaire::where('user_id', Auth::id())->get();
        $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Logic to get the territorial entity
        return view('account.enfants.create', compact('entiteTerritoriale','auxiliaires'));
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

        return redirect()->route('account.enfants.index')->with('success', 'Enfant ajouté avec succès.');
    }
    public function createKnownAux($auxiliaire_id)
{
    // Récupérer l'auxiliaire en fonction de son ID
    $auxiliaire = Auxiliaire::findOrFail($auxiliaire_id);
    $entiteTerritoriale = Auth::user()->entiteTerritoriale;
    // Passer les données à la vue
    return view('account.enfants.createKnownAux', compact('auxiliaire','entiteTerritoriale'));
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

        return redirect()->route('account.enfants.index')->with('success', 'Enfant ajouté avec succès.');
    }

    
    public function edit(Enfant $enfant)
    {
        $auxiliaires = Auxiliaire::where('user_id', Auth::id())->get();
        $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Logic to get the territorial entity
        return view('account.enfants.edit', compact('enfant', 'entiteTerritoriale','auxiliaires'));
    }

    public function update(Request $request, Enfant $enfant)
    {
        $validated = $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'Date_De_Naissance' => 'required|date',
        ]);

        $enfant->update($validated);
        return redirect()->route('account.enfants.index')->with('success', 'Enfant mis à jour avec succès.');
    }

    public function destroy(Enfant $enfant)
    {
        $enfant->delete();
        return redirect()->route('account.enfants.index')->with('success', 'Enfant supprimé avec succès.');
    }

    public function show($id)
    {
        $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Logic to get the territorial entity
        // Find the child by its ID
        $enfant = Enfant::findOrFail($id);

        // Get the associated user
        $id = Auth::user()->id;
        $user = User::findOrfail($id);

        // Pass data to the view
        return view('account.enfants.show', compact('enfant', 'user', 'entiteTerritoriale'));
    }
}
