<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Error Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the Laravel Responder package.
    | When it generates error responses, it will search the messages array
    | below for any key matching the given error code for the response.
    |
    */

    'unauthenticated' => 'You are not authenticated for this request.',
    'unauthorized' => 'You are not authorized for this request.',
    'page_not_found' => 'The requested page does not exist.',
    'relation_not_found' => 'The requested relation does not exist.',
    'validation_failed' => 'The given data failed to pass validation.',

    // Mensagens de autenticação
    'nao_logado' => 'Não autenticado. Faça o login para continuar.',
    'dados_invalidos' => 'Dados inválidos',
    'usuario_ou_senha_invalidos' => 'Usuário ou senha inválidos.',
    'campos_obrigatorios' => 'Ocorram erros de validação',

    // Token
    'invalid_token' => 'O token enviado é inválido.',
    'expired_token' => 'O token enviado está expirado.',
    'not_found_token' => 'Token de autenticação não encontrado.'
];