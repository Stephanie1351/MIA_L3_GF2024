<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * La classe User représente un utilisateur du système et est utilisée pour la gestion de l'authentification.
 *
 * Elle utilise des traits pour les fonctionnalités liées aux API et aux notifications, ainsi que pour la gestion des utilisateurs.
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Utilisation des traits pour les fonctionnalités API, les usines de modèles et les notifications.

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',        // Nom de l'utilisateur.
        'email',       // Adresse email de l'utilisateur.
        'password',    // Mot de passe de l'utilisateur.
        'is_admin'     // Indicateur si l'utilisateur est un administrateur.
    ];

    /**
     * Les attributs qui doivent être cachés pour les tableaux JSON.
     *
     * @var array
     */
    protected $hidden = [
        'password',        // Mot de passe de l'utilisateur (caché pour éviter l'exposition).
        'remember_token',  // Jeton de souvenir (caché pour éviter l'exposition).
    ];

    /**
     * Les attributs qui devraient être convertis en types natifs.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',  // Conversion du champ email_verified_at en une instance de Carbon (date/heure).
    ];

    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool Retourne true si l'utilisateur est un administrateur, sinon false.
     */
    public function isAdmin() : bool
    {
        return $this->is_admin;  // Retourne la valeur de l'attribut is_admin.
    }

    /**
     * Récupère le rôle de l'utilisateur sous forme de chaîne.
     *
     * @return string Retourne "Administrateur" si l'utilisateur est un administrateur, sinon "Gestionnaire".
     */
    public function getRole(): string
    {
        return $this->isAdmin() ? "Administrateur" : "Gestionnaire"; // Retourne le rôle en fonction de l'attribut is_admin.
    }
}
