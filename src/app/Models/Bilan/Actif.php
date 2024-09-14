<?php

namespace App\Models\Bilan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Le modèle Actif représente un enregistrement dans la table 'actifs' de la base de données.
 * Il contient les propriétés et méthodes associées aux actifs du bilan.
 */
class Actif extends Model
{
    use HasFactory;

    /**
     * @var array $fillable
     * Spécifie les attributs qui peuvent être assignés en masse.
     * 'libelle' : Le nom ou la description de l'actif.
     * 'type' : Le type de l'actif (e.g., courant, non courant).
     */
    protected $fillable = [
        'libelle',
        'type'
    ];
}
