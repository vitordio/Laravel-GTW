<?php

namespace App\Models\Configuracoes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    protected $table ='tb_bas_log';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Log de Acessos';

    protected $fillable = [
        'des_acao',
        'des_url',
        'num_ip',
        'dat_acesso'
    ];

    public function getNomFuncionalidade()
    {
        return $this->nom_funcionalidade;
    }

    public function getIdFuncionalidade()
    {
        return Funcionalidade::where('des_funcionalidade', $this->nom_funcionalidade)->firstOrFail()->id;
    }

    /** Relations **/
    public function usuario()
    {
        /** Como usamos o SoftDelete no CadUsuario, pegamos com o WithTrashed os usuários deletados */
        return $this->hasOne(CadUsuario::class, 'id', 'id_usuario')->withTrashed();
    }
}
