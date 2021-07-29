@php
    use App\Components\Biblioteca;
    use Carbon\Carbon;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.perfisAcesso'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.configuracoes.perfilAcesso._breadcrumbs')
            @include('Admin.configuracoes.perfilAcesso.' . $options['viewName'])
        </div>
    </div>
@endsection

