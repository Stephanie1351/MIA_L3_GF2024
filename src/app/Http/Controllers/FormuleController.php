<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FormuleController extends Controller
{
    /**
     * Affiche la vue pour les formules du compte de résultat.
     *
     * @return View La vue des formules du compte de résultat.
     */
    public function compteResultat(): View
    {
        return view('formules.compteresultat');
    }


    /**
     * Affiche la vue pour les formules des ratios.
     *
     * @return View La vue des formules des ratios.
     */
    public function ratios(): View
    {
        // Retourne la vue des formules des ratios.
        return view('formules.ratios');
    }
}
