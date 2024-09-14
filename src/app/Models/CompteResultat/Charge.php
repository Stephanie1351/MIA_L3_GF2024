<?php

namespace App\Models\CompteResultat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    /**
     * @var array $fillable
     * Spécifie les attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'libelle',
        'type'
    ];
}
