<?php

namespace App\Models\Cadastros;

use App\Models\Configuracoes\Funcionalidade;
use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    protected $table = 'tb_cad_bancos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Bancos';

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'des_banco',
        'flg_ativo',
    ];

    /** Pegamos o nome da funcionalidade **/
    public function getNomFuncionalidade()
    {
        return $this->nom_funcionalidade;
    }

    /** Pegamos o ID da funcionalidade na tabela de funcionalidades */
    public function getIdFuncionalidade()
    {
        return Funcionalidade::where('des_funcionalidade', $this->nom_funcionalidade)->firstOrFail()->id;
    }

    /** Verifica se o banco está ativo **/
    public function isAtivo()
    {
        return $this->getOriginal('flg_ativo') == 'S';
    }

    public function getStatus()
    {
        return $this->getOriginal('flg_ativo') == 'S' ? 'Ativo' : 'Não ativo';
    }
}
