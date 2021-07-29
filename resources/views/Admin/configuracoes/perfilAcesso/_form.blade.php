@php
    use App\Components\Biblioteca;
@endphp

<script src="{{ asset('assets/js/perfilAcesso.js') }}"></script>

@if($model->exists)
    <form method="POST" action="{{ $options['route'] }}">
        {{ method_field('PUT') }}
@else
    <form method="POST" action="{{ $options['route'] }}">
        {{ method_field('POST') }}
@endif

{{ csrf_field() }}

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="des_perfil">@lang('labels.des_perfil')</label>
            <input type="text" 
                
                class="form-control {{ $errors->has('des_perfil') ? ' is-invalid' : '' }}"
                id="des_perfil"
                name="des_perfil"
                value="{{ old('des_perfil', $model->des_perfil) }}"
                {{-- Disable quando o método for visualizar, o perfil for administrador e o usuário não --}}
                {{ $options['method'] === Biblioteca::METHOD_SHOW || ($model->isAdmin() && !Auth::user()->isAdmin()) ? 'disabled' : '' }}
                placeholder="@lang('labels.des_perfil')">
            
            @if($errors->has('des_perfil'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_perfil') }}
                </div>
            @endif
        </div>
        <div class="form-group col-md-8">
            <label for="des_descricao_perfil">@lang('labels.des_descricao_perfil')</label>
            <input type="text" 
                
                class="form-control {{ $errors->has('des_descricao_perfil') ? ' is-invalid' : '' }}"
                id="des_descricao_perfil"
                name="des_descricao_perfil"
                value="{{ old('des_descricao_perfil', $model->des_descricao_perfil) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_descricao_perfil')">
            
            @if($errors->has('des_descricao_perfil'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_descricao_perfil') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Grid para seleção das funcionalidades do perfil de acesso --}}
    @include('Admin.configuracoes.perfilAcesso._gridFuncionalidades')

    <div class="form-group">
        <div class="checkbox">
            <input type="hidden" name="flg_ativo" value="{{ Biblioteca::FLG_DESATIVO }}" />
            <input
            type="checkbox"
            name="flg_ativo"
            value="{{ old('flg_ativo', Biblioteca::FLG_ATIVO) }}"
            {{-- Disable quando o método for visualizar, o perfil for administrador e o usuário não --}}
            {{ $options['method'] === Biblioteca::METHOD_SHOW || ($model->isAdmin() && !Auth::user()->isAdmin()) ? 'disabled' : '' }}
            {{ old('flg_ativo', $model->getOriginal('flg_ativo')) == Biblioteca::FLG_ATIVO || !$model->exists ? 'checked' : '' }}
            id="flg_ativo">
            
            <label for="flg_ativo">@lang('labels.flg_ativo') </label>
        </div>
    </div>

    {{-- Input oculto com o ID do usuário --}}
    @if($model->exists)
        <input type="hidden" name="id" value="{{ $model->id }}">
    @endif

    @if($options['method'] != Biblioteca::METHOD_SHOW)
        {{-- Disable quando o método for visualizar, o perfil for administrador e o usuário não --}}
        <button type="submit" {{ $options['method'] === Biblioteca::METHOD_SHOW || ($model->isAdmin() && !Auth::user()->isAdmin()) ? 'disabled' : '' }} class="btn btn-primary">@lang('labels.salvar')</button>
    @endif
</form>