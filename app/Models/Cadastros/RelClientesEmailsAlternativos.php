<?php

namespace App\Models\Cadastros;

use Illuminate\Database\Eloquent\Model;

class RelClientesEmailsAlternativos extends Model
{
    protected $table = 'tb_rel_clientes_emails_alternativos';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_cliente',
        'des_email',
    ];
}
