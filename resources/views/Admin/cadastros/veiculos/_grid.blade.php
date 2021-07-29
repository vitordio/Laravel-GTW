<div class="m-t-25">
    <table id="data-table" class="table">
        <thead>
            <tr>
                <th>@lang('labels.id')</th>
                <th>@lang('labels.flg_ativo')</th>
                @canany(['VisualizarVeiculos', 'EditarVeiculos', 'ExcluirVeiculos'])
                    <th span="3">@lang('labels.acoes')</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->flg_ativo }}</td>
                    <td class="align-center">
                        @can('VisualizarVeiculos')
                            <a href="{{ route('veiculos.show', ['veiculo' => Crypt::encryptString($item->id)]) }}" class="m-r-5 button-view" title="@lang('labels.show')" data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-eye"></i>
                                <span class="m-l-3">@lang('labels.show')</span>
                            </a>
                        @endcan
                        @can('EditarVeiculos')
                            <a href="{{ route('veiculos.edit', ['veiculo' => Crypt::encryptString($item->id)]) }}" class="m-r-5 button-edit" title="@lang('labels.edit')" data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">@lang('labels.edit')</span>
                            </a>
                        @endcan
                        @can('ExcluirVeiculos')
                            <a class="delete-button button-delete"
                                data-name="{{ $item->des_veiculos }}" data-id="{{ $item->id }}" data-method="DELETE" data-item="@lang('labels.des_veiculos')"
                                title="@lang('labels.delete')" data-toggle="tooltip" data-placement="top"
                                href="{{ route('veiculos.destroy', ['veiculo' => Crypt::encryptString($item->id)]) }}"> 
                                <i class="anticon anticon-delete"></i>
                                <span class="m-l-3">@lang('labels.delete')</span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>