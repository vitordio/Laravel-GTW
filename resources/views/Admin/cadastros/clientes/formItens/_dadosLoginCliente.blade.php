@php
    use App\Components\Biblioteca;
@endphp

<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('labels.dadosLoginCliente')</h4>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="des_login">@lang('labels.des_login')</label>
                <input type="text"
                    {{-- required --}}
                    class="form-control {{ $errors->has('des_login') ? ' is-invalid' : '' }}"
                    id="des_login"
                    name="des_login"
                    value="{{ old('des_login', $model->des_login) }}"
                    {{ $options['method'] === Biblioteca::METHOD_SHOW ? 'disabled' : '' }}
                    placeholder="@lang('labels.des_login')">
    
                @if($errors->has('des_login'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_login') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-4">
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
            <div class="form-group col-md-4">
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
    </div>
</div>