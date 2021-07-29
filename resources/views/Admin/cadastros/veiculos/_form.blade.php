@php
    use App\Components\Biblioteca;
    use Carbon\Carbon;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.veiculos'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.cadastros.veiculos._breadcrumbs')
            @include('Admin.cadastros.veiculos.' . $options['viewName'])
        </div>
    </div>
@endsection

