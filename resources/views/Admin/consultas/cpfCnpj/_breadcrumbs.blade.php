<div class="page-header mb-0">
    <div class="d-flex justify-content-between">
        <div>    
            <h2 class="header-title">@lang('labels.consultas')</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('home') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>@lang('labels.dashboard')</a>
                    <a class="breadcrumb-item" href="#">@lang('labels.consultas')</a>
                    <span class="breadcrumb-item active">@lang('labels.consultaCpfCnpj')</span>
                </nav>
            </div>
        </div>
    </div>

    <div class="d-md-flex align-items-md-baseline justify-content-between mt-4">
        <div class="alert alert-warning">
            <div class="d-flex justify-content-start">
                <span class="alert-icon m-r-20 font-size-30">
                    <i class="anticon anticon-exclamation-circle"></i>
                </span>
                <div>
                    <h5 class="alert-heading"><b>@lang('messages.atencao')</b></h5>
                    <p>@lang('messages.consultas_pagas')</p>
                </div>
            </div>
        </div>
        <div class="d-md-flex align-items-center">
            <div class="media align-items-center m-r-60 m-v-5">
                <div class="font-size-27">
                    <i class="text-success anticon anticon-user"></i>
                </div>
                <div class="d-flex align-items-center">
                    <h2 class="m-b-0 m-h-15" id="num_consultas_cpf"></h2>
                    <span class="text-gray">Consultas<br>CPF</span>
                </div>
            </div>
            <div class="media align-items-center m-v-5">
                <div class="font-size-27">
                    <i class="text-danger anticon anticon-team"></i>
                </div>
                <div class="d-flex align-items-center">
                    <h2 class="m-b-0 m-h-15" id="num_consultas_cnpj"></h2>
                    <span class="text-gray">Consultas<br>CNPJ</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Inputs hidden para consulta do saldo via JS --}}
    <input type="hidden" id="endpoint" value="{{ config('cpfCnpj.endPointSaldoAPI') }}">
    <input type="hidden" id="token" value="{{ config('cpfCnpj.token') }}">
    <input type="hidden" id="pacote_cpf" value="{{ config('cpfCnpj.pacoteCPF') }}">
    <input type="hidden" id="pacote_cnpj" value="{{ config('cpfCnpj.pacoteCNPJ') }}">
</div>