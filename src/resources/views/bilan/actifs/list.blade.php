@extends('layouts.app')

@section('title', "Les actifs")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Actifs</h1>
    <a href="{{ route('actif.add') }}" class="btn btn-primary text-white"><i class="fa fa-plus mr-2"></i>Ajouter un actif</a>
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
                <th>#</th>
                <th>Libelle</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($actifs as $actif)
                <tr>
                    <td>{{ $actif->id }}</td>
                    <td>{{ $actif->libelle }}</td>
                    <td>{{ getTypeActifs($actif->type) }}</td>
                    <td>
                        <a class="btn btn-primary text-white" href="{{ route('actif.edit', ['actif' => $actif]) }}"><i class="fa fa-edit"></i></a>
                        <form id="delete-form" class="d-inline" action="{{ route('actif.post.delete', ['actif' => $actif]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger text-white" href="">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="4">Aucune données</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
