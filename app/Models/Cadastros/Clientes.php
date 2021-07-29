<?php

namespace App\Models\Cadastros;

use App\Models\CamposPersonalizados\TipoAtividade;
use App\Models\Configuracoes\Funcionalidade;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
  public $tipo_cliente; // Campo para seleção se é CPF ou CNPJ
  public $flg_isento, $flg_habilitar; // checkbox para alterações nos campos

  const CPF = 'CPF';
  const CNPJ = 'CNPJ';
  const ISENTO = 'ISENTO';

  protected $table = 'tb_cad_clientes';
  protected $primaryKey = 'id';
  public $timestamps = false;
  public $nom_funcionalidade = 'Clientes';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'des_cpf_cnpj',
    'des_inscricao_estadual',
    'des_nome',
    'des_nome_fantasia',
    'des_divisao',
    'des_telefone',
    'des_email',
    'des_login',
    'password',
    'id_tipo_atividade',
    'des_cep',
    'des_pais',
    'des_uf',
    'des_municipio',
    'des_logradouro',
    'des_numero',
    'des_complemento',
    'des_bairro',
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

  /** Verifica se o cliente está ativo **/
  public function isAtivo()
  {
    return $this->getOriginal('flg_ativo') == 'S';
  }

  /** Verificamos se o usuário é PJ */
  public function isPj()
  {
    return strlen($this->getOriginal('des_cpf_cnpj')) >= 14;
  }

  /** Mutators **/
  public function getFlgAtivoAttribute($flg_ativo)
  {
    return $flg_ativo == 'S' ? 'Sim' : 'Não';
  }

  public function getDesCpfCnpjAttribute($des_cpf_cnpj)
  {
    if (strlen($des_cpf_cnpj) === 11) {
      $des_cpf_cnpj = substr($des_cpf_cnpj, 0, 3) . '.' . substr($des_cpf_cnpj, 3, 3) . '.' . substr($des_cpf_cnpj, 6, 3) . '-' . substr($des_cpf_cnpj, 9);
    } else {
      $des_cpf_cnpj = substr($des_cpf_cnpj, 0, 2) . '.' . substr($des_cpf_cnpj, 2, 3) . '.' . substr($des_cpf_cnpj, 5, 3) . '/' . substr($des_cpf_cnpj, 8, 4) . '-' . substr($des_cpf_cnpj, 12, 2);
    }

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
  public function tipoAtividade()
  {
    return $this->hasOne(TipoAtividade::class, 'id', 'id_tipo_atividade');
  }

  public function emailsAlternativos()
  {
    return $this->hasMany(RelClientesEmailsAlternativos::class, 'id_cliente', 'id');
  }

  /**
   * Função que retorna as colunas da tabela
   */
  public function getTableColumns()
  {
    return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
  }
}
