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
            <label for="des_menu">@lang('labels.des_menu')</label>
            <input type="text" 
                required
                class="form-control {{ $errors->has('des_menu') ? ' is-invalid' : '' }}"
                id="des_menu"
                name="des_menu"
                value="{{ old('des_menu', $model->des_menu) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_menu')">
            
            @if($errors->has('des_menu'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_menu') }}
                </div>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="des_icon">@lang('labels.des_icon')</label>
            <input type="text" 
                required
                class="form-control {{ $errors->has('des_icon') ? ' is-invalid' : '' }}"
                id="des_icon"
                name="des_icon"
                value="{{ old('des_icon', $model->des_icon) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_icon')">
            
            @if($errors->has('des_icon'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_icon') }}
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