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
            <label for="des_nome">@lang('labels.des_nome')</label>
            <input type="text" 
                required
                class="form-control {{ $errors->has('des_nome') ? ' is-invalid' : '' }}"
                id="des_nome"
                name="des_nome"
                value="{{ old('des_nome', $model->des_nome) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_nome')">
            
            @if($errors->has('des_nome'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_nome') }}
                </div>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="des_email">@lang('labels.des_email')</label>
            <input type="email"
                required
                class="form-control {{ $errors->has('des_email') ? ' is-invalid' : '' }}"
                id="des_email"
                name="des_email"
                value="{{ old('des_email', $model->des_email) }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.des_email')">

            @if($errors->has('des_email'))
                <div class="invalid-feedback">
                    {{ $errors->first('des_email') }}
                </div>
            @endif
        </div>
        @can('EditarPerfilAcesso')
            <div class="form-group col-md-4">
                <label for="id_perfil_acesso">@lang('labels.des_perfil')</label>
                <select required id="id_perfil_acesso" name="id_perfil_acesso"
                class="form-control {{ $errors->has('id_perfil_acesso') ? ' is-invalid' : '' }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}>
                    <option value="">Selecione</option>
                    @foreach ($perfisAcesso as $perfil)
                        <option {{ old('id_perfil_acesso', $model->id_perfil_acesso) == $perfil->id ? 'selected' : '' }} value="{{ $perfil->id }}" >
                            {{ $perfil->des_perfil }}
                        </option>
                    @endforeach
                </select>
                
                @if($errors->has('id_perfil_acesso'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_perfil_acesso') }}
                    </div>
                @endif
            </div>
        @endcan
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">@lang('labels.password')</label>
            <input type="password"
                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                id="password"
                name="password"
                value="{{ old('password') }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.password')">

            @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label for="password_confirmation">@lang('labels.password_confirmation')</label>
            <input type="password"
                class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                id="password_confirmation"
                name="password_confirmation"
                value="{{ old('password_confirmation') }}"
                {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                placeholder="@lang('labels.password_confirmation')">

            @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">
                    {{ $errors->first('password_confirmation') }}
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