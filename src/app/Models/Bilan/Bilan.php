<?php

namespace App\Models\Bilan;

use App\Models\Formula;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bilan extends Model
{
    use HasFactory;

    protected $fillable = [
        'date'
    ];

    /**
     * Permet de gérer les actifs liés à ce bilan.
     *
     * @param string|null $type Filtrer les actifs par type (par exemple, "Courant" ou "Non Courant")
     * @param int|null $id Identifiant spécifique de l'actif pour obtenir son montant
     * @return BelongsToMany|float
     * - Retourne une instance de BelongsToMany si aucun identifiant n'est fourni
     * - Retourne un montant (float) si un identifiant est fourni et l'actif est trouvé
     * - Retourne 0 si l'actif avec l'identifiant donné n'est pas trouvé
     */
    public function actifs(?string $type = null, ?int $id = null): BelongsToMany | float
    {
        // Définir la relation entre le modèle Bilan et Actif via la table pivot 'bilan_actifs'
        $relation = $this->belongsToMany(Actif::class, 'bilan_actifs', 'bilan_id', 'actif_id')->withPivot(['montant']);

        // Filtrer par type si fourni
        if ($type !== null) $relation->where('type', $type);

        // Si un identifiant est fourni, récupérer le montant de l'actif associé
        if ($id !== null)
        {
            $actif = $relation->find($id);

            // Retourner 0 si l'actif n'est pas trouvé
            if ($actif === null) return 0;

            // Retourner le montant de l'actif
            return $actif->pivot->montant;
        }

        // Retourner la relation pour permettre des opérations supplémentaires (comme la pagination)
        return $relation;
    }

    /**
     * Permet de gérer les passifs liés à ce bilan.
     *
     * @param string|null $type Filtrer les passifs par type (par exemple, "Courant" ou "Non Courant")
     * @param int|null $id Identifiant spécifique du passif pour obtenir son montant
     * @return BelongsToMany|float
     * - Retourne une instance de BelongsToMany si aucun identifiant n'est fourni
     * - Retourne un montant (float) si un identifiant est fourni et le passif est trouvé
     * - Retourne 0 si le passif avec l'identifiant donné n'est pas trouvé
     */
    public function passifs(?string $type = null, ?int $id = null): BelongsToMany | float
    {
        // Définir la relation entre le modèle Bilan et Passif via la table pivot 'bilan_passifs'
        $relation = $this->belongsToMany(Passif::class, 'bilan_passifs', 'bilan_id', 'passif_id')->withPivot(['montant']);

        // Filtrer par type si fourni
        if ($type !== null) $relation->where('type', $type);

        // Si un identifiant est fourni, récupérer le montant du passif associé
        if ($id !== null)
        {
            $passif = $relation->find($id);

            // Retourner 0 si le passif n'est pas trouvé
            if ($passif === null) return 0;

            // Retourner le montant du passif
            return $passif->pivot->montant;
        }

        // Retourner la relation pour permettre des opérations supplémentaires (comme la pagination)
        return $relation;
    }

    /**
     * Récupère la date du bilan formatée.
     *
     * @return string La date formatée en "d/m/Y"
     */
    public function getDate(): string
    {
        // Utilise Carbon pour parser la date et la formater
        return Carbon::parse($this->date)->format("d/m/Y");
    }

    /**
     * Récupère la valeur calculée en utilisant une formule spécifique.
     *
     * @param int|null $id Identifiant de la formule
     * @return float La valeur calculée par la formule, ou 0 si la formule n'existe pas
     */
    public function formulas(?int $id = null): float
    {
        // Trouver la formule par identifiant
        $formule = Formula::find($id);

        // Calculer la somme selon la formule, ou retourner 0 si la formule n'existe pas
        return $formule ? $formule->sum($this) : 0;
    }
}
