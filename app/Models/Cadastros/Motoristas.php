<?php

namespace App\Models\Cadastros;

use App\Models\Configuracoes\Funcionalidade;
use Illuminate\Database\Eloquent\Model;

class Motoristas extends Model
{
    protected $table = 'tb_cad_motoristas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Motoristas';
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'des_cpf',
        'des_nome',
        'des_rntrc',
        'des_cnh',
        'des_uf_cnh',
        'flg_ativo',

        // Dados complementares
        'des_apelido',
        'des_rg',
        'des_orgao_expedidor',
        'des_pis',
        'des_inss',
        'dat_nascimento',
        'des_telefone',
        'des_email',

        // Endereços
        'des_cep',
        'des_pais',
        'des_uf',
        'des_municipio',
        'des_logradouro',
        'des_numero',
        'des_complemento',
        'des_bairro',

        // Dados bancários
        'id_banco',
        'des_agencia',
        'des_conta',
        'des_tipo_conta',
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

    /** Verifica se o motorista está ativo **/
    public function isAtivo()
    {
        return $this->getOriginal('flg_ativo') == 'S';
    }

    /** Mutators **/
    public function getFlgAtivoAttribute($flg_ativo)
    {
        return $flg_ativo == 'S' ? 'Sim' : 'Não';
    }

    public function getDesCpfAttribute($des_cpf_cnpj)
    {
        $des_cpf_cnpj = substr($des_cpf_cnpj, 0, 3) . '.' . substr($des_cpf_cnpj, 3, 3) . '.' . substr($des_cpf_cnpj, 6, 3) . '-' . substr($des_cpf_cnpj, 9);
        return $des_cpf_cnpj;
    }

    public function getDesTelefoneAttribute($des_telefone)
    {
        if ($des_telefone)
            return '(' . substr($des_telefone, 0, 2) . ')' . substr($des_telefone, 2, 4) . '-' . substr($des_telefone, 6);
    }

    public function getStatus()
    {
        return $this->getOriginal('flg_ativo') == 'S' ? 'Ativo' : 'Não ativo';
    }

    /** Relations **/
    public function banco() {
        return $this->hasOne(Bancos::class, 'id', 'id_banco');
    }

    /**
     * Função que retorna as colunas da tabela
    */
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
