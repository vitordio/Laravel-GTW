@php
    use App\Components\Biblioteca;
@endphp

@extends('Cliente.layout.main')

@section('title', trans('titles.esqueciMinhaSenha'))

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
                                    <h4 class="m-b-0">@lang('labels.forgot_password')</h4>
                                </div>
                                
                                <p class="m-b-30">@lang('labels.messageForgotPassword')</p>

                                <form method="POST" action="{{ route('clienteForgotPassword') }}" data-grecaptcha-action="esqueciMinhaSenha">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="des_login">@lang('labels.des_login')</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user @if($errors->has('des_login') || Session::has('message')) is-invalid @elseif(Session::has('success')) is-valid @endif"></i>
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
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="float-right font-size-13 text-muted" href="{{ url()->previous() }}">@lang('labels.back')</a>
                                            <button class="btn btn-primary">@lang('labels.recuperatePassword')</button>
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
</div>
@endsection