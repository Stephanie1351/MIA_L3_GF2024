<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteResultat\Charge;
use Illuminate\Database\QueryException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ChargeController extends Controller
{
    /**
     * Tableau des vues associées aux types de charges.
     *
     * @var array
     */
    private string $view = 'compteresultat.charges';

    private string $route = 'charge';

    /**
     * Affiche la liste des charges.
     *
     * @param string $type Le type de charge à afficher.
     * @return View La vue de la liste des charges.
     */
    public function index(): View
    {
        $charges = Charge::all();
        return view("{$this->view}.list", [
            'charges' => $charges
        ]);
    }

    /**
     * Affiche le formulaire de création d'une nouvelle charge.
     *
     * @param string $type Le type de charge à créer.
     * @return View La vue du formulaire de création.
     */
    public function create(): View
    {
        return view("{$this->view}.add");
    }

    /**
     * Enregistre une nouvelle charge.
     *
     * @param Request $request La requête HTTP.
     * @param string $type Le type de charge à enregistrer.
     * @return RedirectResponse La réponse de redirection.
     */
    public function store(Request $request, ): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string', 'unique:charges,libelle']
        ]);

        $charge = Charge::create($data);

        if ($charge) return to_route("{$this->route}.list")->with("success", "Ajouté");
        return back()->with("error", "Impossible d'enregistrer")->withInput();
    }

    /**
     * Affiche le formulaire de modification d'une charge.
     *
     * @param Charge $charge La charge à modifier.
     * @param string $type Le type de charge.
     * @return View La vue du formulaire de modification.
     */
    public function edit(Charge $charge, string $type = 'cr'): View
    {
        return view("{$this->view}.edit", [
            'charge' => $charge
        ]);
    }

    /**
     * Met à jour une charge existante.
     *
     * @param Request $request La requête HTTP.
     * @param Charge $charge La charge à mettre à jour.
     * @param string $type Le type de charge.
     * @return RedirectResponse La réponse de redirection.
     */
    public function update(Request $request, Charge $charge, ): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string', "unique:charges,libelle,{$charge->id},id"],
        ]);

        $update = $charge->update($data);

        if ($update) return to_route("{$this->route}.list", )->with("success", "Charge modifié");
        return back()->with("error", "Impossible de modifier le charge")->withInput();
    }

    /**
     * Supprime une charge.
     *
     * @param Charge $charge La charge à supprimer.
     * @return RedirectResponse La réponse de redirection.
     */
    public function destroy(Charge $charge): RedirectResponse
    {
        try
        {
            $charge->delete();
            return back()->with("success", "Supprimé");
        }
        catch(QueryException)
        {
            return back()->with("error", "Impossible de supprimer le charge");
        }
    }
}
