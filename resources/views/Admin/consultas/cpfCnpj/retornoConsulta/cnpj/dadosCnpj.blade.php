{{-- Dados CNPJ --}}
<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('labels.dadosCnpj')</h4>
    </div>
    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-6">
                <label for="des_razao_social">@lang('labels.des_razao_social')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_razao_social"
                        value="{{ $dadosRetornoApi->razao }}"
                        placeholder="@lang('labels.des_razao_social')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>

            <div class="col-md-3">
                <label for="des_nome_fantasia">@lang('labels.des_nome_fantasia')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_nome_fantasia"
                        value="{{ $dadosRetornoApi->fantasia }}"
                        placeholder="@lang('labels.des_nome_fantasia')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <label for="dat_inicio_atividade">@lang('labels.dat_inicio_atividade')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="dat_inicio_atividade"
                        value="{{ $dadosRetornoApi->inicioAtividade }}"
                        placeholder="@lang('labels.dat_inicio_atividade')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>
            
        </div>

        <div class="form-row mb-4">
            <div class="col-md-6">
                <label for="des_nome_responsavel">@lang('labels.des_nome_responsavel')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_nome_responsavel"
                        value="{{ $dadosRetornoApi->responsavel }}"
                        placeholder="@lang('labels.des_nome_responsavel')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>

            <div class="col-md-6">
                <label for="des_email">@lang('labels.des_email')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_email"
                        value="{{ $dadosRetornoApi->email }}"
                        placeholder="@lang('labels.des_email')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>
                </div>
            </div>
        </div>

        @isset($dadosRetornoApi->situacao)
            <div class="form-row mb-4">
                <div class="col-md-4">
                    <label for="situacao_cadastral">@lang('labels.situacao_cadastral')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="situacao_cadastral"
                            value="{{ $dadosRetornoApi->situacao->nome }}"
                            placeholder="@lang('labels.situacao_cadastral')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="dat_situacao_cadastral">@lang('labels.dat_situacao_cadastral')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="dat_situacao_cadastral"
                            value="{{ $dadosRetornoApi->situacao->data }}"
                            placeholder="@lang('labels.dat_situacao_cadastral')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

                @isset($dadosRetornoApi->porte)
                    <div class="col-md-4">
                        <label for="des_porte_empresa">@lang('labels.des_porte_empresa')</label>
                        <div class="input-affix">
                            <input type="text" 
                                readonly
                                class="form-control"
                                id="des_porte_empresa"
                                value="{{ $dadosRetornoApi->porte->descricao }}"
                                placeholder="@lang('labels.des_porte_empresa')">
                            <a class="text-dark suffix-input-icon font-size-18">
                                <i class="suffix-icon anticon anticon-copy"></i>
                            </a>

                        </div>
                    </div>
                @endisset
            </div>
        @endisset

        <h5 class="pt-4 border-top mb-4">@lang('labels.dadosTelefones')</h5>
        <div class="form-row mb-4">
            @forelse ($dadosRetornoApi->telefones as $telefone)
                <div class="col-md-3">
                    <label for="des_telefone">@lang('labels.des_telefone')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="des_telefone"
                            value="({{ $telefone->ddd }}) {{ $telefone->numero }}"
                            placeholder="@lang('labels.des_telefone')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>
            @empty
            @endforelse
        </div>

        @isset($dadosRetornoApi->simplesNacional)
            <h5 class="pt-4 border-top mb-4">@lang('labels.dadosSimplesNacional')</h5>
            <div class="form-row mb-4">
                <div class="col-md-2">
                    <label for="optanteSimplesNacional">@lang('labels.optanteSimplesNacional')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="optanteSimplesNacional"
                            value="{{ $dadosRetornoApi->simplesNacional->optante }}"
                            placeholder="@lang('labels.optanteSimplesNacional')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="dat_inicio_simplesNacional">@lang('labels.dat_inicio_simplesNacional')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="dat_inicio_simplesNacional"
                            value="{{ $dadosRetornoApi->simplesNacional->inicio }}"
                            placeholder="@lang('labels.dat_inicio_simplesNacional')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

                @if ($dadosRetornoApi->simplesNacional->fim)
                    <div class="col-md-3">
                        <label for="dat_fim_simplesNacional">@lang('labels.dat_fim_simplesNacional')</label>
                        <div class="input-affix">
                            <input type="text" 
                                readonly
                                class="form-control"
                                id="dat_fim_simplesNacional"
                                value="{{ $dadosRetornoApi->simplesNacional->fim }}"
                                placeholder="@lang('labels.dat_fim_simplesNacional')">
                            <a class="text-dark suffix-input-icon font-size-18">
                                <i class="suffix-icon anticon anticon-copy"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @endisset

        @isset($dadosRetornoApi->naturezaJuridica)
            <h5 class="pt-4 border-top mb-4">@lang('labels.dadosNaturezaJuridica')</h5>
            <div class="form-row mb-4">
                <div class="col-md-2">
                    <label for="cod_natureza_juridica">@lang('labels.cod_natureza_juridica')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="cod_natureza_juridica"
                            value="{{ $dadosRetornoApi->naturezaJuridica->codigo }}"
                            placeholder="@lang('labels.cod_natureza_juridica')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="des_natureza_juridica">@lang('labels.des_natureza_juridica')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="des_natureza_juridica"
                            value="{{ $dadosRetornoApi->naturezaJuridica->descricao }}"
                            placeholder="@lang('labels.des_natureza_juridica')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endisset
    </div>
</div>

{{-- Endereço CNPJ --}}
@isset($dadosRetornoApi->matrizEndereco)
    @include('Admin.consultas.cpfCnpj.retornoConsulta.cnpj._dadosEndereco')
@endisset

{{-- Sócios --}}
@isset($dadosRetornoApi->socios)
    @include('Admin.consultas.cpfCnpj.retornoConsulta.cnpj._dadosSocios')
@endisset