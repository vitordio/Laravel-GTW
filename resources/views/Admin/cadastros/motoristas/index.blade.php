@php
    use App\Components\Biblioteca;
    use Carbon\Carbon;
@endphp

@extends('Admin.layout.main')

@section('title', trans('titles.motoristas'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.cadastros.motoristas._breadcrumbs')
            @include('Admin.cadastros.motoristas.' . $options['viewName'])
        </div>
    </div>
@endsection