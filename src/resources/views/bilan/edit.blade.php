@extends('layouts.app')

@section('title', "Modifier bilan")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Modifier bilan</h1>
    <a href="{{ route('bilan.list') }}" class="btn btn-primary text-white"><i class="fa fa-list mr-2"></i>Liste</a>
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
    <form action="{{ route('bilan.post.edit', ['bilan' => $bilan]) }}" method="post">
        @csrf
        <div class="mb-4">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ $bilan->date }}">
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>
        <div class="row">
            <div class="col-6">
                <h5 class="text-muted">Actifs</h5>
                <hr>
                @foreach ($actifsGroup as $type => $actifs)
                    <div class="mb-3">
                        <h6 class="text-secondary">{{ getTypeActifs($type) }}</h6>
                        <hr>
                        @foreach ($actifs as $actif)
                            <div class="row mb-3">
                                <div class="col-6 d-flex align-items-center">
                                    <label for="">{{ $actif->libelle }}</label>
                                </div>
                                <div class="col-6">
                                    <input value="{{ $bilan->actifs->where('id', $actif->id)->first()->pivot->montant }}" type="number" class="form-control" name="actif_{{ $actif->id }}" id="">
                                </div>
                                <x-input-error :messages="$errors->get('actif_' . $actif->id)" class="mt-2" />
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="col-6">
                <h5 class="text-muted">Passifs</h5>
                <hr>
                @foreach ($passifsGroup as $type => $passifs)
                    <div class="mb-3">
                        <h6 class="text-secondary">{{ getTypePassifs($type) }}</h6>
                        <hr>
                        @foreach ($passifs as $passif)
                            <div class="row mb-3">
                                <div class="col-6 d-flex align-items-center">
                                    <label for="">{{ $passif->libelle }}</label>
                                </div>
                                <div class="col-6">
                                    <input value="{{ $bilan->passifs->where('id', $passif->id)->first()->pivot->montant }}" type="number" class="form-control" name="passif_{{ $passif->id }}">
                                </div>
                                <x-input-error :messages="$errors->get('passif_' . $passif->id)" class="mt-2" />
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary theme-btn mx-auto"><i class="fa fa-save mr-2"></i>Enregistrer</button>
    </form>
</div>

@endsection
