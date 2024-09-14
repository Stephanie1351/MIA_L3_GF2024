<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="shadow shadow-md rounded bg-white p-4 mb-4">
        <h6>Liste des formules</h6>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Opération</th>
                    <th class="w-25">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formules as $formule)
                    <tr>
                        <td>{{ $formule->libelle }}</td>
                        <td>{{ $formule->operationsAsString() }}</td>
                        <td>
                            <button type="button" wire:click='editFormula({{ $formule->id }})' class="btn btn-info text-white"><i class="fa fa-edit"></i></button>
                            <button type="button" wire:click='removeFormula({{ $formule->id }})' class="btn btn-danger text-white"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="shadow shadow-md rounded bg-white p-4 mb-4">
        <h6>Structure du Compte de resultat</h6>
        <hr>
        <form wire:submit.prevent='saveResult' method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Formule</th>
                        <th class="w-25">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $key => $result)
                        <tr>
                            <td>
                                <select wire:model.live="results.{{ $key }}.type" class="form-control">
                                    <option value="formulas">Formule</option>
                                </select>
                            </td>
                            <td>
                                @if ($result['type'] === 'formulas')
                                    <select wire:model='results.{{ $key }}.field_id' class="form-control">
                                        <option value="0">Selectionner</option>
                                        @foreach ($formules as $formule)
                                            <option value="{{ $formule->id }}">{{ $formule->libelle }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                @if ($key === 0)
                                    <button wire:click='addResult' type="button" class="btn btn-primary text-white">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif
                                @if ($key > 0)
                                    <button wire:click='removeResult({{ $key }})' type="button"
                                        class="btn btn-danger text-white">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="mt-4 btn btn-primary text-white">
                <i class="fa fa-save"></i>
                Enregistrer
            </button>
        </form>
    </div>

    <div class="shadow shadow-md rounded bg-white p-4 mb-4">
        <h6>Nouveau formule</h6>
        <hr>
        <form wire:submit.prevent='saveFormula' method="post">
            <div class="form-group mb-3">
                <label class="form-label">Libellé de la formule</label>
                <input type="text" class="form-control" wire:model.live='label'>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Libelle</th>
                        <th>Opération</th>
                        <th class="w-25">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operations as $key => $operation)
                        <tr>
                            <td>
                                <select wire:model.live="operations.{{ $key }}.type" class="form-control">
                                    <option value="produits">Produits</option>
                                    <option value="charges">Charges</option>
                                </select>
                            </td>
                            <td>
                                @if ($operation['type'] === 'produits')
                                    <select class="form-control"
                                        wire:model.live='operations.{{ $key }}.field_id'>
                                        <option value="0">Selectionner</option>
                                        @foreach ($produits as $produit)
                                            <option value="{{ $produit->id }}">{{ $produit->libelle }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($operation['type'] === 'charges')
                                    <select class="form-control"
                                        wire:model.live='operations.{{ $key }}.field_id'>
                                        <option value="0">Selectionner</option>
                                        @foreach ($charges as $charge)
                                            <option value="{{ $charge->id }}">{{ $charge->libelle }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                <select class="form-control text-center" wire:model.live='operations.{{ $key }}.action'>
                                    <option value="plus">+</option>
                                    <option value="minus">-</option>
                                </select>
                            </td>
                            <td>
                                @if ($key === 0)
                                    <button wire:click='addOperation' type="button" class="btn btn-primary text-white">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif
                                @if ($key > 0)
                                    <button wire:click='removeOperation({{ $key }})' type="button"
                                        class="btn btn-danger text-white">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button class="mt-4 btn btn-primary text-white">
                <i class="fa fa-save"></i>
                Enregistrer
            </button>
        </form>
    </div>
</div>
