@php
    use App\Components\Biblioteca;
    use Carbon\Carbon;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.usuarios'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.configuracoes.usuario._breadcrumbs')
            @include('Admin.configuracoes.usuario.' . $options['viewName'])
        </div>
    </div>
@endsection