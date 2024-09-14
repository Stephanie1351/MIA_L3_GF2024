<?php

namespace App\Models\CompteResultat;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CompteResultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'date'
    ];

    /**
     * Permet de gérer les produits liés à ce compte de résultat.
     *
     * @param int|null $id Identifiant spécifique du produit pour obtenir son montant
     * @return BelongsToMany|float
     * - Retourne une instance de BelongsToMany si aucun identifiant n'est fourni
     * - Retourne un montant (float) si un identifiant est fourni et le produit est trouvé
     * - Retourne 0 si le produit avec l'identifiant donné n'est pas trouvé
     */
    public function produits(?int $id = null): BelongsToMany | float
    {
        $relation = $this->belongsToMany(Produit::class, 'compte_resultat_produits', 'compte_resultat_id', 'produit_id')->withPivot(['montant']);

        if ($id !== null)
        {
            $produit = $relation->find($id);
            if ($produit === null) return 0;
            return $produit->pivot->montant;
        }
        return $relation;
    }

    /**
     * Permet de gérer les charges liées à ce compte de résultat.
     *
     * @param int|null $id Identifiant spécifique de la charge pour obtenir son montant
     * @return BelongsToMany|float
     * - Retourne une instance de BelongsToMany si aucun identifiant n'est fourni
     * - Retourne un montant (float) si un identifiant est fourni et la charge est trouvée
     * - Retourne 0 si la charge avec l'identifiant donné n'est pas trouvée
     */
    public function charges(?int $id = null): BelongsToMany | float
    {
        // Définir la relation entre le modèle CompteResultat et Charge via la table pivot 'compte_resultat_charges'
        $relation = $this->belongsToMany(Charge::class, 'compte_resultat_charges', 'compte_resultat_id', 'charge_id')->withPivot(['montant']);

        // Si un identifiant est fourni, récupérer le montant de la charge associée
        if ($id !== null)
        {
            $charge = $relation->find($id);

            // Retourner 0 si la charge n'est pas trouvée
            if ($charge === null) return 0;

            // Retourner le montant de la charge
            return $charge->pivot->montant;
        }

        // Retourner la relation pour permettre des opérations supplémentaires (comme la pagination)
        return $relation;
    }

    /**
     * Récupère la date du compte de résultat formatée.
     *
     * @return string La date formatée en "d/m/Y"
     */
    public function getDate(): string
    {
        // Utilise Carbon pour parser la date et la formater
        return Carbon::parse($this->date)->format("d/m/Y");
    }
}
