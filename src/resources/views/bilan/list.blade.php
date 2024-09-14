@extends('layouts.app')

@section('title', "Les bilans")

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h3 mb-0 text-gray-800">Liste</h1>
    <a href="{{ route('bilan.add') }}" class="btn btn-primary text-white"><i class="fa fa-plus mr-2"></i>Ajouter un bilan</a>
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
                <th class="text-end">Total actif</th>
                <th class="text-end">Total passif</th>
                <th class="w-25">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bilans as $bilan)
                <tr>
                    <td>{{ $bilan->id }}</td>
                    <td>{{ $bilan->getDate() }}</td>
                    <td class="text-end fw-semibold">{{ number_format($bilan->actifs->sum('pivot.montant'), thousands_separator: " ") }}</td>
                    <td class="text-end fw-semibold">{{ number_format($bilan->passifs->sum('pivot.montant'), thousands_separator: " ") }}</td>
                    <td>
                        <a class="btn btn-info text-white" href="{{ route('bilan.show', ['bilan' => $bilan]) }}"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary text-white" href="{{ route('bilan.edit', ['bilan' => $bilan]) }}"><i class="fa fa-edit"></i></a>
                        <form id="delete-form" class="d-inline" action="{{ route('bilan.post.delete', ['bilan' => $bilan]) }}" method="post">
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
