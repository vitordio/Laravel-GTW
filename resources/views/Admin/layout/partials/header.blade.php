@php
    use App\Components\Biblioteca;
@endphp

<div class="header">
    <div class="logo logo-dark">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo/logo.png')}}" alt="Logo">
            <img class="logo-fold" src="{{ asset('assets/images/logo/favicon.png') }}" alt="Logo">
        </a>
    </div>
    <div class="nav-wrap">
        <ul class="nav-left">
            <li class="desktop-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>

            <li class="mobile-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
        </ul>

        @if(env('AMBIENTE') === Biblioteca::AMBIENTE_DSV)
            <div class="nav-center d-flex align-content-center align-items-center">
                <h2 class="text-danger font-weight-bold">AMBIENTE DE DESENVOLVIMENTO</h2>
            </div>
        @endif

        <ul class="nav-right">
            <li class="dropdown dropdown-animated scale-left">
                <div class="pointer" data-toggle="dropdown">
                    <div class="avatar avatar-header avatar-image  m-h-10 m-r-15">
                        <i class="anticon anticon-user"></i>
                    </div>
                </div>
                <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                    <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                        <div class="d-flex m-r-50">
                            <div class="avatar avatar-header avatar-lg avatar-image">
                                <i class="anticon anticon-user"></i>
                            </div>
                            <div class="m-l-10">
                                <p class="m-b-0 text-dark font-weight-semibold">{{ Auth::user()->des_nome }}</p>

                                <p class="m-b-0 opacity-07">{{ Auth::user()->perfilAcesso->des_perfil }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('usuario.alterarMeusDados', ['usuario' => Crypt::encryptString(Auth::user()->id)]) }}" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Editar meus dados</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <a href="javascript:void(0);" id="btn-logout" date-route="{{ route('logout') }}" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                <span class="m-l-10">Sair</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>    