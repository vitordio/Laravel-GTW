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
            <label for="des_atividade">@lang('labels.des_atividade')</label>
            <input type="text" 
                required
                class="form-control {{ $errors->has('des_atividade') ? ' is-invalid' : '' }}"
                id="des_atividade"
                name="des_atividade"
                value="{{ old('des_atividade', $model->des_atividade) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_atividade')">
            
            @if($errors->has('des_atividade'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_atividade') }}
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