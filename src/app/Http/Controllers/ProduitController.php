<?php

namespace App\Http\Controllers;

use App\Models\CompteResultat\Produit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProduitController extends Controller
{
    // Définir les vues et les routes pour chaque type de ressource
    private string $view = 'compteresultat.produits';
    private string $route = 'produit';

    /**
     * Afficher la liste des ressources.
     *
     * @param string $type Le type de ressource à afficher (par défaut: "cr" pour le compte de résultat)
     * @return View
     */
    public function index(): View
    {
        // Récupérer toutes les ressources du type spécifié depuis la base de données
        $produits = Produit::all();

        // Retourner la vue pour le type de ressource spécifié, en passant les ressources en tant que données
        return view("{$this->view}.list", [
            'produits' => $produits
        ]);
    }

    /**
     * Afficher le formulaire de création d'une nouvelle ressource.
     *
     * @param string $type Le type de ressource à créer (par défaut: "cr" pour le compte de résultat)
     * @return View
     */
    public function create(): View
    {
        // Retourner la vue pour la création d'une nouvelle ressource du type spécifié
        return view("{$this->view}.add");
    }

    /**
     * Stocker une nouvelle ressource dans le stockage.
     *
     * @param Request $request L'objet de requête contenant les données pour la nouvelle ressource
     * @param string $type Le type de ressource à créer (par défaut: "cr" pour le compte de résultat)
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Valider les données de la requête
        $data = $request->validate([
            'libelle' => ['required', 'string', 'unique:produits,libelle']
        ]);

        // Créer une nouvelle ressource dans la base de données à l'aide des données validées
        $produit = Produit::create($data);

        // Si la ressource a été créée avec succès, rediriger vers la vue de liste pour le type de ressource spécifié avec un message de succès
        if ($produit) return to_route("{$this->route}.list")->with("success", "Ajouté");

        // Si la ressource n'a pas pu être créée avec succès, rediriger vers la page précédente avec un message d'erreur et les données d'entrée
        return back()->with("error", "Impossible d'enregistrer")->withInput();
    }

    /**
     * Afficher le formulaire d'édition de la ressource spécifiée.
     *
     * @param Produit $produit La ressource à modifier
     * @param string $type Le type de ressource à modifier (par défaut: "cr" pour le compte de résultat)
     * @return View
     */
    public function edit(Produit $produit): View
    {
        // Retourner la vue pour la modification de la ressource spécifiée, en passant la ressource en tant que données
        return view("{$this->view}.edit", [
            'produit' => $produit
        ]);
    }

    /**
     * Mettre à jour la ressource spécifiée dans le stockage.
     *
     * @param Request $request L'objet de requête contenant les données mises à jour pour la ressource
     * @param Produit $produit La ressource à mettre à jour
     * @param string $type Le type de ressource à mettre à jour (par défaut: "cr" pour le compte de résultat)
     * @return RedirectResponse
     */
    public function update(Request $request, Produit $produit, ): RedirectResponse
    {
        // Valider les données de la requête
        $data = $request->validate([
            'libelle' => ['required', 'string', "unique:produits,libelle,{$produit->id},id"],
        ]);

        // Mettre à jour la ressource dans la base de données à l'aide des données validées
        $update = $produit->update($data);

        // Si la ressource a été mise à jour avec succès, rediriger vers la vue de liste pour le type de ressource spécifié avec un message de succès
        if ($update) return to_route("{$this->route}.list")->with("success", "Produit modifié");

        // Si la ressource n'a pas pu être mise à jour avec succès, rediriger vers la page précédente avec un message d'erreur et les données d'entrée
        return back()->with("error", "Impossible de modifier le produit")->withInput();
    }

    /**
     * Supprimer la ressource spécifiée du stockage.
     *
     * @param Produit $produit La ressource à supprimer
     * @return RedirectResponse
     */
    public function destroy(Produit $produit): RedirectResponse
    {
        try
        {
            // Essayer de supprimer la ressource de la base de données
            $produit->delete();

            // Si la ressource a été supprimée avec succès, rediriger vers la page précédente avec un message de succès
            return back()->with("success", "Supprimé");
        }
        catch(QueryException)
        {
            // Si la ressource n'a pas pu être supprimée, rediriger vers la page précédente avec un message d'erreur
            return back()->with("error", "Impossible de supprimer le produit");
        }
    }
}
