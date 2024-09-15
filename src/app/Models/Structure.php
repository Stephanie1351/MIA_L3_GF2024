<?php

namespace App\Models;

use App\Models\Formule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Structure extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $fillable = [
        "formule_id"
    ];

    /**
     * Définit la relation de la structure avec la formule.
     *
     * Cette méthode établit une relation de type "appartient à" (BelongsTo) avec le modèle Formule.
     * Cela signifie que chaque instance de Structure est associée à une instance de Formule par la clé étrangère 'formule_id'.
     *
     * @return BelongsTo La relation de type "appartient à" avec le modèle Formule.
     */
    public function formule(): BelongsTo
    {
        return $this->belongsTo(Formule::class, 'formule_id', 'id');
    }
}
