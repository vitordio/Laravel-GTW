@php
    use App\Components\Biblioteca;
    use App\Models\Configuracoes\RelFuncionalidadePerfil;
    use App\Models\Configuracoes\Log;
@endphp

<table class="table table-hover">
    <thead>
        <tr>
            <th width="60%">@lang('labels.funcionalidades')</th>
            <th width="40%">@lang('labels.des_permissoes')</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($menus as $menu)
            <tr class="tr-color">
                <td>
                    <span class="icon-holder">
                        <i class="anticon anticon-{{ $menu->des_icon }}"></i>
                    </span>
                    <span class="p-l-10">{{ $menu->des_menu }}</span>
                </td>
                <td></td>
            </tr>
            @empty(!$menu->submenu()->get())
                @foreach ($menu->submenu()->get() as $submenu)
                    @if($submenu->isAtivo())
                        <tr>
                            <td class="p-l-50">{{ $submenu->des_funcionalidade }}</td>
                            <td>
                                <div class="form-check-inline checkbox">
                                    <input type="checkbox"
                                        value="{{ Biblioteca::FLG_ATIVO }}"
                                        id="{{ ('selecionar_todos_'. $submenu->id) }}"
                                        data-id="selecionar_todos"
                                        {{
                                            $options['method'] === Biblioteca::METHOD_SHOW
                                            {{-- Disable quando o método for visualizar, o perfil for administrador e o usuário não --}}
                                            || ($model->isAdmin() && !Auth::user()->isAdmin())
                                            || ($submenu->des_funcionalidade === (new Log())->getNomFuncionalidade() && $permissao->des_permissao !== Biblioteca::ACTION_VISUALIZAR)
                                            ? 'disabled' : ''
                                        }}
                                    >
                                    <label for="{{ ('selecionar_todos_'. $submenu->id) }}">@lang('labels.todos')</label>
                                </div>
                                @foreach ($permissoes as $permissao)
                                    <div class="form-check-inline checkbox">
                                        <input type="checkbox"
                                            name="{{ ('flg_submenu_'. $permissao->id .'_'. $submenu->id) }}"
                                            value="{{ old('flg_submenu_' . $permissao->id .'_'. $submenu->id , Biblioteca::FLG_ATIVO) }}"
                                            data-id="{{ ('flg_submenu_'. $submenu->id) }}"
                                            id="{{ ('flg_submenu_'. $permissao->id .'_'. $submenu->id) }}"
                                            {{
                                                $options['method'] === Biblioteca::METHOD_SHOW
                                                {{-- Disable quando o método for visualizar, o perfil for administrador e o usuário não --}}
                                                || ($model->isAdmin() && !Auth::user()->isAdmin()) 
                                                || ($submenu->des_funcionalidade === (new Log())->getNomFuncionalidade() && $permissao->des_permissao !== Biblioteca::ACTION_VISUALIZAR)
                                                ? 'disabled' : ''
                                            }}
                                            {{
                                                RelFuncionalidadePerfil::hasPermissaoFuncionalidade($model, $permissao, $submenu)
                                                || old('flg_submenu_' . $permissao->id .'_'. $submenu->id) == Biblioteca::FLG_ATIVO
                                                ? 'checked' : ''
                                            }}
                                        >
                                        <label for="{{ ('flg_submenu_'. $permissao->id .'_'. $submenu->id) }}">{{ $permissao->des_permissao }}</label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endempty
        @empty
        @endforelse
        
    </tbody>
</table>