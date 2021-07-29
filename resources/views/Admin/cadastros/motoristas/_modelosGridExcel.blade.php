@php
    use App\Components\Biblioteca;
    use App\Models\Cadastros\Motoristas;
@endphp

<div class="modal modal-right fade" id="modeloGridExcel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="side-modal-wrapper">
                <div class="vertical-align">
                    <div class="table-cell">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('labels.addNewModelo')</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="anticon anticon-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- Mensagens de validação quando há algum erro no request --}}
                            <div class="alert alert-danger d-none" id="alert-errors">
                                <div class="d-flex justify-content-start" id="messages-validation">
                                    <span class="alert-icon m-r-20 font-size-30">
                                        <i class="anticon anticon-close-circle"></i>
                                    </span>
                                    <div>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" name="gridExcelModelo" action="{{ $optionsModelo['route'] }}">
                                {{ method_field('POST') }}
                                {{ csrf_field() }}
                                
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="des_modelo">@lang('labels.des_modelo')</label>
                                        <input type="text" 
                                            required
                                            class="form-control"
                                            id="des_modelo"
                                            name="des_modelo"
                                            maxlength="60"
                                            placeholder="@lang('labels.des_modelo')">
                                        
                                        @if($errors->has('des_modelo'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('des_modelo') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <label>@lang('labels.selecioneAsColunas')</label>
                                <div class="form-row">
                                    @forelse ((new Motoristas())->getTableColumns() as $columnName)
                                        {{-- Não exibimos para seleção a coluna ID, sempre incluímos ela no modelo --}}
                                        @if($columnName !== Biblioteca::ID)
                                            <div class="form-group col-md-6 checkbox">
                                                <input
                                                    type="checkbox"
                                                    name="colunas[{{ $columnName }}]"
                                                    value="{{ old($columnName, Biblioteca::FLG_ATIVO) }}"
                                                    data-colunas
                                                    id="{{ $columnName }}">
                                                <label for="{{ $columnName }}">@lang('labels.' . $columnName)</label>
                                            </div>
                                        @endif

                                    @empty
                                        
                                    @endforelse
                                </div>
                                        
                                {{-- Input hidden com o id da funcionalidade de motoristas --}}
                                <input type="hidden" name="id_funcionalidade" value="{{ $idFuncionalidade }}">
                                <input type="hidden" id="routeCreateModelo" value="{{ $optionsModelo['route'] }}">
                                <button id="ajaxSubmit" class="btn btn-primary">@lang('labels.salvar')</button>

                                {{-- Botão para deletar o modelo, iremos substituir os names e ids pelo do modelo clicado --}}
                                <a class="btn button-deleteAll delete-button" hidden
                                    id="button-delete-modelo"
                                    data-name="{MODELO}" data-id="{MODELO_ID}" data-method="DELETE" data-item="@lang('labels.modeloGridExcel')"
                                    title="@lang('labels.delete')" data-toggle="tooltip" data-placement="top"
                                    href="#"> 
                                    <i class="anticon anticon-delete"></i>
                                    <span class="m-l-3">@lang('labels.delete')</span>
                                </a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="notification-toast top-left" id="notification-toast"></div>