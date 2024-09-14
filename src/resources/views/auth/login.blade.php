@extends('layouts.auth')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Bienvenue!</h1>
    </div>
    <form class="user" method="POST">
        @csrf
        <div class="form-group">
            <input id="email" aria-describedby="emailHelp" value="{{ old('email') }}" name="email" type="email" class="form-control form-control-user" placeholder="e-mail">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="form-group">
            <input id="password" name="password" type="password" class="form-control form-control-user" placeholder="Mot de passe">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox small">
                <input type="checkbox" name="remember" class="custom-control-input" id="customCheck">
                <label class="custom-control-label" for="customCheck">Rester connecter</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Se connecter
        </button>
    </form>
    <hr>
    @if (Route::has('password.request'))
        <div class="text-center">
            <a class="small" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        </div>
    @endif
    <div class="text-center">
        <a class="small" href="{{ route("register") }}">Créer un compte!</a>
    </div>
@endsection


