@extends('layouts.app')

@section('title', "Modifier le compte de resultat")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Modifier le compte de resultat</h1>
    <a href="{{ route('compte-resultat.list') }}" class="btn btn-primary text-white"><i class="fa fa-list mr-2"></i>Liste des comptes de resultats</a>
</div>

@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<div class="shadow p-4 bg-white rounded">
    <form action="{{ route('compte-resultat.post.edit', ['compteResultat' => $compteResultat]) }}" method="post">
        @csrf
        <div class="mb-4">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ $compteResultat->date }}">
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>
        <div class="row">
            <div class="col-6">
                <h5 class="text-muted">Produits</h5>
                <hr>
                @foreach ($produits as $produit)
                    <div class="row mb-3">
                        <div class="col-6 d-flex align-items-center">
                            <label for="">{{ $produit->libelle }}</label>
                        </div>
                        <div class="col-6">
                            <input value="{{ $compteResultat->produits($produit->id) }}" type="number" class="form-control" name="produit_{{ $produit->id }}" id="">
                        </div>
                        <x-input-error :messages="$errors->get('produit_' . $produit->id)" class="mt-2" />
                    </div>
                @endforeach
            </div>
            <div class="col-6">
                <h5 class="text-muted">Charges</h5>
                <hr>
                @foreach ($charges as $charge)
                    <div class="row mb-3">
                        <div class="col-6 d-flex align-items-center">
                            <label for="">{{ $charge->libelle }}</label>
                        </div>
                        <div class="col-6">
                            <input value="{{ $compteResultat->charges($charge->id) }}" type="number" class="form-control" name="charge_{{ $charge->id }}">
                        </div>
                        <x-input-error :messages="$errors->get('charge_' . $charge->id)" class="mt-2" />
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary theme-btn mx-auto"><i class="fa fa-save mr-2"></i>Enregistrer</button>
    </form>
</div>

@endsection
