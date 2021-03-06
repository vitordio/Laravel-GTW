@php
    use App\Models\CamposPersonalizados\ModelosGridExcel;
@endphp

<div class="page-header">
    <div class="d-flex justify-content-between">
        <div>    
            <h2 class="header-title">@lang('labels.clientes')</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('home') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>@lang('labels.dashboard')</a>
                    <a class="breadcrumb-item" href="#">@lang('labels.cadastros')</a>
                    <span class="breadcrumb-item active">@lang('labels.clientes')</span>
                </nav>
            </div>
        </div>

        @if(in_array(Route::currentRouteName(), ['clientes.index', 'clientes.exibeGridModelo']))
            <div>
                @can('ExcluirClientes')
                    <a class="btn button-deleteAll" id="button-deleteAll"
                        data-name="@lang('labels.deleteAllSelected')" data-method="POST" data-item="@lang('labels.cliente')"
                        href="{{ route('clientes.deleteAllSelected') }}"> 
                        <i class="anticon anticon-delete"></i>
                        <span class="m-l-3">@lang('labels.deleteAllSelected')</span>
                    </a>
                @endcan
                @can('GerarRelatorioClientes')
                    <a href="{{ route('clientes.exportarExcel', ['idModelo' => isset($modeloSelecionado) ? $modeloSelecionado->id : $modeloPadrao->id ]) }}"
                    class="btn btn-relatorio">
                        <i class="anticon anticon-file-excel m-r-5"></i>
                        @lang('labels.gerarRelatorio')
                    </a>
                @endcan
                @can('CriarClientes')
                    <a href="{{ route('clientes.create') }}" class="btn btn-primary" target="_blank">@lang('labels.novo_registro')</a>
                @endcan

                <div id="padrao-grid" hidden class="dropdown dropdown-animated scale-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <a href="#" class="text-dark" id="editModelo"
                            title="@lang('labels.editModelo')" data-toggle="tooltip" data-placement="top"
                            data-modelo-id="{{ isset($modeloSelecionado) ? $modeloSelecionado->id : $modeloPadrao->id }}"
                            data-modelo-nome="{{ isset($modeloSelecionado) ? $modeloSelecionado->des_modelo : $modeloPadrao->des_modelo }}"
                            data-modelo-route="{{ route('modelosGridExcel.getModelo', ['modelo' => isset($modeloSelecionado) ? $modeloSelecionado->id : $modeloPadrao->id]) }}"
                            data-modelo-route-update="{{ route('modelosGridExcel.update', ['modelosGridExcel' => isset($modeloSelecionado) ? $modeloSelecionado->id : $modeloPadrao->id]) }}"
                            data-modelo-route-delete="{{ route('modelosGridExcel.destroy', ['modelosGridExcel' => isset($modeloSelecionado) ? $modeloSelecionado->id : $modeloPadrao->id]) }}"
                        >
                            <i class="anticon anticon-setting m-r-5"></i>
                        </a>
                        <span>{{ isset($modeloSelecionado) ? $modeloSelecionado->des_modelo : $modeloPadrao->des_modelo }}</span>
                    </button>

                    <div class="dropdown-menu">
                        @forelse ($modelosGridExcel as $modelo)
                            <a data-item-modelo
                            data-item-id="{{ $modelo->id }}"
                            data-item-name="{{ $modelo->des_modelo }}"
                            class="dropdown-item 
                                @if(isset($modeloSelecionado) && $modelo->id === $modeloSelecionado->id) active
                                @elseif(!isset($modeloSelecionado) && $modelo->des_modelo === $modeloPadrao->des_modelo) active
                                @endif"
                            href="{{ route('clientes.exibeGridModelo', ['idModelo' => Crypt::encryptString($modelo->id)]) }}">
                                <i class="anticon anticon-small-dash m-r-5"></i>
                                {{ $modelo->des_modelo }}
                            </a>
                        @empty
                        @endforelse

                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" id="add-new-modelo" data-toggle="modal" data-target="#modeloGridExcel" type="button">
                            <i class="anticon anticon-plus m-r-5"></i>
                            @lang('labels.addNewModelo')
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@if(in_array(Route::currentRouteName(), ['clientes.index', 'clientes.exibeGridModelo']))
    <!-- View com o modal para preenchimento do modelo para exibi????o da grid e download do excel -->
    @include('Admin.cadastros.clientes._modelosGridExcel')
@endif