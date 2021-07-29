@extends('Admin.layout.main')

@section('title', trans('titles.consultaCpfCnpj'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('Admin.consultas.cpfCnpj._breadcrumbs')
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('postConsultaCpfCnpj') }}">
                {{ method_field('POST') }}
                {{ csrf_field() }}
    
                <label for="cpf_cnpj" class="{{ Session::get('errorCpfCnpj') ? 'text-danger' : '' }}">@lang('labels.digiteOCpfCnpj')</label>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" 
                            class="form-control {{ Session::get('errorCpfCnpj') ? 'is-invalid' : '' }}"
                            id="cpf_cnpj"
                            name="cpf_cnpj"
                            value="{{ old('cpf_cnpj') }}"
                            placeholder="@lang('labels.digiteOCpfCnpj')">
                        
                        @if (Session::get('errorCpfCnpj'))
                            <div class="invalid-feedback">
                                {{ Session::get('errorCpfCnpj') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">

                        {{-- Se alguma consulta tiver sido realizada, exibe o botão para limpar a consulta --}}
                        @if(isset($dadosRetornoApi->cpf) || isset($dadosRetornoApi->cnpj))
                            <a href="{{ route('consultaCpfCnpj') }}" class="btn btn-danger">
                                <i class="anticon anticon-close m-r-5"></i>
                                @lang('labels.limparConsulta')
                            </a>
                        @else
                            <button type="submit" class="btn btn-primary">
                                <i class="anticon anticon-search m-r-5"></i>
                                @lang('labels.realizarConsulta')
                            </button>
                        @endisset
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="notification-toast top-left" id="notification-toast"></div>
    
    {{-- Dados do CPF --}}
    @isset($dadosRetornoApi->cpf)
        @include('Admin.consultas.cpfCnpj.retornoConsulta.cpf.dadosCpf')
    @endisset

    {{-- Dados do CNPJ --}}
    @isset($dadosRetornoApi->cnpj)
        @include('Admin.consultas.cpfCnpj.retornoConsulta.cnpj.dadosCnpj')
    @endisset

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/defaultMasks.js') }}"></script>
    <script src="{{ asset('assets/js/consultaCpfCnpj.js') }}"></script>
@endsection