@extends('templateEmails.mainlayout')
@section('content')
    <div class="container">
        <div class="card-header">Olá, {{ $cliente->des_nome }}!</div>
        <div class="card-body">
            Seja bem vindo à {{ config('app.name') }}. Seus dados de acesso a área do cliente são:
            <br><br>

            <b>URL de Acesso: </b> {{ route('clienteLogin') }}<br>
            <b>Login: </b> {{ $cliente->des_login }}<br>
            <b>Senha: </b> {{ $password }}
            
            <br><br>

            Atenciosamente,<br>
            {{ config('app.name') }}.

        </div>
    </div>
@endsection