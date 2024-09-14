<?php

namespace App\Http\Controllers;

use App\Models\Bilan\Passif;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PassifController extends Controller
{
    /**
     * Afficher la liste des ressources.
     *
     * @return View
     */
    public function index(): View
    {
        $passifs = Passif::all();
        return view('bilan.passifs.list', [
            'passifs' => $passifs
        ]);
    }

    /**
     * Afficher le formulaire de création d'une nouvelle ressource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('bilan.passifs.add');
    }

    /**
     * Stocker une nouvelle ressource dans le stockage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string', 'unique:passifs,libelle'],
            'type' => ['required', Rule::in(array_keys(getTypePassifs()))]
        ]);

        $passif = Passif::create($data);

        if ($passif) return to_route("passif.list")->with("success", "Passif créé");
        return back()->with("error", "Impossible d'enregistrer")->withInput();
    }


    /**
     * Afficher le formulaire d'édition de la ressource spécifiée.
     *
     * @param  Passif  $passif
     * @return View
     */
    public function edit(Passif $passif): View
    {
        return view('bilan.passifs.edit', [
            'passif' => $passif
        ]);
    }

    /**
     * Mettre à jour la ressource spécifiée dans le stockage.
     *
     * @param  Request  $request
     * @param  Passif  $passif
     * @return RedirectResponse
     */
    public function update(Request $request, Passif $passif): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string', "unique:passifs,libelle,{$passif->id},id"],
            'type' => ['required', Rule::in(array_keys(getTypePassifs()))]
        ]);

        $update = $passif->update($data);

        if ($update) return to_route("passif.list")->with("success", "Passif modifié");
        return back()->with("error", "Impossible de modifier le passif")->withInput();
    }

    /**
     * Supprimer la ressource spécifiée du stockage.
     *
     * @param  Passif  $passif
     * @return RedirectResponse
     */
    public function destroy(Passif $passif): RedirectResponse
    {
        $delete = $passif->delete();
        if ($delete) return back()->with("success", "Supprimé");
        return back()->with("error", "Impossible de supprimer le passif");
    }
}
