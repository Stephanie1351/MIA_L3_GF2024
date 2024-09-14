@extends('layouts.app')

@section('title', "Les charges")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Liste des charges</h1>
    <a href="{{ route('charge.add') }}" class="btn btn-primary text-white"><i class="fa fa-plus mr-2"></i>Ajouter un charge</a>
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
                <th class="w-25">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($charges as $charge)
                <tr>
                    <td>{{ $charge->id }}</td>
                    <td>{{ $charge->libelle }}</td>
                    <td>
                        <a class="btn btn-primary text-white" href="{{ route('charge.edit', ['charge' => $charge]) }}"><i class="fa fa-edit"></i></a>
                        <form id="delete-form" class="d-inline" action="{{ route('charge.post.delete', ['charge' => $charge]) }}" method="post">
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
