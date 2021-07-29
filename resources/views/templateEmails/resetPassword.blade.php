@extends('templateEmails.mainlayout')
@section('content')
    <div class="container">
        <div class="card-header">Conforme solicitado, segue o link para redefinição da senha:</div>
        <div class="card-body">
            <a href="{{ isset($cliente) && $cliente ? route('clienteForgotPasswordToken', ['token' => $token]) : route('forgotPasswordToken', ['token' => $token]) }}">Clique aqui para acessar o link da redefinição da senha</a>.
            <p>Se não foi você quem solicitou, desconsidere o e-mail</p>
        </div>
    </div>
@endsection