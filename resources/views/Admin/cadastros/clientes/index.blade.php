@php
    use App\Components\Biblioteca;
    use Carbon\Carbon;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.clientes'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.cadastros.clientes._breadcrumbs')
            @include('Admin.cadastros.clientes.' . $options['viewName'])
        </div>
    </div>
@endsection