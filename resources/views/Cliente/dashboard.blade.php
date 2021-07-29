@extends('Cliente.layout.main')

@section('title', trans('titles.areaCliente'))

@section('content')
    @if (Session::get('login-success')) 
        <div class="alert alert-success">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span>{{ Session::get('login-success') }}</span>
            </div>
        </div>
    @endif
    
    {{-- {{dd( Auth::user() )}} --}}
    <div class="row align-items-start">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div class="text-center text-sm-left m-v-15 p-l-30">
                            <p class="text-opacity font-size-13">Seja bem vindo (a)</p>
                            <h2 class="m-b-5">{{ Auth::user()->des_nome }}</h2>
                            <div class="mt-2">
                                <i class="m-r-5 text-dark anticon anticon-user"></i>
                                <span class="text-dark">
                                    <b>@lang('labels.des_login'):</b>
                                    {{ Auth::user()->des_login }}
                                </span> 
                            </div>
                            <div class="mt-2">
                                <i class="m-r-5 text-dark anticon anticon-mail"></i>
                                <span class="text-dark">
                                    <b>@lang('labels.des_email')</b>
                                    {{ Auth::user()->des_email }}
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dark">
                <div class="card-body p-h-50 p-v-40">
                    <div class="d-md-flex align-items-center">
                        <div class="text-center text-sm-left">
                            <img class="img-fluid w-40" src="{{ asset('assets/images/others/HiveCloud.png')}}" alt="">
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center mt-4">
                        <h4 class="text-white">Acesse o HiveCloud e confira o status de suas coletas.</h4>
                    </div>
                    <a target="blank" href="{{ env('LINK_HIVE_CLOUD') }}" class="btn btn-primary mt-2">
                        <i class="m-r-5 text-white anticon anticon-double-right"></i>
                        Clique aqui
                    </a>
                </div>
            </div>
        </div>
    </div>
        
@endsection