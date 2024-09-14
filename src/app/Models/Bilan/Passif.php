<?php

namespace App\Models\Bilan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Le modèle Passif représente un enregistrement dans la table 'passifs' de la base de données.
 * Il contient les propriétés et méthodes associées aux passifs du bilan.
 */
class Passif extends Model
{
    use HasFactory;

    /**
     * @var array $fillable
     * Spécifie les attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'libelle', // Libellé du passif
        'type'     // Type du passif (par exemple, "Courant" ou "Non Courant")
    ];
}
