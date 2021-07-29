<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('labels.endereco')</h4>
    </div>
    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-4">
                <label for="des_cep">@lang('labels.des_cep')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_cep"
                        value="{{ $dadosRetornoApi->matrizEndereco->cep }}"
                        placeholder="@lang('labels.des_cep')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>

            <div class="col-md-2">
                <label for="des_uf">@lang('labels.des_uf')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_uf"
                        value="{{ $dadosRetornoApi->matrizEndereco->uf }}"
                        placeholder="@lang('labels.des_uf')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <label for="des_municipio">@lang('labels.des_municipio')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_municipio"
                        value="{{ $dadosRetornoApi->matrizEndereco->cidade }}"
                        placeholder="@lang('labels.des_municipio')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>
        </div>

        <div class="form-row mb-4">
            <div class="col-md-4">
                <label for="des_logradouro">@lang('labels.des_logradouro')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_logradouro"
                        value="{{ $dadosRetornoApi->matrizEndereco->logradouro }}"
                        placeholder="@lang('labels.des_logradouro')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-2">
                <label for="des_numero">@lang('labels.des_numero')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_numero"
                        value="{{ $dadosRetornoApi->matrizEndereco->numero }}"
                        placeholder="@lang('labels.des_numero')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <label for="des_complemento">@lang('labels.des_complemento')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_complemento"
                        value="{{ $dadosRetornoApi->matrizEndereco->complemento }}"
                        placeholder="@lang('labels.des_complemento')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>

                </div>
            </div>

            <div class="col-md-3">
                <label for="des_bairro">@lang('labels.des_bairro')</label>
                <div class="input-affix">
                    <input type="text" 
                        readonly
                        class="form-control"
                        id="des_bairro"
                        value="{{ $dadosRetornoApi->matrizEndereco->bairro }}"
                        placeholder="@lang('labels.des_bairro')">
                    <a class="text-dark suffix-input-icon font-size-18">
                        <i class="suffix-icon anticon anticon-copy"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>