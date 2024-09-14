@extends('layouts.app')

@section('title', "Modifier un utilisateur")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Modifier un utilisateur</h1>
    <a href="{{ route('users.list') }}" class="btn btn-primary text-white"><i class="fa fa-list mr-2"></i>Liste</a>
</div>

@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif

<div class="shadow shadow-md rounded bg-white p-4">
    <form action="{{ route('users.post.edit', ['user' => $user]) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="email mb-3">
                    <label class="form-label" for="signup-email">Nom de l'utilisateur</label>
                    <input value="{{ $user->name }}" id="signup-name" name="name" type="text" class="form-control signup-name" placeholder="Nom complet" required="required">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>
            <div class="col-6">
                <div class="email mb-3">
                    <label class="form-label" for="signup-email">Adresse e-mail</label>
                    <input value="{{ $user->email }}" id="signup-email" name="email" type="email" class="form-control signup-email" placeholder="Adresse e-mail" required="required">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="email mb-3">
                    <label class="form-label">Rôle</label>
                    <select name="role" class="form-control">
                        <option @selected($user->is_admin === 1) value="1">Administrateur</option>
                        <option @selected($user->is_admin === 0) value="0">Gestionnaire</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
            </div>
            <div class="col-6">
                <div class="password mb-3">
                    <label class="form-label" for="signup-password">Mot de passe</label>
                    <input id="signup-password" name="password" type="password" class="form-control signup-password" placeholder="Modifier le mot de passe" autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary theme-btn mx-auto"><i class="fa fa-save mr-2"></i>Enregistrer</button>
    </form>
</div>
@endsection
