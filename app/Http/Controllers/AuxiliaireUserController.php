<?php

namespace App\Http\Controllers;

use App\Models\Auxiliaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuxiliaireUserController extends Controller
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
        $auxiliaires = $user->auxiliaires()->paginate(10);; // Get the user's auxiliaries
        return view('account.auxiliaires.index', compact('auxiliaires', 'entiteTerritoriale'));
    }

    public function create()
    {
        $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Logic to get the territorial entity
        return view('account.auxiliaires.create', compact('entiteTerritoriale'));
        
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'Email' => 'required|email',
            'Grade' => 'required|string|max:255',
            'CNIE' => 'required|string|max:255',
            'url_photo' => 'nullable|url',
            'RIB' => 'required|string|max:255',
            'date_de_naissance' => 'required|date',
            'date_de_recrutement' => 'required|date',
            'Type' => 'required|in:rural,urbain',
            'pensionne' => 'required|boolean',
            'entiteterritorielle_id' => 'required|exists:entiteterritorielles,id',
        ]);

        $userId = $this->getAuthenticatedUserId();
        
        

        Auxiliaire::create([
            'Nom_Fr' => $request->Nom_Fr,
            'Prenom_Fr' => $request->Prenom_Fr,
            'Nom_Ar' => $request->Nom_Ar,
            'Prenom_Ar' => $request->Prenom_Ar,
            'Email' => $request->Email,
            'Grade' => $request->Grade,
            'CNIE' => $request->CNIE,
            'url_photo' => $request->url_photo,
            'RIB' => $request->RIB,
            'date_de_naissance' => $request->date_de_naissance,
            'date_de_recrutement' => $request->date_de_recrutement,
            'Type' => $request->Type,
            'pensionne' => $request->pensionne,
            'user_id' => $userId,
            'updated_by' => $userId,
            'entiteterritorielle_id' => $request->entiteterritorielle_id,
        ]);

        return redirect()->route('account.auxiliaires.index')->with('success', 'Auxiliaire ajouté avec succès.');
    }

    public function edit(Auxiliaire $auxiliaire)
    {
        $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Logic to get the territorial entity
        return view('account.auxiliaires.edit', compact('auxiliaire', 'entiteTerritoriale'));
    }

    public function update(Request $request, Auxiliaire $auxiliaire)
    {
        $validated = $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255', // Added missing validation
            'Prenom_Ar' => 'required|string|max:255', // Added missing validation
            'Email' => 'required|email|max:255', // Added missing validation
            'Grade' => 'required|string|max:255', // Added missing validation
            'CNIE' => 'required|string|max:255', // Added missing validation
            'url_photo' => 'nullable|url',
            'RIB' => 'required|string|max:255', // Added missing validation
            'date_de_naissance' => 'required|date', // Added missing validation
            'date_de_recrutement' => 'required|date', // Added missing validation
            'Type' => 'required|in:rural,urbain', // Added missing validation
            'pensionne' => 'required|boolean', // Added missing validation
        ]);

        $auxiliaire->update($validated);
        return redirect()->route('account.auxiliaires.index')->with('success', 'Auxiliaire mis à jour avec succès.');
    }

    public function destroy(Auxiliaire $auxiliaire)
    {
        $auxiliaire->delete();
        return redirect()->route('account.auxiliaires.index')->with('success', 'Auxiliaire supprimé avec succès.');
    }
    public function show($id)
{
    
    $entiteTerritoriale = Auth::user()->entiteTerritoriale; // Logic to get the territorial entity
    // Find the auxiliary by its ID
    $auxiliaire = Auxiliaire::findOrFail($id);
    $enfants = $auxiliaire->enfants()->paginate(10); // Paginer les enfants
    $conjoints = $auxiliaire->conjoints()->paginate(10); // Paginer les conjoints
    // Get the associated user
    $id = Auth::user()->id;
        $user = User::findOrfail($id);

    // Pass data to the view
    return view('account.auxiliaires.show', compact('auxiliaire', 'user','entiteTerritoriale','enfants','conjoints'));
}
}
