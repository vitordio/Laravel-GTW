<?php

namespace App\Mail;

use Exception;
use SendGrid;

class ForgotPasswordMail
{
    public $email, $token;
    public $isAdmin;
    protected $templateId = 'd-ec5edef6feea46ef9a4191861152bef4';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token, $isAdmin)
    {
        $this->email = $email;
        $this->token = $token;
        $this->isAdmin = $isAdmin;
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
        $email->setSubject(trans('messages.mailResetPassword'));
        $email->setTemplateId($this->templateId);

        /** Passamos as variáveis definidas no template */
        $email->addTo(
            $this->email,
            config('mail.from.name'),
            [
                "urlRedefinirSenha" => $this->isAdmin ? route('forgotPasswordToken', ['token' => $this->token]) : route('clienteForgotPasswordToken', ['token' => $this->token]),
            ]
        );

        $sendGrid = new SendGrid(config('mail.password'));
        try {
            
            $response = $sendGrid->send($email);

            return [$response->statusCode(), $response->headers(), $response->body()];

        } catch (Exception $e) {
            return back()->with('Não foi possível realizar o envio para redefinição da senha, tente novamente.');
        }
    }
}
