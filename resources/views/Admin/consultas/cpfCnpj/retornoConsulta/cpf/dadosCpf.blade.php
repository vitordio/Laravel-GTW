{{-- Dados CPF --}}
<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('labels.dadosCpf')</h4>
    </div>
    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-6">
                <label for="des_nome">@lang('labels.des_nome')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_nome"
                        value="{{ $dadosRetornoApi->nome }}"
                        placeholder="@lang('labels.des_nome')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>
            <div class="col-md-3">
                <label for="dat_nascimento">@lang('labels.dat_nascimento')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="dat_nascimento"
                        value="{{ $dadosRetornoApi->nascimento }}"
                        placeholder="@lang('labels.dat_nascimento')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>

            <div class="col-md-3">
                <label for="situacao_receita_federal">@lang('labels.situacao_receita_federal')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="situacao_receita_federal"
                        value="{{ $dadosRetornoApi->situacao }}"
                        placeholder="@lang('labels.situacao_receita_federal')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>