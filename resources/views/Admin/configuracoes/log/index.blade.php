@php
    use App\Components\Biblioteca;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.log'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.configuracoes.log._breadcrumbs')
            @include('Admin.configuracoes.log.' . $options['viewName'])
        </div>
    </div>
@endsection