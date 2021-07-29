@php
    use App\Components\Biblioteca;
@endphp

<div class="m-t-25">
    <table id="ajax-data-table" class="table">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" class="select-all" id="select-all">
                </th>

                {{-- Se não houver modelo selecionado, exibe as colunas padrão --}}
                @if(isset($modeloSelecionado))
                    @foreach ($modeloSelecionado->colunas as $coluna)
                        @if($coluna !== Biblioteca::ID)
                            <th>@lang('labels.' . $coluna)</th>
                        @endif
                    @endforeach
                @else
                    @foreach ($modeloPadrao->colunas as $coluna)
                        @if($coluna !== Biblioteca::ID)
                            <th>@lang('labels.' . $coluna)</th>
                        @endif
                    @endforeach
                @endif

                @canany(['VisualizarMotoristas', 'EditarMotoristas', 'ExcluirMotoristas'])
                    <th span="3">@lang('labels.acoes')</th>
                @endcanany
            </tr>
        </thead>

        {{-- Populamos a tabela com o yajra/DataTable ajax --}}
        <tbody>
        </tbody>
    </table>
</div>

@section('scripts')

    <script>
        $(document).ready(function() {
            /**
             * Como as colunas não são estáticas, mudam de acordo com o modelo,
             * fazemos um fetch para pegar as informações do modelo e atribuímos na
             * propriedade columns do dataTable
             */
            const route = "{{ route('modelosGridExcel.getModelo', ['modelo' => isset($modeloSelecionado) ? $modeloSelecionado->id : $modeloPadrao->id]) }}";
            fetch(route)
            .then(resp => resp.json())
            .then(dadosModelo => {
                const arrColunas = dadosModelo.filter(coluna => coluna != 'id').map(coluna => {
                    return { data: coluna, name: coluna }
                })

                arrColunas.unshift({ data: 'checkbox', name: 'checkbox', orderable: false, searchable: false });
                
                // Verificamos se a coluna ações foi criada (tem alguma permissão além de visualizar a grid)
                const thActions = document.querySelector('table > thead > tr > th:last-child').innerText
                if(thActions === 'Ações')
                    arrColunas.push({ data: 'action', name: 'action', orderable: false, searchable: false });

                $('#ajax-data-table').DataTable(
                {
                    serverSide: true,
                    ajax: "{{ route('motoristas.ajaxDataTable', ['idModelo' => isset($modeloSelecionado) ? $modeloSelecionado->id : $modeloPadrao->id ]) }}",
                    columns: arrColunas,
                    searching: true,
                    paging: true,
                    sort: true,
                    info: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 30,
                    lengthMenu: [[10, 30, 50, -1], [10, 30, 50, "Todos"]],
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
                    },
                });
            })
        } );
    </script>

    <script src="{{ asset('assets/js/deleteAll.js') }}"></script>
@endsection