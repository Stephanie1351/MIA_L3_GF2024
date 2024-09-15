<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Formule;
use Illuminate\View\View;
use App\Models\Bilan\Actif;
use App\Models\Bilan\Bilan;
use Illuminate\Support\Str;
use App\Models\Bilan\Passif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class BilanController extends Controller
{
    /**
     * Affiche la liste des bilans.
     *
     * @return View
     */
    public function index(): View
    {
        // Récupère tous les bilans avec leurs relations passifs et actifs
        $bilans = Bilan::with('passifs', 'actifs')->get();

        // Retourne la vue avec la liste des bilans
        return view('bilan.list', [
            'bilans' => $bilans
        ]);
    }

    /**
     * Affiche le formulaire de création d'un nouveau bilan.
     *
     * @return View
     */
    public function create(): View
    {
        // Récupère et groupe les actifs par type
        $actifs = Actif::all()->groupBy('type');

        // Récupère et groupe les passifs par type
        $passifs = Passif::all()->groupBy('type');

        // Retourne la vue pour ajouter un nouveau bilan
        return view('bilan.add', [
            'actifsGroup' => $actifs,
            'passifsGroup' => $passifs
        ]);
    }

    /**
     * Enregistre un nouveau bilan dans la base de données.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Définition des règles de validation
        $rules = array_merge([
            "date" => ["required", "date", "unique:bilans,date"]
        ], $this->getRules());

        // Validation des données du formulaire
        $data = $request->validate($rules);

        // Démarre une transaction de base de données
        DB::beginTransaction();

        try
        {
            $actifsId = [];
            $passifsId = [];

            // Crée un nouveau bilan avec la date fournie
            $bilan = Bilan::create([
                'date' => $data['date']
            ]);

            // Parcours des données pour identifier les actifs et passifs
            foreach ($data as $key => $value)
            {
                $hasActif = Str::contains($key, "actif");
                $hasPassif = Str::contains($key, "passif");

                if ($hasActif and $hasPassif) abort(500);
                if ($hasActif) $actifsId[intval(Str::replace("actif_", "", $key))] = doubleval($value);
                if ($hasPassif) $passifsId[intval(Str::replace("passif_", "", $key))] = doubleval($value);
            }

            // Vérifie que la somme des actifs est égale à la somme des passifs
            $sumActif = array_sum($actifsId);
            $sumPassif = array_sum($passifsId);
            if ($sumActif !== $sumPassif) return back()->with('error', "Le total de l'actif doit être égal au montant du passif (Actif: $sumActif, Passif: $sumPassif)")->withInput();

            // Associe les actifs au bilan
            foreach ($actifsId as $id => $value)
            {
                Actif::findOrFail($id);
                $bilan->actifs()->attach($id, [
                    'montant' => $value
                ]);
            }

            // Associe les passifs au bilan
            foreach ($passifsId as $id => $value)
            {
                Passif::findOrFail($id);
                $bilan->passifs()->attach($id, [
                    'montant' => $value
                ]);
            }

            // Valide la transaction
            DB::commit();
            return back()->with('success', 'Bilan enregistré avec succès');
        }
        catch (Exception $e)
        {
            // Annule la transaction en cas d'erreur
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Affiche un bilan spécifique.
     *
     * @param Bilan $bilan
     * @return View
     */
    public function show(Bilan $bilan): View
    {
        // Récupère le bilan avec ses actifs et passifs
        $bilan = $bilan->with(['actifs', 'passifs'])->whereId($bilan->id)->first();

        // Récupère les formules liées aux ratios
        $formules = Formule::whereType("r")->get()->groupBy("ratio_id");

        // Retourne la vue pour afficher un bilan spécifique
        return view('bilan.show', [
            'bilan' => $bilan,
            'formulesGroup' => $formules
        ]);
    }

    /**
     * Affiche le formulaire d'édition d'un bilan existant.
     *
     * @param Bilan $bilan
     * @return View
     */
    public function edit(Bilan $bilan): View
    {
        // Récupère et groupe les actifs et passifs par type
        $actifs = Actif::all()->groupBy('type');
        $passifs = Passif::all()->groupBy('type');

        // Retourne la vue pour éditer un bilan existant
        return view('bilan.edit', [
            'bilan' => $bilan->with(['actifs', 'passifs'])->whereId($bilan->id)->first(),
            'actifsGroup' => $actifs,
            'passifsGroup' => $passifs
        ]);
    }

    /**
     * Met à jour un bilan existant dans la base de données.
     *
     * @param Request $request
     * @param Bilan $bilan
     * @return RedirectResponse
     */
    public function update(Request $request, Bilan $bilan): RedirectResponse
    {
        // Définition des règles de validation
        $rules = array_merge([
            "date" => ["required", "date", "unique:bilans,date,{$bilan->id},id"]
        ], $this->getRules());

        // Validation des données du formulaire
        $data = $request->validate($rules);

        // Démarre une transaction de base de données
        DB::beginTransaction();

        try
        {
            $actifsId = [];
            $passifsId = [];

            // Mise à jour du bilan avec la date fournie
            $bilan->update([
                'date' => $data['date']
            ]);

            // Parcours des données pour identifier les actifs et passifs
            foreach ($data as $key => $value)
            {
                $hasActif = Str::contains($key, "actif");
                $hasPassif = Str::contains($key, "passif");

                if ($hasActif and $hasPassif) abort(500);
                if ($hasActif) $actifsId[intval(Str::replace("actif_", "", $key))] = doubleval($value);
                if ($hasPassif) $passifsId[intval(Str::replace("passif_", "", $key))] = doubleval($value);
            }

            // Vérifie que la somme des actifs est égale à la somme des passifs
            $sumActif = array_sum($actifsId);
            $sumPassif = array_sum($passifsId);
            if ($sumActif !== $sumPassif) return back()->with('error', "Le total de l'actif doit être égal au montant du passif (Actif: $sumActif, Passif: $sumPassif)")->withInput();

            // Mise à jour des pivots actifs et passifs
            foreach ($actifsId as $id => $value)
            {
                Actif::findOrFail($id);
                $bilan->actifs()->updateExistingPivot($id, [
                    'montant' => $value
                ]);
            }

            foreach ($passifsId as $id => $value)
            {
                Passif::findOrFail($id);
                $bilan->passifs()->updateExistingPivot($id, [
                    'montant' => $value
                ]);
            }

            // Valide la transaction
            DB::commit();
            return to_route('bilan.show', ['bilan' => $bilan])->with('success', 'Bilan mis à jour avec succès');
        }
        catch (Exception $e)
        {
            // Annule la transaction en cas d'erreur
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Supprime un bilan de la base de données.
     *
     * @param Bilan $bilan
     * @return RedirectResponse
     */
    public function destroy(Bilan $bilan): RedirectResponse
    {
        // Détache les relations passifs et actifs du bilan
        $bilan->passifs()->detach();
        $bilan->actifs()->detach();

        // Supprime le bilan de la base de données
        $delete = $bilan->delete();

        // Redirige avec un message de succès ou d'erreur
        if ($delete) return back()->with("success", "Bilan supprimé avec succès");
        return back()->with("error", "Impossible de supprimer le bilan");
    }

    /**
     * Récupère les règles de validation pour les actifs et passifs.
     *
     * @return array
     */
    private function getRules(): array
    {
        $rules = [];

        // Règles de validation pour les actifs
        Actif::all()->map(function (Actif $actif) use (&$rules) {
            return $rules["actif_{$actif->id}"] = ["required", "numeric", "min:10", "max:999999999.99"];
        });

        // Règles de validation pour les passifs
        Passif::all()->map(function (Passif $passif) use (&$rules) {
            return $rules["passif_{$passif->id}"] = ["required", "numeric", "min:10", "max:999999999.99"];
        });

        // Retourne les règles de validation combinées
        return $rules;
    }
}
