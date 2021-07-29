<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('labels.sociosCnpj')</h4>
    </div>
    <div class="card-body">
        @forelse ($dadosRetornoApi->socios as $id => $socio)
            <div class="form-row mb-4">
                <div class="col-md-4">
                    <label for="des_nome">@lang('labels.des_nome')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="des_nome_{{$id}}"
                            value="{{ $socio->nome }}"
                            placeholder="@lang('labels.des_nome')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>

                    </div>
                </div>

                <div class="col-md-3">
                    <label for="des_tipo">@lang('labels.des_tipo')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="des_tipo_{{$id}}"
                            value="{{ $socio->tipo }}"
                            placeholder="@lang('labels.des_tipo')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="des_capital_inicial">@lang('labels.des_capital_inicial')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="des_capital_inicial_{{$id}}"
                            id="des_capital_inicial"
                            value="{{ $socio->capitalSocial }}"
                            placeholder="@lang('labels.des_capital_inicial')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="des_pais">@lang('labels.des_pais')</label>
                    <div class="input-affix">
                        <input type="text" 
                            readonly
                            class="form-control"
                            id="des_pais_{{$id}}"
                            value="{{ $socio->pais }}"
                            placeholder="@lang('labels.des_pais')">
                        <a class="text-dark suffix-input-icon font-size-18">
                            <i class="suffix-icon anticon anticon-copy"></i>
                        </a>
                    </div>
                </div>

            </div>
        @empty
        @endforelse
    </div>
</div>