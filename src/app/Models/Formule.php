<?php

namespace App\Models;

use Brick\Math\Exception\DivisionByZeroException;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class Formule extends Model
{
    use HasFactory;

    protected $_fillable = [
        'libelle', 'operation', 'type', 'ratio_id', 'afficher',
    ];

    /**
     * Gère les opérations définies dans le champ 'operation'.
     *
     * @param bool $calc Indique si les opérations imbriquées doivent être calculées
     * @return Collection|float
     */
    public function operations(?bool $calc = false)
    {
        // Sépare les opérations par espace et supprime le dernier élément vide
        $operations = explode(' ', trim($this->operation));
        array_pop($operations);

        $results = collect([]);

        foreach ($operations as $operation) {
            if ($operation === 'minus' || $operation === 'plus' || $operation === 'division') {
                $results->push($operation);
            } else {
                $operationParts = explode('.', $operation);
                $tableName      = $operationParts[0];
                $id             = $operationParts[1];

                $element = DB::table($tableName)->find($id);

                if ($tableName === 'formulas' && $calc === true) {
                    $operations2 = explode(' ', trim($element->operation));
                    foreach ($operations2 as $operation) {
                        if ($operation === 'minus' || $operation === 'plus') {
                            $results->push($operation);
                        } else {
                            $operationParts = explode('.', $operation);
                            $tableName      = $operationParts[0];
                            $id             = $operationParts[1];

                            $element           = DB::table($tableName)->find($id);
                            $element->relation = $tableName;
                            $results->push($element);
                        }
                    }
                } else {
                    $element->relation = $tableName;
                    $results->push($element);
                }
            }
        }

        $results = $this->removeConsecutivePlus($results);
        return $results;
    }

    /**
     * Retourne les opérations sous forme de chaîne de caractères.
     *
     * @return string
     */
    public function operationsAsString(): string
    {
        $results = $this->operations();
        $str     = '';

        foreach ($results as $result) {
            if (gettype($result) === 'string') {
                $str .= $result . ' ';
            } else {
                $str .= $result->libelle . ' ';
            }
        }

        $str = str_replace(
            ['division', 'plus', 'minus'],
            ['/', '+', '-'],
            $str
        );
        return $str;
    }

    /**
     * Calcule la somme des opérations pour un modèle donné.
     *
     * @param Model $model
     * @return float
     */
    public function sum(Model $model): float
    {
        $results    = [];
        $operations = $this->operations();

        foreach ($operations as $operation) {
            if ($operation !== 'minus' && $operation !== 'plus' && $operation !== 'division') {
                $results[] = $model->{$operation->relation}(id: $operation->id);
            } else {
                $results[] = str_replace(
                    ['division', 'plus', 'minus'],
                    ['/', '+', '-'],
                    $operation
                );
            }
        }
        return $this->evaluateExpression($results);
    }

    /**
     * Évalue une expression mathématique sous forme de tableau.
     *
     * @param array $array Tableau contenant l'expression à évaluer
     * @return float
     */
    public function evaluateExpression(array $array): float
    {
        foreach (['/'] as $operator) {
            while (($index = array_search($operator, $array)) !== false) {
                $result = $this->performOperation($array[$index - 1], $operator, $array[$index + 1]);
                array_splice($array, $index - 1, 3, $result);
            }
        }

        // Évalue les opérations d'addition et de soustraction
        foreach (['+', '-'] as $operator) {
            while (($index = array_search($operator, $array)) !== false) {
                try {
                    $result = $this->performOperation($array[$index - 1], $operator, $array[$index + 1]);
                    array_splice($array, $index - 1, 3, $result);
                } catch (Exception) {
                    break;
                }
            }
        }
        return $array[0];
    }

    /**
     * Effectue une opération mathématique.
     *
     * @param float $operand1 Premier opérande
     * @param string $operator Opérateur (+, -, /)
     * @param float $operand2 Deuxième opérande
     * @return float
     * @throws DivisionByZeroException Si la division par zéro est tentée
     * @throws InvalidArgumentException Si un opérateur invalide est fourni
     */
    public function performOperation(float $operand1, string $operator, float $operand2): float
    {
        switch ($operator) {
            case '+':
                return $operand1 + $operand2;
            case '-':
                return $operand1 - $operand2;
            case '/':
                return $operand2 > 0 ? $operand1 / $operand2 : throw new DivisionByZeroException("Impossible de diviser par 0");
            default:
                throw new InvalidArgumentException("Invalid operator: $operator");
        }
    }

    /**
     * Déclare une relation de type BelongsTo avec le modèle Ratio.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Ratio::class, 'ratio_id', 'id');
    }

    /**
     * Retourne le libellé de la catégorie associée.
     *
     * @return string|null
     */
    public function getCategory(): ?string
    {
        $category = $this->category;
        return $category ? $category->libelle : null;
    }

    /**
     * Supprime les opérateurs 'plus' consécutifs d'une collection.
     *
     * @param Collection $collection Collection d'opérations
     * @return Collection
     */
    public function removeConsecutivePlus(Collection $collection): Collection
    {
        $filtered = $collection->reduce(function ($carry, $item) {
            if ($item === 'plus' && last($carry) === 'plus') {
                return $carry;
            }
            $carry[] = $item;
            return $carry;
        }, []);

        return collect($filtered);
    }
}
