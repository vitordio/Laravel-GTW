<div class="m-t-25">
    <table id="ajax-data-table" class="table">
        <thead>
            <tr>
                <th>@lang('labels.id')</th>
                <th>@lang('labels.des_menu')</th>
                <th>@lang('labels.des_icon')</th>
                <th>@lang('labels.flg_ativo')</th>
                @canany(['VisualizarMenu', 'EditarMenu', 'ExcluirMenu'])
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
            const arrColunas = [
                { data: 'id', name: 'id' },
                { data: 'des_menu', name: 'des_menu' },
                { data: 'des_icon', name: 'des_icon' },
                { data: 'flg_ativo', name: 'flg_ativo' }
            ];

            // Verificamos se a coluna ações foi criada (tem alguma permissão além de visualizar a grid)
            const thActions = document.querySelector('table > thead > tr > th:last-child').innerText
            if(thActions === 'Ações')
                arrColunas.push({ data: 'action', name: 'action', orderable: false, searchable: false });

            $('#ajax-data-table').DataTable(
            {
                serverSide: true,
                ajax: "{{ route('menu.ajaxDataTable') }}",
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
        } );
    </script>

@endsection