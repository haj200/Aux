<?php

namespace App\Http\Controllers;

use App\Models\Entiteterritorielle;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class DashboardController extends Controller
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
    public function index(){
        $entiteTerritoriale =  Auth::user()->entiteTerritoriale;
        return view('account.dashboard', compact('entiteTerritoriale'));
    }
    public function ShowEntiteTerritorielle(){
        $entiteTerritoriale =  Auth::user()->entiteTerritoriale;
        return view('account.ShowEntiteTerritorielle', compact('entiteTerritoriale'));
    }

}
