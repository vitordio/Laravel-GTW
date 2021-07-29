<?php

namespace App\Mail\Admin;

use App\Models\Cadastros\Clientes;
use Exception;
use SendGrid;

class CadastroClienteMail
{
    public $cliente, $password;
    protected $templateId = 'd-a9c3e31ecd93402ebc3cb68e2db2178e';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Clientes $cliente, $password)
    {
        $this->cliente = $cliente;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = new SendGrid\Mail\Mail();
        $email->setFrom(config('mail.from.address'), config('mail.from.name'));
        $email->setSubject(trans('messages.mailCadastroCliente'));
        $email->setTemplateId($this->templateId);

        /** Passamos as variáveis definidas no template */
        $email->addTo(
            $this->cliente->des_email,
            config('mail.from.name'),
            [
                "urlAcesso" => route('clienteLogin'),
                "login" => $this->cliente->des_login,
                "password" => $this->password
            ]
        );

        $sendGrid = new SendGrid(config('mail.password'));

        try {

            $response = $sendGrid->send($email);
            return [$response->statusCode(), $response->headers(), $response->body()];

        } catch (Exception $e) {
            return back()->with('Não foi possível realizar a criação do cliente, tente novamente.');
        }
    }
}
