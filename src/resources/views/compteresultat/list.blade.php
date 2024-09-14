@extends('layouts.app')

@section('title', "Les comptes de resultats")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Liste des comptes resultats</h1>
    <a href="{{ route('compte-resultat.add') }}" class="btn btn-primary text-white"><i class="fa fa-plus mr-2"></i>Ajouter un comptes de resultat</a>
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
                <th>Date</th>
                <th class="text-end">Total produits</th>
                <th class="text-end">Total charges</th>
                <th class="w-25">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($compteResultats as $compteResultat)
                <tr>
                    <td>{{ $compteResultat->id }}</td>
                    <td>{{ $compteResultat->getDate() }}</td>
                    <td class="text-end fw-semibold">{{ number_format($compteResultat->produits->sum('pivot.montant'), thousands_separator: " ") }}</td>
                    <td class="text-end fw-semibold">{{ number_format($compteResultat->charges->sum('pivot.montant'), thousands_separator: " ") }}</td>
                    <td>
                        <a class="btn btn-info text-white" href="{{ route('compte-resultat.show', ['compteResultat' => $compteResultat]) }}"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary text-white" href="{{ route('compte-resultat.edit', ['compteResultat' => $compteResultat]) }}"><i class="fa fa-edit"></i></a>
                        <form id="delete-form" class="d-inline" action="{{ route('compte-resultat.post.delete', ['compteResultat' => $compteResultat]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger text-white" href="">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">Aucune données</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
