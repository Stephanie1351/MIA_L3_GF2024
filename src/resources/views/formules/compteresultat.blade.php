@extends('layouts.app')

@section('title', "Compte de résultat")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Compte de resultat</h1>
    <a href="{{ route('compte-resultat.list') }}" class="btn btn-primary text-white"><i class="fa fa-list mr-2"></i>Liste des comptes de résultat</a>
</div>

@livewire('compte-resultat')
@endsection
