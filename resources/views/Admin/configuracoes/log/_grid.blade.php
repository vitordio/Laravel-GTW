<div class="m-t-25">
    <table id="ajax-data-table" class="table">
        <thead>
            <tr>
                <th width="2%">@lang('labels.id')</th>
                <th>@lang('labels.des_nome_usuario')</th>
                <th>@lang('labels.des_acao')</th>
                <th>@lang('labels.des_url')</th>
                <th>@lang('labels.num_ip')</th>
                <th>@lang('labels.dat_acao')</th>
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
            $('#ajax-data-table').DataTable(
            {
                serverSide: true,
                ajax: "{{ route('log.ajaxDataTable') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'usuario.des_nome', name: 'usuario.des_nome' },
                    { data: 'des_acao', name: 'des_acao' },
                    { data: 'des_url', name: 'des_url' },
                    { data: 'num_ip', name: 'num_ip' },
                    { data: 'created_at', name: 'created_at' },
                ],
                searching: true,
                deferRender: true,
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