<?php

namespace App\Models\Cadastros;

use Illuminate\Database\Eloquent\Model;

class Veiculos extends Model
{
    protected $table = 'tb_cad_veiculos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Veículos';

    /** Verifica se o cliente está ativo **/
    public function isAtivo()
    {
        return $this->getOriginal('flg_ativo') == 'S';
    }

    public function getNomFuncionalidade()
    {
        return $this->nom_funcionalidade;
    }
}
