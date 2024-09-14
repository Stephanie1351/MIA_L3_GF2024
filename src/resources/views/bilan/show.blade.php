@extends('layouts.app')

@section('title', "Détails du bilan")

@section('content')

<style>
    .w-30 {
        width: 30%;
    }

    .w-15 {
        width: 15%;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Détails du bilan</h1>
    <div class="d-flex justify-content-between">
        <a href="{{ route('bilan.edit', ['bilan' => $bilan]) }}" class="btn btn-info text-white mr-3"><i class="fa fa-edit mr-2"></i>Modifier ce bilan</a>
        <a href="{{ route('bilan.list') }}" class="btn btn-primary text-white"><i class="fa fa-list mr-2"></i>Liste</a>
    </div>
</div>

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<div class="rounded bg-white shadow p-4">
    <h6 class="text-info mb-4">Date: {{ $bilan->getDate() }}</h6>
    <div class="row">
        <div class="col-6">
            <h6 class="bordered bg-secondary p-2 text-white text-center text-uppercase fw-bold">Actif</h6>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Libelle</th>
                        <th class="text-end">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (getTypeActifs() as $key => $value)
                        @foreach($bilan->actifs($key)->get() as $actif)
                            <tr>
                                <td>{{ $actif->libelle }}</td>
                                <td class="text-end">{{ number_format($actif->pivot->montant, thousands_separator: " ") }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fw-bold">Total {{ $value }}</td>
                            <td class="text-end fw-bold">{{ number_format($bilan->actifs($key)->sum('montant'), thousands_separator: " ") }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="fw-bold text-uppercase bg-primary text-white">Total actif</td>
                        <td class="text-end fw-bold bg-primary text-white">{{ number_format($bilan->actifs()->sum('montant'), thousands_separator: " ") }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h6 class="bordered bg-secondary p-2 text-white text-center text-uppercase fw-bold">Passif</h6>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Libelle</th>
                        <th class="text-end">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (getTypePassifs() as $key => $value)
                        @foreach($bilan->passifs($key)->get() as $passif)
                            <tr>
                                <td>{{ $passif->libelle }}</td>
                                <td class="text-end">{{ number_format($passif->pivot->montant, thousands_separator: " ") }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fw-bold">Total {{ $value }}</td>
                            <td class="text-end fw-bold">{{ number_format($bilan->passifs()->sum('montant'), thousands_separator: " ") }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="fw-bold text-uppercase bg-primary text-white">Total passif</td>
                        <td class="text-end fw-bold bg-primary text-white">{{ number_format($bilan->passifs()->sum('montant'), thousands_separator: " ") }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="rounded bg-white shadow p-4 mt-4">
    <h5>Les ratios</h5>
    <hr>
    @foreach ($formulesGroup as $key => $formules)
        @if($key !== "")
            <table class="table table-striped table-bordered mb-5">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center bg-secondary">
                            <h6 class="text-white fw-bold text-uppercase m-0">{{ ratio($key) }}</h6>
                        </th>
                    </tr>
                    <tr>
                        <td class="bg-primary fw-bold text-white w-30">Libellé</td>
                        <td class="bg-primary fw-bold text-white">Formule</td>
                        <td class="bg-primary fw-bold text-white text-end w-15">Valeur</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formules as $formule)
                        <tr>
                            <td class="fw-semibold">{{ $formule->libelle }}</td>
                            <td>{{ $formule->operationsAsString() }}</td>
                            <td class="text-end fw-bold">{{ money($formule->sum($bilan)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</div>
@endsection
