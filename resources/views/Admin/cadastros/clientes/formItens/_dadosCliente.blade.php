@php
    use App\Components\Biblioteca;
    use App\Models\Cadastros\Clientes;
@endphp

<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('labels.dadosClientes')</h4>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="des_cpf_cnpj">@lang('labels.des_cpf_cnpj')</label>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <select
                            id="tipo_cliente"
                            name="tipo_cliente"
                            class="form-control {{ $errors->has('tipo_cliente') ? ' is-invalid' : '' }}"
                        >
                            <option {{ old('tipo_cliente', $model->tipo_cliente) == Clientes::CPF || !$model->isPj() ? 'selected' : '' }} value="CPF" >
                                CPF
                            </option>
                            <option {{ old('tipo_cliente', $model->tipo_cliente) == Clientes::CNPJ || $model->isPj() ? 'selected' : '' }} value="CNPJ" >
                                CNPJ
                            </option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" 
                            required
                            class="form-control {{ old('tipo_cliente', $model->tipo_cliente) == Clientes::CNPJ || $model->isPj() ? 'cnpj' : 'cpf' }} {{ $errors->has('des_cpf_cnpj') ? ' is-invalid' : '' }}"
                            id="des_cpf_cnpj"
                            name="des_cpf_cnpj"
                            value="{{ old('des_cpf_cnpj', $model->des_cpf_cnpj) }}"
                            placeholder="@lang('labels.mask_cpf')">
                        
                        @if($errors->has('des_cpf_cnpj'))
                            <div class="invalid-feedback">
                                {{ $errors->first('des_cpf_cnpj') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group col-md-7">
                <label for="des_inscricao_estadual">@lang('labels.des_inscricao_estadual')</label>
                <div class="row">
                    <div class="col-md-9 mb-2">
                        <input type="text" 
                            class="form-control {{ $errors->has('des_inscricao_estadual') ? ' is-invalid' : '' }}"
                            id="des_inscricao_estadual"
                            name="des_inscricao_estadual"
                            maxlength="14"
                            value="{{ old('des_inscricao_estadual', $model->des_inscricao_estadual) }}"
                            placeholder="@lang('labels.des_inscricao_estadual')">

                            @if($errors->has('des_inscricao_estadual'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('des_inscricao_estadual') }}
                                </div>
                            @endif
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <input type="hidden" name="flg_isento" value="{{ Biblioteca::FLG_DESATIVO }}" />
                            <input
                                type="checkbox"
                                name="flg_isento"
                                value="{{ old('flg_isento', Biblioteca::FLG_ATIVO) }}"
                                {{ old('flg_isento', $model->flg_isento) == 'S' || $model->des_inscricao_estadual == Clientes::ISENTO ? 'checked' : '' }}
                                id="flg_isento">
                            <label for="flg_isento">@lang('labels.flg_isento')</label>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="des_nome">@lang('labels.des_nome')</label>
                <input type="text" 
                    required
                    class="form-control {{ $errors->has('des_nome') ? ' is-invalid' : '' }}"
                    id="des_nome"
                    name="des_nome"
                    maxlength="60"
                    value="{{ old('des_nome', $model->des_nome) }}"
                    placeholder="@lang('labels.des_nome')">
                
                @if($errors->has('des_nome'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_nome') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="des_nome_fantasia">@lang('labels.des_nome_fantasia')</label>
                <input type="text" 
                    class="form-control {{ $errors->has('des_nome_fantasia') ? ' is-invalid' : '' }}"
                    id="des_nome_fantasia"
                    name="des_nome_fantasia"
                    maxlength="60"
                    value="{{ old('des_nome_fantasia', $model->des_nome_fantasia) }}"
                    placeholder="@lang('labels.des_nome_fantasia')">
                
                @if($errors->has('des_nome_fantasia'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_nome_fantasia') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="des_divisao">@lang('labels.des_divisao')</label>
                <div class="row">
                    <div class="col-md-9 mb-2">
                        <input type="text" 
                            class="form-control {{ $errors->has('des_divisao') ? ' is-invalid' : '' }}"
                            id="des_divisao"
                            name="des_divisao"
                            maxlength="70"
                            value="{{ old('des_divisao', $model->des_divisao) }}"
                            {{ old('flg_habilitar', $model->flg_habilitar) != 'S' && $model->des_divisao == '' ? 'readonly' : '' }}
                            placeholder="@lang('labels.des_divisao')">
                        
                        @if($errors->has('des_divisao'))
                            <div class="invalid-feedback">
                                {{ $errors->first('des_divisao') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">                              
                            <input type="hidden" name="flg_habilitar" value="{{ Biblioteca::FLG_DESATIVO }}" />
                            <input
                                type="checkbox"
                                name="flg_habilitar"
                                value="{{ Biblioteca::FLG_ATIVO }}"
                                {{ old('flg_habilitar', $model->flg_habilitar) == 'S' || $model->des_divisao != '' ? 'checked' : '' }}
                                id="flg_habilitar">
                            <label for="flg_habilitar">@lang('labels.flg_habilitar')</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="des_telefone">@lang('labels.des_telefone')</label>
                <input type="text" 
                    class="form-control telefone {{ $errors->has('des_telefone') ? ' is-invalid' : '' }}"
                    id="des_telefone"
                    name="des_telefone"
                    maxlength="14" 
                    value="{{ old('des_telefone', $model->des_telefone) }}"
                    placeholder="@lang('labels.mask_teleofne')">
                
                @if($errors->has('des_telefone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('des_telefone') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-7" id="row_emails">
                <label for="des_email">@lang('labels.des_email')</label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="email" 
                            class="form-control {{ $errors->has('des_email') ? ' is-invalid' : '' }}"
                            id="des_email"
                            name="des_email"
                            maxlength="60"
                            value="{{ old('des_email', $model->des_email) }}"
                            placeholder="@lang('labels.des_email')">
                        
                        @if($errors->has('des_email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('des_email') }}
                            </div>
                        @endif
                    </div>
                    {{-- Botão para adicionar novos campos de e-mails dincamicamente --}}
                    <div class="col-md-6 d-flex flex-column align-content-start flex-wrap justify-content-top">
                        <button type="button" class="btn add-emailsAlternativos" id="add-emailsAlternativos">
                            <i class="anticon anticon-plus mr-2"></i>
                            @lang('labels.adicionarEmailsAlternativos')
                        </button>
                    </div>                        
                </div>

                <div class="row mb-2" hidden id="row-emailsAlternativos_copy" data-email-alternativo>
                    {{-- Linha utilizada para cópia dos e-mails a serem adicionados --}}
                    <div class="col-md-6">
                        <input type="email" 
                            class="form-control {{ $errors->has('des_email_alternativo_copy') ? ' is-invalid' : '' }}"
                            id="des_email_alternativo_copy"
                            name="emailsAlternativos[des_email_alternativo_copy]"
                            maxlength="60"
                            value="{{ old('des_email_alternativo_copy', $model->des_email_alternativo_copy) }}"
                            disabled
                            placeholder="@lang('labels.des_email_alternativo')">
                        
                        @if($errors->has('des_email_alternativo_copy'))
                            <div class="invalid-feedback">
                                {{ $errors->first('des_email_alternativo_copy') }}
                            </div>
                        @endif
                    </div>

                    {{-- Botão para remover o campo da linha --}}
                    <div class="col-md-6 d-flex flex-column align-content-start flex-wrap justify-content-center">
                        <button onclick="removeEmail(this.id)" type="button" class="btn remove-emailsAlternativos" id="remove-emailsAlternativos_copy">
                            <i class="anticon anticon-close mr-2"></i>
                            @lang('labels.removerEmail')
                        </button>
                    </div>
                </div>

                @if(old('emailsAlternativos'))
                    @foreach (old('emailsAlternativos') as $key => $email)
                        @php
                            // Pegamos o ID da linha para inserir no botão de remoção
                            $idLinha = explode('_', $key);
                            $idLinha = end($idLinha)
                        @endphp
                        <div class="row mb-2" id="row-emailsAlternativos_{{$idLinha}}" data-email-alternativo>
                            {{-- Linha utilizada para cópia dos e-mails a serem adicionados --}}
                            <div class="col-md-6">
                                <input type="email" 
                                    class="form-control {{ $errors->has('emailsAlternativos.' . $key) ? ' is-invalid' : '' }}"
                                    id="{{$key}}"
                                    name="emailsAlternativos[{{$key}}]"
                                    maxlength="60"
                                    value="{{ $email }}"
                                    placeholder="@lang('labels.des_email_alternativo')">
                                
                                @if($errors->has('emailsAlternativos.' . $key))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('emailsAlternativos.' . $key)  }}
                                    </div>
                                @endif
                            </div>
    
                            {{-- Botão para remover o campo da linha --}}
                            <div class="col-md-6 d-flex flex-column align-content-start flex-wrap justify-content-center">
                                <button onclick="removeEmail(this.id)" type="button" class="btn remove-emailsAlternativos" id="remove-emailsAlternativos_{{$idLinha}}">
                                    <i class="anticon anticon-close mr-2"></i>
                                    @lang('labels.removerEmail')
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fazemos um foreach nos campos caso haja a validação e também para trazer no método editar --}}
                    @forelse ($model->emailsAlternativos as $key => $email)
                        <div class="row mb-2" id="row-emailsAlternativos_{{$key}}" data-email-alternativo>
                            {{-- Linha utilizada para cópia dos e-mails a serem adicionados --}}
                            <div class="col-md-6">
                                <input type="email" 
                                    class="form-control {{ $errors->has('emailsAlternativos.des_email_alternativo_' . $key) ? ' is-invalid' : '' }}"
                                    id="des_email_alternativo_{{$key}}"
                                    name="emailsAlternativos[des_email_alternativo_{{$key}}]"
                                    maxlength="60"
                                    value="{{ $email->des_email }}"
                                    placeholder="@lang('labels.des_email_alternativo')">
                                
                                @if($errors->has('emailsAlternativos.des_email_alternativo_' . $key))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('emailsAlternativos.des_email_alternativo_' . $key)  }}
                                    </div>
                                @endif
                            </div>
    
                            {{-- Botão para remover o campo da linha --}}
                            <div class="col-md-6 d-flex flex-column align-content-start flex-wrap justify-content-center">
                                <button onclick="removeEmail(this.id)" type="button" class="btn remove-emailsAlternativos" id="remove-emailsAlternativos_{{$key}}">
                                    <i class="anticon anticon-close mr-2"></i>
                                    @lang('labels.removerEmail')
                                </button>
                            </div>
                        </div>
                    @empty
                    @endforelse
                @endif
            </div>
            <div class="form-group col-md-5">
                <label for="id_tipo_atividade">@lang('labels.id_tipo_atividade')</label>
                <div class="row">
                    <div class="col-md-6">
                        <select required id="id_tipo_atividade" name="id_tipo_atividade"
                            class="form-control {{ $errors->has('id_tipo_atividade') ? ' is-invalid' : '' }}"
                        >
                            @foreach ($tiposAtividade as $atividade)
                                <option {{ old('id_tipo_atividade', $model->id_tipo_atividade) == $atividade->id ? 'selected' : '' }} value="{{ $atividade->id }}" >
                                    {{ $atividade->des_atividade }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('id_tipo_atividade'))
                            <div class="invalid-feedback">
                                {{ $errors->first('id_tipo_atividade') }}
                            </div>
                        @endif
                    </div>

                    {{-- Botão para remover o campo da linha --}}
                    <div class="col-md-6 d-flex flex-column align-content-start flex-wrap justify-content-center">
                        <button type="button" class="btn add-tipoAtividade" data-toggle="modal" data-target="#modalFormNewTipoAtividade" id="btn-addTipoAtividade">
                            <i class="anticon anticon-plus mr-2"></i>
                            @lang('labels.addTipoAtividade')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>