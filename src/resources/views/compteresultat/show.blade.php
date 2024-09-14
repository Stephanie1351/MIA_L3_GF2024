@extends('layouts.app')

@section('title', "Détails du compte de résultat")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Détails du compte de résultat</h1>
    <div class="d-flex justify-content-between">
        <a href="{{ route('compte-resultat.edit', ['compteResultat' => $compteResultat]) }}" class="btn btn-info text-white mr-3"><i class="fa fa-edit mr-2"></i>Modifier ce compte</a>
        <a href="{{ route('compte-resultat.list') }}" class="btn btn-primary text-white"><i class="fa fa-list mr-2"></i>Liste des comptes</a>
    </div>
</div>

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<div class="rounded bg-white shadow p-4 mb-4">
    <h6 class="text-info mb-4">Date: {{ $compteResultat->getDate() }}</h6>
    <table class="table table-bordered mb-5">
        <thead>
            <tr>
                <th class="text-uppercase">Libellé</th>
                <th class="text-uppercase w-25 text-end">Montant</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0.0;
            @endphp
            @foreach ($structures as $structure)
                @php
                    // Somme (différence) pour chaque type de résultat
                    $sum = $structure->formula->sum($compteResultat)
                @endphp
                @foreach ($structure->formula->operations() as $operation)
                    @if(gettype($operation) === 'object')
                        <tr>
                            <td>{{ $operation->libelle }}</td>
                            <td class="text-end">{{ money($compteResultat->{$operation->relation}($operation->id)) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="fw-bold">{{ $structure->formula->libelle }}</td>
                    <td class="fw-bold text-end">{{ money($sum) }}</td>
                </tr>
                @php
                    $total += $sum;
                @endphp
            @endforeach
            <tr>
                <td class="@if ($total > 0) bg-primary @else bg-danger @endif text-white fw-bold text-uppercase">Résultat net</td>
                <td class="@if ($total > 0) bg-primary @else bg-danger @endif text-white fw-bold text-end">{{ money($total) }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
