@php
    use App\Models\Configuracoes\Menu;
    use App\Components\Biblioteca;
    $menus = Menu::where('flg_ativo', Biblioteca::FLG_ATIVO)->get();
@endphp

<!-- Side Nav START -->
<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            @forelse ($menus as $menu)
                <li class="nav-item {{ $menu->des_menu === Menu::DASHBOARD_MENU ? 'open' : 'dropdown'}}">
                    <a @if($menu->des_menu === Menu::DASHBOARD_MENU) href="{{ route('home') }}" class="active" @else class="dropdown-toggle" href="javascript:void(0)" @endif>
                        <span class="icon-holder">
                            <i class="anticon anticon-{{ $menu->des_icon }}"></i>
                        </span>
                        <span class="title">{{ $menu->des_menu }}</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    @if(count($menu->submenu()->get()) > 0)
                        <ul class="dropdown-menu">
                            @foreach ($menu->submenu()->get() as $submenu)
                                {{-- Valida se o usuário tem acesso a funcionalidade --}}
                                @php $nomeGate = 'Acessar' . $submenu->des_funcionalidade; @endphp
                                @can($nomeGate)
                                    @if($submenu->isAtivo())
                                        <li>
                                            <a href="/{{ $submenu->des_link }}">{{ $submenu->des_funcionalidade }}</a>
                                        </li>
                                    @endif
                                @endcan
                            @endforeach
                        </ul>
                    @endif
                </li>
            @empty
            @endforelse
        </ul>
    </div>
</div>
<!-- Side Nav END -->