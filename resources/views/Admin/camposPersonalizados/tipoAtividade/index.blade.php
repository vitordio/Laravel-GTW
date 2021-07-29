@php
    use App\Components\Biblioteca;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.tipoAtividade'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.camposPersonalizados.tipoAtividade._breadcrumbs')
            @include('Admin.camposPersonalizados.tipoAtividade.' . $options['viewName'])
        </div>
    </div>
@endsection

