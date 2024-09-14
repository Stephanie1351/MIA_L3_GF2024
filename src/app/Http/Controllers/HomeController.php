<?php

namespace App\Http\Controllers;

use App\Models\Bilan\Bilan;
use Illuminate\Contracts\View\View;
use App\Models\CompteResultat\CompteResultat;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Tableau de bord
     *
     * @return View
     */
    public function index(): View
    {
        $compteResultatCount = CompteResultat::count();
        $bilanCount = Bilan::count();
        $userCount = User::count();

        return view('dashboard', compact("compteResultatCount", "bilanCount", "userCount"));
    }
}
