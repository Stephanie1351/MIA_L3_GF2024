<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="shadow shadow-md rounded bg-white p-4 mb-4">
        <h6>Liste des formules des ratios</h6>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Catégorie</th>
                    <th>Opération</th>
                    <th class="w-25">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($formules as $formule)
                    <tr>
                        <td>{{ $formule->libelle }}</td>
                        <td>{{ $formule->getCategory() ?? "-" }}</td>
                        <td>{{ $formule->operationsAsString() }}</td>
                        <td>
                            <button type="button" wire:click='editFormule({{ $formule->id }})' class="btn btn-info text-white"><i class="fa fa-edit"></i></button>
                            <button type="button" wire:click='removeFormule({{ $formule->id }})' class="btn btn-danger text-white"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucune formule pour le Ratios</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="shadow shadow-md rounded bg-white p-4 mb-4">
        <h6>Catégorie des ratios</h6>
        <hr>
        <form wire:submit.prevent='saveCategory' method="post">
            <div class="form-group mb-3">
                <label class="form-label">Libellé de la catégorie</label>
                <input type="text" class="form-control" wire:model='ratio'>
            </div>
            <button class="btn btn-primary text-white">
                <i class="fa fa-save"></i>
                Enregistrer
            </button>
            @if ($ratioModel !== null)
                <button wire:click='cancelEditCategory' type="button" class="btn btn-danger text-white">
                    <i class="fa fa-close"></i>
                    Annuler
                </button>
            @endif
        </form>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Libelle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ratios as $ratio)
                    <tr>
                        <td>{{ $ratio->id }}</td>
                        <td>{{ $ratio->libelle }}</td>
                        <td>
                            <button type="button" wire:click='editCategory({{ $ratio->id }})' class="btn btn-info text-white">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" wire:click='removeCategory({{ $ratio->id }})' class="btn btn-danger text-white">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Aucune données</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="shadow shadow-md rounded bg-white p-4 mb-4">
        <form wire:submit.prevent='saveFormule' method="post">
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Libellé de la formule</label>
                        <input type="text" class="form-control" wire:model.debounce.lazy='label'>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Catégorie</label>
                        <select class="form-control" wire:model.live='category'>
                            <option value="0">Selectionner</option>
                            @foreach ($ratios as $ratio)
                                <option value="{{ $ratio->id }}">{{ $ratio->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
                                    @foreach ($types as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control" wire:model.live='operations.{{ $key }}.field_id'>
                                    <option value="0">Selectionner</option>
                                    @foreach ($datas[$operation['type']] as $data)
                                        <option @selected($data->id === $operation['field_id']) value="{{ $data->id }}">{{ $data->libelle }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control text-center" wire:model.live='operations.{{ $key }}.action'>
                                    <option value="plus">+</option>
                                    <option value="minus">-</option>
                                    <option value="division">/</option>
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

            <button class="btn btn-primary text-white">
                <i class="fa fa-save"></i>
                Enregistrer
            </button>
            @if ($formule !== null)
                <button wire:click='canceleditFormule' type="button" class="btn btn-danger text-white">
                    <i class="fa fa-close"></i>
                    Annuler
                </button>
            @endif
        </form>
    </div>
</div>
