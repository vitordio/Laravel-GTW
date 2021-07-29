@php
    use App\Components\Biblioteca;
@endphp

<div class="modal modal-right fade" id="modalFormNewTipoAtividade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="side-modal-wrapper">
                <div class="vertical-align">
                    <div class="table-cell">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('labels.addTipoAtividade')</h5>
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
                            <form method="POST" name="modalFormNewTipoAtividade" action="{{ route('tipoAtividade.store') }}">
                                {{ method_field('POST') }}
                                {{ csrf_field() }}
                                
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="des_atividade">@lang('labels.des_atividade')</label>
                                        <input type="text" 
                                            required
                                            class="form-control {{ $errors->has('des_atividade') ? ' is-invalid' : '' }}"
                                            id="des_atividade"
                                            name="des_atividade"
                                            placeholder="@lang('labels.des_atividade')">
                                        
                                        @if($errors->has('des_atividade'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('des_atividade') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            
                                {{-- Input oculto com o campo de flg ativo como 'S' --}}
                                <input type="hidden" name="flg_ativo" value="{{ Biblioteca::FLG_ATIVO }}" />
                                
                                <button id="ajaxSubmit" class="btn btn-primary">@lang('labels.salvar')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="notification-toast top-left" id="notification-toast"></div>