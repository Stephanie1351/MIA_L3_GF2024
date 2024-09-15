<?php

namespace App\Livewire;

use App\Models\Ratio;
use App\Models\Formule;
use Livewire\Component;
use App\Models\Bilan\Actif;
use Illuminate\Support\Arr;
use App\Models\Bilan\Passif;
use Illuminate\Contracts\View\View;
use App\Models\CompteResultat\Charge;
use App\Models\CompteResultat\Produit;
use Illuminate\Database\Eloquent\Collection;

class Ratios extends Component
{
    /**
     * ID de la catégorie de ratio
     *
     * @var int
     */
    public int $category = 0;

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
     * Collection d'actifs de bilan
     *
     * @var Collection<Actif>
     */
    public Collection $actifs;

    /**
     * Collection de passifs de bilan
     *
     * @var Collection<Passif>
     */
    public Collection $passifs;

    /**
     * Collection de formules de ratio à afficher
     *
     * @var Collection<Formule>
     */
    public Collection $formules;

    /**
     * Collection de ratios à afficher
     *
     * @var Collection<Ratio>
     */
    public Collection $ratios;

    /**
     * Formule de ratio en cours d'édition
     *
     * @var Formule|null
     */
    public ?Formule $formule = null;

    /**
     * Libellé de la formule de ratio
     *
     * @var string
     */
    public string $label;

    /**
     * Liste des opérations dans une formule de ratio
     *
     * @var array
     */
    public array $operations;

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
     * Tableau de données pour les formules de ratio
     *
     * @var array
     */
    public array $datas;

    /**
     * Tableau des types de données pour les formules de ratio
     *
     * @var array
     */
    public array $types = [
        'produits' => "Produits",
        'charges' => "Charges",
        'actifs' => "Actifs",
        'passifs' => "Passifs",
        'formules' => "Formule"
    ];

    /**
     * Initialisation des propriétés
     *
     * @return void
     */
    public function mount()
    {
        $this->actifs = Actif::all();
        $this->ratios = Ratio::all();
        $this->charges = Charge::all();
        $this->passifs = Passif::all();
        $this->produits = Produit::all();
        $this->formules = Formule::where("type", "r")->get();

        $this->datas = [
            'produits' => $this->produits,
            'charges' => $this->charges,
            'actifs' => $this->actifs,
            'passifs' => $this->passifs,
            'formules' => $this->formules
        ];

        $this->label = "";
        $this->operations[] = $this->defaultOperation;
    }

    /**
     * Ajouter une opération
     *
     * @return void
     */
    public function addOperation(): void
    {
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
        Arr::forget($this->operations, $key);
    }

    /**
     * Enregistrer les formules de ratio
     *
     * @return void
     */
    public function saveFormule(): void
    {
        $formule = "";
        foreach ($this->operations as $operation)
        {
            $formule .= $operation['type'] . "." . $operation['field_id'] . " " . $operation['action'] . " ";
        }

        $data = [
            "libelle" => $this->label,
            "operation" => $formule,
            "type" => "r",
            "ratio_id" => $this->category,
        ];

        if ($this->formule) $this->formule->update($data);
        else Formule::create($data);

        $this->operations = [$this->defaultOperation];
        $this->label = "";
        $this->category = 0;

        session()->flash('success', 'Enregistré avec succès');
    }

    /**
     * Éditer une formule de ratio
     *
     * @param int $formuleId L'ID de la formule à éditer
     * @return void
     */
    public function editFormule(int $formuleId): void
    {
        $this->formule = Formule::findOrFail($formuleId);
        $this->category = $this->formule->ratio_id ?? 0;
        $this->operations = [];
        $this->label = $this->formule->libelle;
        $operations = $this->formule->operations();

        foreach ($operations as $key => $operation)
        {
            if (gettype($operation) === 'object') $this->operations[] = [
                'type' => $operation->relation,
                'field_id' => $operation->id,
                'action' => array_key_exists($key + 1, $operations->toArray()) ? $operations[$key + 1] : 'plus'
            ];
        }
    }

    /**
     * Annuler l'édition d'une formule de ratio
     *
     * @return void
     */
    public function cancelEditFormule(): void
    {
        $this->formule = null;
        $this->category = 0;
        $this->operations = [$this->defaultOperation];
        $this->label = "";
    }

    /**
     * Libellé du ratio en cours d'édition
     *
     * @var string|null
     */
    public ?string $ratio = null;

    /**
     * Ratio en cours d'édition
     *
     * @var Ratio|null
     */
    public ?Ratio $ratioModel = null;

    /**
     * Enregistrer la catégorie de ratio
     *
     * @return void
     */
    public function saveCategory(): void
    {
        $data = ['libelle' => $this->ratio ];

        if ($this->ratioModel === null) Ratio::create($data);
        else $this->ratioModel->update($data);

        $this->ratio = null;
        $this->ratioModel = null;

        session()->flash('success', 'Enregistré avec succès');
    }

    /**
     * Éditer une catégorie de ratio
     *
     * @param int $editId L'ID de la catégorie de ratio à éditer
     * @return void
     */
    public function editCategory(int $editId): void
    {
        $this->ratioModel = Ratio::findOrFail($editId);
        $this->ratio = $this->ratioModel->libelle;
    }

    /**
     * Annuler l'édition d'une catégorie de ratio
     *
     * @return void
     */
    public function cancelEditCategory(): void
    {
        $this->ratioModel = null;
        $this->ratio = null;
    }

    /**
     * Afficher la vue
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.ratios');
    }
}
