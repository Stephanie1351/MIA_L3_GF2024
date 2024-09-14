@extends('layouts.auth')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Créer un compte</h1>
    </div>

    <form method="POST" class="user">
        @csrf
        <div class="email mb-3">
            <label class="sr-only" for="signup-email">Votre nom</label>
            <input id="signup-name" name="name" type="text" class="form-control form-control-user" placeholder="Nom complet" required="required">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="email mb-3">
            <label class="sr-only" for="signup-email">Votre adresse e-mail</label>
            <input id="signup-email" name="email" type="email" class="form-control form-control-user" placeholder="Adresse e-meil" required="required">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="password mb-3">
            <label class="sr-only" for="signup-password">Mot de passe</label>
            <input id="signup-password" name="password" type="password" class="form-control form-control-user" placeholder="Créer un mot de passe" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="password mb-3">
            <label class="sr-only" for="signup-password">Confirmer le mot de passe</label>
            <input id="signup-password" name="password_confirmation" type="password" class="form-control form-control-user" placeholder="Confirmer le mot de passe" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Créer mon compte
        </button>
    </form>
    <hr />
    <div class="text-center small">Vous possedez déjà un compte ? <a href="{{ route("login") }}" >Se connecter</a></div>
@endsection
