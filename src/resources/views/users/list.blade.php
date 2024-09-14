@extends('layouts.app')

@section('title', "Page d'accueil")

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Liste</h1>
    <a href="{{ route('users.add') }}" class="btn btn-primary text-white"><i class="fa fa-plus mr-2"></i>Ajouter</a>
</div>

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
<div class="shadow shadow-md rounded bg-white p-4">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse e-mail</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRole() }}</td>
                    <td>
                        <a class="btn btn-primary text-white btn-md" href="{{ route('users.edit', ['user' => $user]) }}"><i class="fa fa-edit"></i></a>
                        @if ($user->id !== auth()->user()->id)
                            <form id="delete-form" class="d-inline" action="{{ route('users.post.delete', ['user' => $user]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger text-white btn-md" href="">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
@endsection
