<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auxiliaire;
use App\Models\Entiteterritorielle;
use App\Models\Enfant;
use App\Models\Conjoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        // Rechercher dans chaque entité
        $users = User::where('Nom_Fr', 'like', "%$keyword%")
                     ->orWhere('Prenom_Fr', 'like', "%$keyword%")
                     ->orWhere('email', 'like', "%$keyword%")
                     ->get();

        $auxiliaires = Auxiliaire::where('Nom_Fr', 'like', "%$keyword%")
                                 ->orWhere('Prenom_Fr', 'like', "%$keyword%")
                                 ->orWhere('CNIE', 'like', "%$keyword%")
                                 ->get();

        $entites = Entiteterritorielle::where('Nom', 'like', "%$keyword%")
                                     ->get();

        $enfants = Enfant::where('Nom_Fr', 'like', "%$keyword%")
                         ->orWhere('Prenom_Fr', 'like', "%$keyword%")
                         ->get();

        $conjoints = Conjoint::where('Nom_Fr', 'like', "%$keyword%")
                             ->orWhere('Prenom_Fr', 'like', "%$keyword%")
                             ->orWhere('CNIE', 'like', "%$keyword%")
                             ->get();

        return view('admin.searchResults', compact('users', 'auxiliaires', 'entites', 'enfants', 'conjoints'));
    }
    public function searchUser(Request $request)
    {
        $entiteTerritoriale = Auth::user()->entiteTerritoriale;
        $keyword = $request->input('keyword');
        $userId = Auth::id(); // Get the authenticated user's ID
        
        // Rechercher dans chaque entité pour l'utilisateur authentifié
        $auxiliaires = Auxiliaire::where('user_id', $userId) // Filter by user ID
            ->where(function ($query) use ($keyword) {
                $query->where('Nom_Fr', 'like', "%$keyword%")
                      ->orWhere('Prenom_Fr', 'like', "%$keyword%")
                      ->orWhere('CNIE', 'like', "%$keyword%");
            })
            ->get();

        $enfants = Enfant::where('user_id', $userId) // Filter by user ID
            ->where(function ($query) use ($keyword) {
                $query->where('Nom_Fr', 'like', "%$keyword%")
                      ->orWhere('Prenom_Fr', 'like', "%$keyword%");
            })
            ->get();

        $conjoints = Conjoint::where('user_id', $userId) // Filter by user ID
            ->where(function ($query) use ($keyword) {
                $query->where('Nom_Fr', 'like', "%$keyword%")
                      ->orWhere('Prenom_Fr', 'like', "%$keyword%")
                      ->orWhere('CNIE', 'like', "%$keyword%");
            })
            ->get();

        return view('account.searchResults', compact('auxiliaires', 'enfants', 'conjoints','entiteTerritoriale'));
    }
}
