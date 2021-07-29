<?php

namespace App\Models\CamposPersonalizados;

use App\Components\Biblioteca;
use App\Models\Configuracoes\Funcionalidade;
use Illuminate\Database\Eloquent\Model;

class ModelosGridExcel extends Model
{
    protected $table = 'tb_cad_modelos_grid_excel';
    protected $primaryKey = 'id';
    public $timestamps = false;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_funcionalidade',
        'des_modelo',
        'colunas',
    ];

    /**
     * Fazemos o cast nas colunas, pois são salvas
     * no banco em formato json
     */
    protected $casts = [
        'colunas' => 'array'
    ];

    public function setColunasAttribute($value)
	{
	    $colunasSelecionadas = [];

        /**
         * Sempre atribuimos a coluna ID no modelo, pois usamos ela
         * para os botões de visualizar, editar e excluir o registro,
         * mas não exibimos na grid
         */
        array_push($colunasSelecionadas, 'id');
        
	    foreach ($value as $key => $array_item) {
	        if ($array_item == 'S') {
	            $colunasSelecionadas[] = $key;
	        }
	    }

	    $this->attributes['colunas'] = json_encode($colunasSelecionadas);
	}

    /**
     * Retorna o ID do modelo padrão de determinada funcionalidade
     * 
     * @param $idFuncionalidade
     * @return app\Models\CamposPersonalizados\ModelosGridExcel
    */
    public function getModeloPadrao(int $idFuncionalidade)
    {
        return $this->where('id_funcionalidade', $idFuncionalidade)
        ->where('des_modelo', Biblioteca::MODELO_PADRAO)
        ->firstOrFail();
    }

    /** Relations **/
    public function funcionalidade()
    {
        return $this->hasOne(Funcionalidade::class, 'id', 'id_funcionalidade');
    }
}
