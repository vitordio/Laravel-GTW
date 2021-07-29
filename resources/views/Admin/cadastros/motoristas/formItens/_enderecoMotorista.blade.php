@php
    use App\Components\Biblioteca;
    use App\Models\Cadastros\Clientes;
@endphp

<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('labels.endereco')</h4>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div id="divCep" class="form-group col-md-4">
                <label for="des_cep">@lang('labels.des_cep')</label>
                <input type="text" 
                    required
                    class="form-control cep {{ $errors->has('des_cep') ? ' is-invalid' : '' }}"
                    id="des_cep"
                    name="des_cep"
                    maxlength="9"
                    value="{{ old('des_cep', $model->des_cep) }}"
                    placeholder="@lang('labels.mask_cep')">
                
                @if($errors->has('des_cep'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_cep') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-4">
                <label for="des_pais">@lang('labels.des_pais')</label>
                <select required id="des_pais" name="des_pais"
                    class="select2 {{ $errors->has('des_pais') ? ' is-invalid' : '' }}"
                >
                    <option value="">Selecione</option>
                    @foreach (Biblioteca::getPaisesIBGE() as $pais)
                        <option {{ old('des_pais', $model->des_pais) == $pais->nome ? 'selected' : '' }} value="{{ $pais->nome }}" >
                            {{ $pais->nome }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('des_pais'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_pais') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-4">
                <label for="des_uf">@lang('labels.des_uf')</label>
                <select required id="des_uf" name="des_uf"
                    class="select2 {{ $errors->has('des_uf') ? ' is-invalid' : '' }}"
                >
                    @foreach (Biblioteca::getUfsIBGE() as $uf)
                        <option {{ old('des_uf', $model->des_uf) == $uf->sigla ? 'selected' : '' }} value="{{ $uf->sigla }}" >
                            {{ $uf->sigla }}
                        </option>
                    @endforeach
                    <option value="EX" {{ old('des_uf', $model->des_uf) == 'EX' ? 'selected' : '' }}>EX</option> {{-- Opção para exterior --}}
                </select>
                
                @if($errors->has('des_uf'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_uf') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="des_municipio">@lang('labels.des_municipio')</label>
                
                <select required id="des_municipio" name="des_municipio"
                    class="select2 {{ $errors->has('des_municipio') ? ' is-invalid' : '' }}"
                >
                    {{--
                        No cadastro, passamos AC pois é o primeiro item exibido ao acessar o form,
                        na edição, passamos a UF selecionada no cadastro.

                        Verificação para passar como parâmetro a UF da model, ou do old da validação
                    --}}
                    @php
                        $ufSelecionada = 'AC';
                        if($model->exists)
                            $ufSelecionada = $model->des_uf;
                        elseif(old('des_municipio') && old('des_uf'))
                            $ufSelecionada = old('des_uf');
                        else
                            $ufSelecionada = 'AC';

                    @endphp
                    <option value="">Selecione</option>

                    @foreach (Biblioteca::getMunicipiosPorUF($ufSelecionada) as $cidade)
                        <option {{ old('des_municipio', $model->des_municipio) == $cidade->nome ? 'selected' : '' }} value="{{ $cidade->nome }}" >
                            {{ $cidade->nome }}
                        </option>
                    @endforeach

                    <option value="EXTERIOR" {{ old('des_municipio', $model->des_municipio) == 'EXTERIOR' ? 'selected' : '' }}>EXTERIOR</option> {{-- Opção para exterior --}}
                </select> 
                @if($errors->has('des_municipio'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_municipio') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="des_logradouro">@lang('labels.des_logradouro')</label>
                <input type="text" 
                    required
                    class="form-control {{ $errors->has('des_logradouro') ? ' is-invalid' : '' }}"
                    id="des_logradouro"
                    name="des_logradouro"
                    maxlength="255"
                    value="{{ old('des_logradouro', $model->des_logradouro) }}"
                    placeholder="@lang('labels.des_logradouro')">
                
                @if($errors->has('des_logradouro'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_logradouro') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-2">
                <label for="des_numero">@lang('labels.des_numero')</label>
                <input type="text" 
                    required
                    class="form-control {{ $errors->has('des_numero') ? ' is-invalid' : '' }}"
                    id="des_numero"
                    name="des_numero"
                    maxlength="60"
                    value="{{ old('des_numero', $model->des_numero) }}"
                    placeholder="@lang('labels.des_numero')">
                
                @if($errors->has('des_numero'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_numero') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="des_complemento">@lang('labels.des_complemento')</label>
                <input type="text" 
                    class="form-control {{ $errors->has('des_complemento') ? ' is-invalid' : '' }}"
                    id="des_complemento"
                    name="des_complemento"
                    maxlength="60"
                    value="{{ old('des_complemento', $model->des_complemento) }}"
                    placeholder="@lang('labels.des_complemento')">
                
                @if($errors->has('des_complemento'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_complemento') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="des_bairro">@lang('labels.des_bairro')</label>
                <input type="text" 
                    required
                    class="form-control {{ $errors->has('des_bairro') ? ' is-invalid' : '' }}"
                    id="des_bairro"
                    name="des_bairro"
                    maxlength="60"
                    value="{{ old('des_bairro', $model->des_bairro) }}"
                    placeholder="@lang('labels.des_bairro')">
                
                @if($errors->has('des_bairro'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_bairro') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>