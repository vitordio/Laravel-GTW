@php
    use App\Components\Biblioteca;
@endphp

@extends('Cliente.layout.main')

@section('title', trans('titles.acessoAreaCliente'))

@section('login')
    <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex gradient-bg">
        <div class="d-flex flex-column justify-content-between w-100">
            <div>
                @if(env('AMBIENTE') === Biblioteca::AMBIENTE_DSV)
                    <h3 class="text-danger mb-3 text-center font-weight-bold">AMBIENTE DE DESENVOLVIMENTO</h3>
                @endif
            </div>
            <div class="container d-flex h-100">
                <div class="row align-items-center w-100">
                    <div class="col-md-7 col-lg-5 m-h-auto">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between m-b-30">
                                    <img class="img-fluid w-40" src="{{ asset('assets/images/logo/logo.png')}}" alt="">
                                    <h2 class="m-b-0">@lang('labels.login')</h2>
                                </div>
                                <form method="POST" action="{{ route('clienteLogin') }}" data-grecaptcha-action="login">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="des_login">@lang('labels.des_login')</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user @if($errors->has('des_login') || Session::has('message')) is-invalid @endif"></i>
                                            <input type="text" name="des_login" value="{{ old('des_login') }}" class="form-control @if($errors->has('des_login') || Session::has('message')) is-invalid @elseif(Session::has('success')) is-valid @endif" id="des_login" placeholder="@lang('labels.des_login')">

                                            @if ($errors->has('des_login'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('des_login') }}
                                                </div>
                                            @elseif (Session::has('message'))
                                                <div class="invalid-feedback">
                                                    {{ Session::get('message') }}
                                                </div>
                                            @elseif (Session::has('success'))
                                                <div class="valid-feedback">
                                                    {{ Session::get('success') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="password">@lang('labels.password')</label>
                                        <a class="float-right font-size-13 text-muted" href="{{ route('clienteFormForgotPassword') }}">@lang('labels.esqueceu_a_senha')</a>
                                        <div class="input-affix m-b-10">
                                            <i class="prefix-icon anticon anticon-lock {{ $errors->has('password') ? 'is-invalid' : '' }}"></i>
                                            <input type="password" name="password" value="{{ old('password') }}" class="form-control {{ $errors->has('password') || Session::has('message') ? 'is-invalid' : '' }}" id="password" placeholder="@lang('labels.password')">
    
                                            @if($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button class="btn btn-primary">@lang('labels.login')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection