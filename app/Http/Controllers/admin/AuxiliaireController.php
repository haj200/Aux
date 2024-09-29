<?php

namespace App\Http\Controllers\admin;

use App\Models\Auxiliaire;
use App\Http\Controllers\Controller;
use App\Models\Entiteterritorielle;
use Dompdf\Dompdf;
use Dompdf\Options;
use Faker\Core\Color;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AuxiliaireController extends Controller

   
   


{
   

    // Function to convert column number to letter
    
    


    
    
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
        $auxiliaires = Auxiliaire::with(['entiteTerritorielle', 'creator', 'updater'])->paginate(10);
        return view('admin.auxiliaires.index', compact('auxiliaires'));
    }
    public function createKnownEntite($entiteId)
{
    // Récupérer l'entité territoriale par son ID
    $entite = EntiteTerritorielle::findOrFail($entiteId);

    return view('admin.auxiliaires.createKnownEntite', compact('entite'));
}
public function storeKnownEntite(Request $request, $entiteId)
{
    $request->validate([
        'Nom_Fr' => 'required|string|max:255',
        'Prenom_Fr' => 'required|string|max:255',
        'Nom_Ar' => 'required|string|max:255',
        'Prenom_Ar' => 'required|string|max:255',
        'Email' => 'required|email',
        'Grade' => 'required|string|max:255',
        'CNIE' => 'required|string|max:255',
        'url_photo' => 'required|url',
        'RIB' => 'required|string|max:255',
        'date_de_naissance' => 'required|date',
        'date_de_recrutement' => 'required|date',
        'Type' => 'required|in:rural,urbain',
        'pensionne' => 'required|boolean',
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
        'entiteterritorielle_id' => $entiteId, // Utiliser l'ID d'entité fourni
    ]);

    return redirect()->route('auxiliaires.index')->with('success', 'Auxiliaire ajouté avec succès.');
}


    public function create()
    {
        $entites = EntiteTerritorielle::all();
        return view('admin.auxiliaires.create', compact('entites'));
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
            'url_photo' => 'required|url',
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

        return redirect()->route('auxiliaires.index')->with('success', 'Auxiliaire ajouté avec succès.');
    }


    public function edit($id)
    {
        $auxiliaire = Auxiliaire::find($id);
        $entitesTerritoriales = Entiteterritorielle::all(); // Fetch all records or apply a filter
    
        return view('admin.auxiliaires.edit', compact('auxiliaire', 'entitesTerritoriales'));
    }

    public function update(Request $request, Auxiliaire $auxiliaire)
    {
        $request->validate([
            'Nom_Fr' => 'required|string|max:255',
            'Prenom_Fr' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'Prenom_Ar' => 'required|string|max:255',
            'Email' => 'required|email|unique:auxiliaires,Email,' . $auxiliaire->id,
            'Grade' => 'required|string|max:255',
            'CNIE' => 'required|string|max:255',
            'url_photo' => 'required|url',
            'RIB' => 'required|string|max:255',
            'date_de_naissance' => 'required|date',
            'date_de_recrutement' => 'required|date',
            'Type' => 'required|in:rural,urbain',
            'pensionne' => 'required|boolean',
            'entiteterritorielle_id' => 'required|exists:entiteterritorielles,id',
        ]);

        $userId = $this->getAuthenticatedUserId();

        if (!$userId) {
            return redirect()->back()->withErrors(['user' => 'Utilisateur non authentifié.'])->withInput();
        }

        $auxiliaire->update([
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
            'updated_by' => $userId,
            'entiteterritorielle_id' => $request->entiteterritorielle_id,
        ]);

        return redirect()->route('auxiliaires.index')->with('success', 'Auxiliaire mis à jour avec succès.');
    }

    // Suppression d'un auxiliaire
    public function destroy($id)
    {
        try {
            $auxiliaire = Auxiliaire::findOrFail($id);
            
            // Supprimer l'auxiliaire s'il n'a pas d'enfants ou de conjoints
            if ($auxiliaire->enfants()->count() > 0 || $auxiliaire->conjoints()->count() > 0) {
                return redirect()->route('auxiliaires.index')
                    ->with('error', 'Impossible de supprimer cet auxiliaire car il a des enfants ou des conjoints associés.');
            }
            
            $auxiliaire->delete();

            return redirect()->route('auxiliaires.index')
                ->with('success', 'Auxiliaire supprimé avec succès.');
        
        } catch (QueryException $e) {
            // Gestion de l'exception de contrainte d'intégrité
            return redirect()->route('auxiliaires.index')
                ->with('error', 'Erreur lors de la suppression de l\'auxiliaire : une contrainte de clé étrangère a échoué. Vérifiez si l\'auxiliaire a des enfants ou des conjoints associés.');
        }
    }
    


    public function show(Auxiliaire $auxiliaire)
{
    $enfants = $auxiliaire->enfants()->paginate(10); // Paginer les enfants
    $conjoints = $auxiliaire->conjoints()->paginate(10); // Paginer les conjoints

    return view('admin.auxiliaires.show', compact('auxiliaire', 'enfants', 'conjoints'));
}
}
