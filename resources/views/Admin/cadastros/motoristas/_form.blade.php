@php
    use App\Components\Biblioteca;
@endphp

    @if($model->exists)
        <form method="POST" action="{{ $options['route'] }}">
            {{ method_field('PUT') }}
    @else
        <form method="POST" action="{{ $options['route'] }}">
            {{ method_field('POST') }}
    @endif

    {{ csrf_field() }}

    {{-- Exibe a informação que ocorreram erros na validação (nos campos as mensagens do erro também são exibidas) --}}
    @if ($errors && !$errors->isEmpty())
        <div class="alert alert-danger">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-close-o"></i>
                </span>
                <span>@lang('messages.errorValidation')</span>
            </div>
        </div>
    @endif

    {{-- Views com as partes do formulário --}}
    @include('Admin.cadastros.clientes.formItens._dadosCliente')
    @include('Admin.cadastros.clientes.formItens._enderecoCliente')
    @include('Admin.cadastros.clientes.formItens._dadosLoginCliente')

    <div class="form-group">
        <div class="checkbox">
            <input type="hidden" name="flg_ativo" value="{{ Biblioteca::FLG_DESATIVO }}" />
            <input
            type="checkbox"
            name="flg_ativo"
            value="{{ old('flg_ativo', Biblioteca::FLG_ATIVO) }}"
            {{ old('flg_ativo', $model->getOriginal('flg_ativo')) == Biblioteca::FLG_ATIVO || !$model->exists ? 'checked' : '' }}
            id="flg_ativo">
            
            <label for="flg_ativo">@lang('labels.flg_ativo') </label>
        </div>
    </div>

    {{-- Input oculto com o ID do cliente --}}
    @if($model->exists)
        <input type="hidden" name="id" value="{{ $model->id }}">
    @endif

    {{-- Rota do ajax para busca dos dados de acordo com o CPF/CNPJ digitados --}}
    <input type="hidden" id="routeCPFCNPJ" value={{ route('clientes.ajaxCpfCnpj', ':cpfCnpj') }}>

    @if($options['method'] != Biblioteca::METHOD_SHOW)
        <button type="submit" class="btn btn-primary">@lang('labels.salvar')</button>
    @endif
</form>

@if(in_array(Route::currentRouteName(), ['clientes.create', 'clientes.edit']))
    {{-- View com o modal para exibição do formulário para inclusão do tipo de atividade sem alteração na página --}}
    @include('Admin.cadastros.clientes._modalTipoAtividade')
@endif

@section('scripts')
    <script src="{{ asset('assets/js/clientes.js') }}"></script>
@endsection