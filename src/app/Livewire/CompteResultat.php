<?php

namespace App\Livewire;

use App\Models\Formule;
use Livewire\Component;
use App\Models\Structure;
use Illuminate\Support\Arr;
use Illuminate\Contracts\View\View;
use App\Models\CompteResultat\Charge;
use App\Models\CompteResultat\Produit;
use Illuminate\Database\Eloquent\Collection;

class CompteResultat extends Component
{
    /**
     * Collection de produits de compte de résultat
     *
     * @var Collection<Produit>
     */
    public Collection $produits;

    /**
     * Collection de charges de compte de résultat
     *
     * @var Collection<Charge>
     */
    public Collection $charges;

    /**
     * Collection de formules de compte de résultat à afficher
     *
     * @var Collection<Formule>
     */
    public Collection $formules;

    /**
     * Formule de compte de résultat en cours d'édition
     *
     * @var Formule|null
     */
    public ?Formule $formule = null;

    /**
     * Collection de structures de compte de résultat
     *
     * @var Collection<Structure>
     */
    public Collection $structures;

    /**
     * Libellé de la formule de compte de résultat
     *
     * @var string
     */
    public string $label = "";

    /**
     * Liste des opérations dans une formule de compte de résultat
     *
     * @var array
     */
    public array $operations;

    /**
     * Structure finale du compte de résultat
     *
     * @var array
     */
    public array $results;

    /**
     * Structure par défaut du compte de résultat
     *
     * @var array
     */
    public array $defaultResult = [
        'type' => 'formules',
        'field_id' => 0
    ];

    /**
     * Opération par défaut
     *
     * @var array
     */
    public array $defaultOperation = [
        'type' => 'charges',
        'field_id' => 0,
        'action' => 'plus'
    ];

    /**
     * Initialisation des propriétés
     *
     * @return void
     */
    public function mount()
    {
        $this->charges = Charge::all();
        $this->produits = Produit::all();
        $this->structures = Structure::all();
        $this->formules = Formule::whereType("cr")->get();

        if ($this->structures->count() > 0) $this->results = $this->structures->map(function (Structure $structure) {
            return [
                'field_id' => $structure->formule_id,
                'type' => 'formules'
            ];
        })->toArray();

        // Sinon, on ajoute la structure par défaut à la propriété $results
        else $this->results[] = $this->defaultResult;

        // Initialisation du libellé de la formule et de la liste des opérations
        $this->operations[] = $this->defaultOperation;
    }

    /**
     * Ajouter un résultat
     *
     * @return void
     */
    public function addResult(): void
    {
        // Ajout de la structure par défaut à la propriété $results
        $this->results[] = $this->defaultResult;
    }

    /**
     * Supprimer un résultat
     *
     * @param int $key L'index du résultat à supprimer
     * @return void
     */
    public function removeResult(int $key): void
    {
        // Suppression du résultat à l'index spécifié de la propriété $results
        Arr::forget($this->results, $key);
    }

    /**
     * Ajouter une opération
     *
     * @return void
     */
    public function addOperation(): void
    {
        // Ajout de l'opération par défaut à la propriété $operations
        $this->operations[] = $this->defaultOperation;
    }

    /**
     * Supprimer une opération
     *
     * @param int $key L'index de l'opération à supprimer
     * @return void
     */
    public function removeOperation(int $key): void
    {
        // Suppression de l'opération à l'index spécifié de la propriété $operations
        Arr::forget($this->operations, $key);
    }

    /**
     * Enregistrer les formules de compte de résultat
     *
     * @return void
     */
    public function saveFormule(): void
    {
        $formule = "";
        // Construction de la chaîne de caractères représentant la formule
        foreach ($this->operations as $operation)
        {
            $formule .= $operation['type'] . "." . $operation['field_id'] . " " . $operation['action'] . " ";
        }

        // Création ou mise à jour de la formule dans la base de données
        $data = [
            "libelle" => $this->label,
            "operation" => $formule,
            "type" => "cr"
        ];

        if ($this->formule) $this->formule->update($data);
        else Formule::create($data);

        // Réinitialisation du libellé de la formule et de la liste des opérations
        $this->operations = [$this->defaultOperation];
        $this->label = "";

        // Affichage d'un message de succès
        session()->flash('success', 'Enregistré avec succès');
    }

    /**
     * Enregistrer la structure du compte de résultat
     *
     * @return void
     */
    public function saveResult(): void
    {
        // Enregistrement de chaque résultat dans la base de données
        foreach ($this->results as $result)
        {
            Structure::create([
                "formule_id" => intval($result['field_id'])
            ]);
        }

        // Affichage d'un message de succès
        session()->flash('success', 'Enregistré avec succès');
    }


    /**
     * Éditer une formule de compte de résultat
     *
     * @param int $formuleId L'ID de la formule à éditer
     * @return void
     */
    public function editFormule(int $formuleId): void
    {
        $this->formule = Formule::findOrFail($formuleId);
        $this->operations = [];
        $this->label = $this->formule->libelle;
        $operations = $this->formule->operations();

        foreach ($operations as $key => $operation)
        {
            if (gettype($operation) === 'object') {
                $this->operations[] = [
                    'type' => $operation->relation,
                    'field_id' => $operation->id,
                    'action' => array_key_exists($key + 1, $operations->toArray()) ? $operations[$key + 1] : 'plus'
                ];
            }
        }
    }

    /**
     * Afficher la vue
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.compte-resultat');
    }
}
