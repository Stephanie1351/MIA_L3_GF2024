@extends('errors.layout')

@section('title', '500 - Erreur Interne du Serveur')

@section('content')
    <div class="error mx-auto" data-text="404">500</div>
    <p class="lead text-gray-800 mb-5">Erreur interne du serveur</p>
    <p class="text-gray-500 mb-0">Une erreur est survenue</p>
@endsection
