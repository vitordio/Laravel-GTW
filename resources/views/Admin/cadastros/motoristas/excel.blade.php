@php
    use App\Components\Biblioteca;
@endphp

<table>
    <thead>
        <tr>
            <th colspan="7" style="height: 30%; vertical-align:center; background-color: #0c141d; text-align: center; color: #ffffff">
                <h1>@lang('labels.motoristas')</h1>
            </th>
        </tr>
        <tr>
            @foreach ($colunas as $coluna)
                @if($coluna !== Biblioteca::ID)
                    <th>@lang('labels.' . $coluna)</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($motoristas as $motorista)
            <tr>
                @foreach ($motorista->getAttributes() as $coluna => $valorColuna)
                    @if($coluna !== Biblioteca::ID)
                        <td>{{ $valorColuna }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>