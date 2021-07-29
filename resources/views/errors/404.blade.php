<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name') }} - {{ trans('titles.paginaNaoEncontrada') }}</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">

    <!-- Core css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">

    @if (Auth::guest())
        {{-- Google Captcha --}}
        {{-- métodos de login e recuperação de senha  --}}
        <meta name="grecaptcha-key" content="{{config('recaptcha.v3.public_key')}}">
        <script src="https://www.google.com/recaptcha/api.js?render={{config('recaptcha.v3.public_key')}}"></script>
    @endif
    
</head>
<body>
    <div class="app is-folded">
        @if(Auth::user())
            {{-- Loading screen --}}
            <div id="loader-wrapper">
                <div id="loader"></div>
                <div class="loader-section section-left"></div>
                <div class="loader-section section-right"></div>
            </div>
            @if(Auth::guard('cliente')->check())
                @include('Cliente.layout.partials.header')
                @include('Cliente.layout.partials.nav')
            @else
                @include('Admin.layout.partials.header')
                @include('Admin.layout.partials.nav')
            @endif
		@endif
            
        <div class="page-container {{ Auth::guest() ? 'p-0' : ''}}">
            <div class="main-content">
                <div class="row">
                    <div class="container">
                        <div class="row align-items-center align-center">
                            <div class="col-md-12">
                                <div class="p-v-30">
                                    <h1 class="font-weight-semibold display-1 text-primary lh-1-2">@lang('messages.codigoErroPaginaNaoEncontrada')</h1>
                                    <h2 class="font-weight-light font-size-30">@lang('messages.paginaNaoEncontrada')</h2>
                                    <p class="lead m-b-30">@lang('messages.textPaginaNaoEncontrada')</p>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary btn-tone">@lang('labels.back')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()) @include('Cliente.layout.partials.footer') @endif
            </div>
        </div>
    </div>
</body>
</html>