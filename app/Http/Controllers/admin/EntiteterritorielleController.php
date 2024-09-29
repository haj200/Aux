<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entiteterritorielle;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EntiteterritorielleController extends Controller
  
{
    /**
     * Afficher la liste des entités territoriales.
     */
    public function index()
    {
        $entites = Entiteterritorielle::with('manager')->paginate(10);
        return view('admin.entiteterritorielles.index', compact('entites'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $users = User::all();
        $types = ['Province', 'Pachalik', 'Caidat', 'Cercle', 'Annexe'];
        return view('admin.entiteterritorielles.create', compact('users', 'types'));
    }

    /**
     * Stocker une nouvelle entité territoriale.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nom' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'type' => 'required|in:Province,Pachalik,Caidat,Cercle,Annexe',
            'managed_by' => 'required|exists:users,id',
        ]);

        EntiteTerritorielle::create($request->all());

        return redirect()->route('entiteterritorielles.index')
                         ->with('success', 'Entité Territorielle créée avec succès.');
    }

    /**
     * Afficher une entité territoriale spécifique.
     */
 
    public function show(EntiteTerritorielle $entiteterritorielle)
{
    // Eager load the 'auxiliaires' relationship to avoid N+1 query issues
    $entiteterritorielle->load('auxiliaires');
    $auxiliaires = $entiteterritorielle->auxiliaires()->paginate(10);

    return view('admin.entiteterritorielles.show', compact('entiteterritorielle','auxiliaires'));
}
    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(EntiteTerritorielle $entiteterritorielle)
    {
        $users = User::all();
        $types = ['Province', 'Pachalik', 'Caidat', 'Cercle', 'Annexe'];
        return view('admin.entiteterritorielles.edit', compact('entiteterritorielle', 'users', 'types'));
    }

    /**
     * Mettre à jour une entité territoriale spécifique.
     */
    public function update(Request $request, EntiteTerritorielle $entiteterritorielle)
    {
        $request->validate([
            'Nom' => 'required|string|max:255',
            'Nom_Ar' => 'required|string|max:255',
            'type' => 'required|in:Province,Pachalik,Caidat,Cercle,Annexe',
            'managed_by' => 'required|exists:users,id',
        ]);

        $entiteterritorielle->update($request->all());

        return redirect()->route('entiteterritorielles.index')
                         ->with('success', 'Entité Territorielle mise à jour avec succès.');
    }
    public function destroy($id)
    {
        try {
            $entite = Entiteterritorielle::findOrFail($id);
            
            // Vérification si des auxiliaires sont liés à cette entité territoriale
            if ($entite->auxiliaires()->count() > 0) {
                return redirect()->route('entiteterritorielles.index')
                    ->with('error', 'Impossible de supprimer cette entité territoriale car elle est liée à des auxiliaires.');
            }

            // Si aucun auxiliaire n'est lié, suppression de l'entité
            $entite->delete();

            return redirect()->route('entiteterritorielles.index')
                ->with('success', 'Entité territoriale supprimée avec succès.');
        
        } catch (QueryException $e) {
            // Gestion de l'exception de contrainte d'intégrité
            return redirect()->route('entiteterritorielles.index')
                ->with('error', 'Erreur lors de la suppression de l\'entité territoriale : contrainte de clé étrangère échouée.');
        }

        
    }

}