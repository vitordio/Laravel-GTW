@extends('Admin.layout.main')

@section('title', trans('titles.esqueciMinhaSenha'))

@section('login')
    <div class="container-fluid p-0 h-100">
        <div class="row no-gutters h-100 full-height">
            <div class="col-lg-5 d-none d-lg-flex bg bg-login">
                <div class="d-flex h-100 p-h-40 p-v-15 flex-column justify-content-between">
                    <div class="login-logo">
                        <img src="{{ asset('assets/images/logo/logo.png')}}" alt="">
                    </div>
                    <div>
                        <h1 class="text-white m-b-20 font-weight-normal">@lang('messages.gtwSlogan')</h1>
                        <p class="text-white font-size-16 lh-2 w-80 opacity-08">@lang('messages.gtwTexto')</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-white">@lang('labels.rodape')</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 bg-white">
                <div class="container h-100">
                    <div class="row no-gutters h-100 align-items-center">
                        <div class="col-md-8 col-lg-7 col-xl-6 mx-auto">
                            <h2>@lang('labels.forgot_password')</h2>
                            <p class="m-b-30">@lang('labels.messageForgotPassword')</p>
                            <form method="POST" action="{{ route('forgotPassword') }}" data-grecaptcha-action="esqueciMinhaSenha">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="font-weight-semibold" for="des_email">@lang('labels.des_email')</label>
                                    <div class="input-affix">
                                        <i class="prefix-icon anticon anticon-mail @if($errors->has('des_email') || Session::has('message')) is-invalid @elseif(Session::has('success')) is-valid @endif"></i>
                                        <input type="email" name="des_email" value="{{ old('des_email') }}" class="form-control @if($errors->has('des_email') || Session::has('message')) is-invalid @elseif(Session::has('success')) is-valid @endif" id="des_email" placeholder="@lang('labels.des_email')">

                                        @if ($errors->has('des_email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('des_email') }}
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
                                    <a class="float-right font-size-13 text-muted" href="{{ url()->previous() }}">@lang('labels.back')</a>
                                    <div class="d-flex align-items-center justify-content-between">
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
@endsection