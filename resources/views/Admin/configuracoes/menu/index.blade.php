@php
    use App\Components\Biblioteca;
    use Carbon\Carbon;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.menus'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.configuracoes.menu._breadcrumbs')
            @include('Admin.configuracoes.menu.' . $options['viewName'])
        </div>
    </div>
@endsection

