<?php

namespace App\Http\Controllers;

use App\Models\Bilan\Actif;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ActifController extends Controller
{
    /**
     * Affiche la liste des actifs.
     *
     * @return View
     */
    public function index(): View
    {
        // Récupère tous les actifs de la base de données
        $actifs = Actif::all();

        // Retourne la vue avec la liste des actifs
        return view('bilan.actifs.list', [
            'actifs' => $actifs
        ]);
    }

    /**
     * Affiche le formulaire de création d'un actif.
     *
     * @return View
     */
    public function create(): View
    {
        // Retourne la vue pour ajouter un nouvel actif
        return view('bilan.actifs.add');
    }

    /**
     * Enregistre un nouvel actif dans la base de données.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Valide les données du formulaire
        $data = $request->validate([
            'libelle' => ['required', 'string', 'unique:actifs,libelle'],
            'type' => ['required', Rule::in(array_keys(getTypeActifs()))]
        ]);

        // Crée un nouvel actif avec les données validées
        $actif = Actif::create($data);

        // Redirige avec un message de succès ou d'erreur
        if ($actif) return to_route("actif.list")->with("success", "Actif créé");
        return back()->with("error", "Impossible d'enregistrer")->withInput();
    }

    /**
     * Affiche le formulaire d'édition d'un actif existant.
     *
     * @param Actif $actif
     * @return View
     */
    public function edit(Actif $actif): View
    {
        // Retourne la vue pour éditer un actif existant
        return view('bilan.actifs.edit', [
            'actif' => $actif
        ]);
    }

    /**
     * Met à jour un actif existant dans la base de données.
     *
     * @param Request $request
     * @param Actif $actif
     * @return RedirectResponse
     */
    public function update(Request $request, Actif $actif): RedirectResponse
    {
        // Valide les données du formulaire
        $data = $request->validate([
            'libelle' => ['required', 'string', "unique:actifs,libelle,{$actif->id},id"],
            'type' => ['required', Rule::in(array_keys(getTypeactifs()))]
        ]);

        // Met à jour l'actif avec les nouvelles données
        $update = $actif->update($data);

        // Redirige avec un message de succès ou d'erreur
        if ($update) return to_route("actif.list")->with("success", "Actif modifié");
        return back()->with("error", "Impossible de modifier l'actif")->withInput();
    }

    /**
     * Supprime un actif de la base de données.
     *
     * @param Actif $actif
     * @return RedirectResponse
     */
    public function destroy(Actif $actif): RedirectResponse
    {
        // Supprime l'actif de la base de données
        $delete = $actif->delete();

        // Redirige avec un message de succès ou d'erreur
        if ($delete) return back()->with("success", "Supprimé");
        return back()->with("error", "Impossible de supprimer l'actif");
    }
}
