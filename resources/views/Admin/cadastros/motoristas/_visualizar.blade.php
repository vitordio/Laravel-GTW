<div class="page-header no-gutters has-tab">
    <div class="d-md-flex m-b-15 align-items-center justify-content-between">
        <div class="media align-items-center m-b-15">
            <div class="m-l-15">
                <h4 class="m-b-2">
                    <i class="m-r-5 text-dark anticon anticon-user"></i>
                    {{ $model->des_nome }}
                </h4>
                <span class="badge badge-pill badge-blue font-size-12 p-h-10">Status: <b>{{ $model->getStatus() }}</b></span>
            </div>
        </div>
        <div class="m-b-15">
            @can('EditarMotoristas')
                <a href="{{ route('motoristas.edit', ['motorista' => Crypt::encryptString($model->id)]) }}" class="m-r-5 button-edit p-v-10 p-h-20" title="@lang('labels.edit')" data-toggle="tooltip" data-placement="top">
                    <i class="anticon anticon-edit"></i>
                    <span class="m-l-3">@lang('labels.edit')</span>
                </a>
            @endcan
            @can('ExcluiMotoristas')
                <a class="delete-button button-delete p-v-10 p-h-20 m-r-15"
                    data-name="{{ $model->des_nome }}" data-id="{{ $model->id }}" data-method="DELETE" data-item="@lang('labels.motorista')"
                    title="@lang('labels.delete')" data-toggle="tooltip" data-placement="top"
                    href="{{ route('motoristas.destroy', ['motorista' => Crypt::encryptString($model->id)]) }}"> 
                    <i class="anticon anticon-delete"></i>
                    <span class="m-l-3">@lang('labels.delete')</span>
                </a>
            @endcan
            <a class="float-right font-size-13 text-muted" href="{{ url()->previous() }}">
                <i class="anticon anticon-arrow-left"></i>
                @lang('labels.back')
            </a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header dark">
                    <h4 class="card-title">
                        @lang('labels.entregasRealizadas')
                    </h4>
                </div>
                <div class="card-body p-15">
                    <h3 class="m-b-0 ls-1 align-center">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header dark">
                    <h4 class="card-title">@lang('labels.valorTotalEntregas')</h4>
                </div>
                <div class="card-body p-15">
                    <h3 class="m-b-0 ls-1 align-center">R$0,00</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header dark">
                    <h5 class="card-title">
                        @lang('labels.valorTotalFaturasPendentes')
                    </h4>
                </div>
                <div class="card-body p-15">
                    <h3 class="m-b-0 ls-1 align-center">R$0,00</h3>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-dark">
                <div class="card-header">
                    <h4 class="card-title">@lang('labels.dados')</h4>
                </div>
                <div class="card-body p-20">
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_nome')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_nome }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_nome_fantasia')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_nome_fantasia }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_cpf_cnpj')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_cpf_cnpj }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_email')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_email }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_telefone')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_telefone }}</p>
                    </div>

                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.tipo_atividade')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->tipoAtividade->des_atividade }}</p>
                    </div>

                    <div class="m-b-20">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.created_at')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $carbon::parse($model->created_at)->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
            <div class="card card-dark">
                <div class="card-header">
                    <h4 class="card-title">@lang('labels.endereco')</h4>
                </div>
                <div class="card-body p-20">
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_cep')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_cep }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_pais')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_pais }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_uf')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_uf }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_municipio')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_municipio }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_logradouro')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_logradouro }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_numero')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_numero }}</p>
                    </div>
                    <div class="m-b-20 border-bottom">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_complemento')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_complemento }}</p>
                    </div>
                    <div class="m-b-20">
                        <div class="media align-items-center m-b-5">
                            <div class="media-body">
                                <h5 class="m-b-0 text-white">
                                    @lang('labels.des_bairro')
                                </h5>
                            </div>
                        </div>
                        <p>{{ $model->des_bairro }}</p>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-9">
            <div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#coletas-motorista">@lang('labels.coletas')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#entregas-motorista">@lang('labels.entregas')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#faturas-motorista">@lang('labels.faturas')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#negociacoes-motorista">@lang('labels.negociacoes')</a>
                    </li>
                </ul>
                <div class="tab-content m-t-15 p-25">
                    <div class="tab-pane fade" id="coletas-motorista">
                        <p></p>
                    </div>
                    <div class="tab-pane fade" id="entregas-motorista">
                        <p></p>
                    </div>
                    <div class="tab-pane fade" id="faturas-motorista">
                        <p></p>
                    </div>
                    <div class="tab-pane fade" id="negociacoes-motorista">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>