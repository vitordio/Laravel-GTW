@php
    use App\Components\Biblioteca;
@endphp
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
            <label for="des_funcionalidade">@lang('labels.des_funcionalidade')</label>
            <input type="text" 
                required
                class="form-control {{ $errors->has('des_funcionalidade') ? ' is-invalid' : '' }}"
                id="des_funcionalidade"
                name="des_funcionalidade"
                value="{{ old('des_funcionalidade', $model->des_funcionalidade) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_funcionalidade')">
            
            @if($errors->has('des_funcionalidade'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_funcionalidade') }}
                </div>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="des_link">@lang('labels.des_link')</label>
            <input type="text" 
                required
                class="form-control {{ $errors->has('des_link') ? ' is-invalid' : '' }}"
                id="des_link"
                name="des_link"
                value="{{ old('des_link', $model->des_link) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_link')">
            
            @if($errors->has('des_link'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_link') }}
                </div>
            @endif
        </div>

        <div class="form-group col-md-4">
            <label for="id_menu">@lang('labels.menu')</label>
            <select required id="id_menu" name="id_menu"
            class="form-control {{ $errors->has('id_menu') ? ' is-invalid' : '' }}"
            {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}>
                <option value="">Selecione</option>
                @foreach ($menus as $menu)
                    <option {{ old('id_menu', $model->id_menu) == $menu->id ? 'selected' : '' }} value="{{ $menu->id }}" >
                        {{ $menu->des_menu }}
                    </option>
                @endforeach
            </select>
            
            @if($errors->has('id_menu'))
                <div class="invalid-feedback">
                    {{ $errors->first('id_menu') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <input type="hidden" name="flg_ativo" value="{{ Biblioteca::FLG_DESATIVO }}" />
            <input
            type="checkbox"
            name="flg_ativo"
            value="{{ old('flg_ativo', Biblioteca::FLG_ATIVO) }}"
            {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
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
        <button type="submit" class="btn btn-primary">@lang('labels.salvar')</button>
    @endif
</form>