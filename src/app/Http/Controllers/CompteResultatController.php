<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Structure;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompteResultat\Charge;
use Illuminate\Http\RedirectResponse;
use App\Models\CompteResultat\Produit;
use App\Models\CompteResultat\CompteResultat;

class CompteResultatController extends Controller
{
    /**
     * Affiche la liste des comptes de résultat.
     *
     * @return View La vue de la liste des comptes de résultat.
     */
    public function index(): View
    {
        // Récupère tous les comptes de résultat avec leurs produits et charges associés.
        $compteResultats = CompteResultat::with('produits', 'charges')->get();

        // Retourne la vue avec les comptes de résultat.
        return view('compteresultat.list', [
            'compteResultats' => $compteResultats
        ]);
    }

    /**
     * Affiche le formulaire de création d'un nouveau compte de résultat.
     *
     * @return View La vue du formulaire de création.
     */
    public function create(): View
    {
        // Récupère tous les produits et charges pour les afficher dans le formulaire.
        $produits = Produit::all();
        $charges = Charge::all();

        // Retourne la vue du formulaire de création avec les produits et charges.
        return view('compteresultat.add', [
            'produits' => $produits,
            'charges' => $charges
        ]);
    }

    /**
     * Enregistre un nouveau compte de résultat.
     *
     * @param Request $request La requête HTTP.
     * @return RedirectResponse La réponse de redirection.
     */
    public function store(Request $request): RedirectResponse
    {
        // Définit les règles de validation pour la requête.
        $rules = array_merge([
            "date" => ["required", "date", "unique:compte_resultats,date"]
        ], $this->getRules());

        // Valide les données de la requête.
        $data = $request->validate($rules);

        // Démarre une transaction de base de données.
        DB::beginTransaction();

        try
        {
            $produitsId = [];
            $chargesId = [];

            // Crée un nouveau compte de résultat avec la date fournie.
            $compteResultat = CompteResultat::create([
                'date' => $data['date']
            ]);

            // Parcourt les données de la requête pour extraire les produits et charges.
            foreach ($data as $key => $value)
            {
                $hasProduit = Str::contains($key, "produit");
                $hasCharge = Str::contains($key, "charge");

                // Vérifie que les clés ne contiennent pas à la fois "produit" et "charge".
                if ($hasProduit and $hasCharge) abort(500);
                if ($hasProduit) $produitsId[intval(Str::replace("produit_", "", $key))] = doubleval($value);
                if ($hasCharge) $chargesId[intval(Str::replace("charge_", "", $key))] = doubleval($value);
            }

            // Attache les produits et charges au compte de résultat.
            foreach ($produitsId as $id => $value)
            {
                Produit::findOrFail($id);
                $compteResultat->produits()->attach($id, [
                    'montant' => $value
                ]);
            }

            foreach ($chargesId as $id => $value)
            {
                Charge::findOrFail($id);
                $compteResultat->charges()->attach($id, [
                    'montant' => $value
                ]);
            }

            // Valide la transaction de base de données.
            DB::commit();
            return back()->with('success', 'Compte de resultat enregistré');
        }
        catch (Exception $e)
        {
            // Annule la transaction en cas d'exception.
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un compte de résultat.
     *
     * @param CompteResultat $compteResultat Le compte de résultat à afficher.
     * @return View La vue des détails du compte de résultat.
     */
    public function show(CompteResultat $compteResultat): View
    {
        $structures = Structure::with(['formule'])->get();

        return view('compteresultat.show', [
            'compteResultat' => $compteResultat,
            'structures' => $structures
        ]);
    }

    /**
     * Affiche le formulaire de modification d'un compte de résultat.
     *
     * @param CompteResultat $compteResultat Le compte de résultat à modifier.
     * @return View La vue du formulaire de modification.
     */
    public function edit(CompteResultat $compteResultat): View
    {
        $produits = Produit::all();
        $charges = Charge::all();

        return view('compteresultat.edit', [
            'compteResultat' => $compteResultat,
            'produits' => $produits,
            'charges' => $charges
        ]);
    }

    /**
     * Met à jour un compte de résultat existant.
     *
     * @param Request $request La requête HTTP.
     * @param CompteResultat $compteResultat Le compte de résultat à mettre à jour.
     * @return RedirectResponse La réponse de redirection.
     */
    public function update(Request $request, CompteResultat $compteResultat): RedirectResponse
    {
        // Définit les règles de validation pour la requête.
        $rules = array_merge([
            "date" => ["required", "date", "unique:compte_resultats,date,{$compteResultat->id},id"]
        ], $this->getRules());

        // Valide les données de la requête.
        $data = $request->validate($rules);

        // Démarre une transaction de base de données.
        DB::beginTransaction();

        try
        {
            $produitsId = [];
            $chargesId = [];

            // Met à jour la date du compte de résultat.
            $compteResultat->update([
                'date' => $data['date']
            ]);

            // Parcourt les données de la requête pour extraire les produits et charges.
            foreach ($data as $key => $value)
            {
                $hasProduit = Str::contains($key, "produit");
                $hasCharge = Str::contains($key, "charge");

                // Vérifie que les clés ne contiennent pas à la fois "produit" et "charge".
                if ($hasProduit and $hasCharge) abort(500);
                if ($hasProduit) $produitsId[intval(Str::replace("produit_", "", $key))] = doubleval($value);
                if ($hasCharge) $chargesId[intval(Str::replace("charge_", "", $key))] = doubleval($value);
            }

            // Met à jour ou attache les produits et charges au compte de résultat.
            foreach ($produitsId as $id => $value)
            {
                Produit::findOrFail($id);
                if($compteResultat->produits->contains($id)) $compteResultat->produits()->updateExistingPivot($id, [
                    'montant' => $value
                ]);
                else $compteResultat->produits()->attach($id, [
                    'montant' => $value
                ]);
            }

            foreach ($chargesId as $id => $value)
            {
                Charge::findOrFail($id);
                if($compteResultat->charges->contains($id)) $compteResultat->charges()->updateExistingPivot($id, [
                    'montant' => $value
                ]);
                else $compteResultat->charges()->attach($id, [
                    'montant' => $value
                ]);
            }

            // Valide la transaction de base de données.
            DB::commit();
            return to_route('compte-resultat.show', ['compteResultat' => $compteResultat])->with('success', 'Compte de résultat mis a jour avec succès');
        }
        catch (Exception $e)
        {
            // Annule la transaction en cas d'exception.
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Supprime un compte de résultat.
     *
     * @param CompteResultat $compteResultat Le compte de résultat à supprimer.
     * @return RedirectResponse La réponse de redirection.
     */
    public function destroy(CompteResultat $compteResultat): RedirectResponse
    {
        // Détache les charges et produits associés au compte de résultat.
        $compteResultat->charges()->detach();
        $compteResultat->produits()->detach();

        // Supprime le compte de résultat.
        $delete = $compteResultat->delete();
        if ($delete) return back()->with("success", "Supprimé");
        return back()->with("error", "Impossible de supprimer le compte de résltat");
    }

    /**
     * Récupère les règles de validation.
     *
     * @return array Les règles de validation.
     */
    private function getRules(): array
    {
        $rules = [];

        // Ajoute des règles de validation pour chaque produit.
        Produit::all()->map(function (Produit $produit) use (&$rules) {
            return $rules["produit_{$produit->id}"] = ["required", "numeric", "min:0", "max:999999999.99"];
        });

        // Ajoute des règles de validation pour chaque charge.
        Charge::all()->map(function (Charge $charge) use (&$rules) {
            return $rules["charge_{$charge->id}"] = ["required", "numeric", "min:0", "max:999999999.99"];
        });

        // Retourne les règles de validation.
        return $rules;
    }
}
