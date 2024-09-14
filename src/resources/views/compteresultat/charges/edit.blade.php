@extends('layouts.app')

@section('title', "Editer un charge")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Editer un charge</h1>
    <a href="{{ route('charge.list') }}" class="btn btn-primary text-white"><i class="fa fa-list mr-2"></i>Liste des charges</a>
</div>

@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif

<div class="shadow p-4 bg-white rounded">
    <form action="{{ route('charge.post.edit', ['charge' => $charge]) }}" method="post">
        @csrf
        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label" for="label">Libelle</label>
                <input value="{{ $charge->libelle }}" id="label" name="libelle" type="text" class="form-control" placeholder="Libelle" required="required">
                <x-input-error :messages="$errors->get('libelle')" class="mt-2" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary theme-btn mx-auto"><i class="fa fa-save mr-2"></i>Enregistrer</button>
    </form>
</div>

@endsection
