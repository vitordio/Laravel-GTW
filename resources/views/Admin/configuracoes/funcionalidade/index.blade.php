@php
    use App\Components\Biblioteca;
    use Carbon\Carbon;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.funcionalidades'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.configuracoes.funcionalidade._breadcrumbs')
            @include('Admin.configuracoes.funcionalidade.' . $options['viewName'])
        </div>
    </div>
@endsection

