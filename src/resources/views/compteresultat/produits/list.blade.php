@extends('layouts.app')

@section('title', "Les produits")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Liste des produits</h1>
    <a href="{{ route('produit.add') }}" class="btn btn-primary text-white"><i class="fa fa-plus mr-2"></i>Ajouter un produit</a>
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
            @forelse ($produits as $key => $produit)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $produit->libelle }}</td>
                    <td>
                        <a class="btn btn-primary text-white" href="{{ route('produit.edit', ['produit' => $produit]) }}"><i class="fa fa-edit"></i></a>
                        <form id="delete-form" class="d-inline" action="{{ route('produit.post.delete', ['produit' => $produit]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger text-white" href="">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="3">Aucune données</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
