<?php

use App\Models\Ratio;

/**
 * Renvoie un tableau des types de passifs ou une chaîne de caractères correspondant à un type de passif spécifique
 *
 * @param string|null $key La clé du type de passif à renvoyer (facultatif)
 * @return array|string
 */
function getTypePassifs(?string $key = null): array | string
{
    $typePassifs = [
        "pc" => "Passifs Courant",
        "pnc" => "Passifs Non Courant",
        "cp" => "Capitaux propres"
    ];

    if ($key) return $typePassifs[$key];
    return $typePassifs;
}

/**
 * Renvoie un tableau des types d'actifs ou une chaîne de caractères correspondant à un type d'actif spécifique
 *
 * @param string|null $key La clé du type d'actif à renvoyer (facultatif)
 * @return array|string
 */
function getTypeActifs(?string $key = null): array | string
{
    $typeActifs = [
        "ac" => "Actifs Courant",
        "anc" => "Actifs Non Courant"
    ];

    if ($key) return $typeActifs[$key];
    return $typeActifs;
}

/**
 * Formate un nombre en tant que chaîne de caractères représentant une somme d'argent
 *
 * @param float|null $money Le nombre à formater (facultatif)
 * @return string
 */
function money(?float $money = null): string
{
    if ($money === null) $money = 0;
    return number_format($money, thousands_separator: " ", decimals: 2);
}

/**
 * Renvoie le libellé du ratio correspondant à l'ID spécifié, ou "Formules intermédiaire" si aucun ratio n'est trouvé
 *
 * @param string|int $ratioId L'ID du ratio à rechercher
 * @return string
 */
function ratio(string | int $ratioId): string
{
    $ratio = Ratio::find($ratioId);
    if ($ratio) return $ratio->libelle;
    return "Formules intermédiaire";
}
