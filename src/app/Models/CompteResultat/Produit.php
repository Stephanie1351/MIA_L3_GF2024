<?php

namespace App\Models\CompteResultat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    /**
     * @var array $fillable
     * Spécifie les attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'libelle', // Libellé du produit
        'type'     // Type du produit (Compte de resultat ou Flux de trésorérie)
    ];
}
