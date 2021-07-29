<?php

namespace App\Providers\CamposPersonalizados;

use App\Models\CamposPersonalizados\ModelosGridExcel;
use App\Models\Configuracoes\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ModelosGridExcelProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ModelosGridExcel $modelo)
    {
        $modelo::created(function($model) {
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a criação do do modelo de grid e excel " . $model->des_modelo .
                " para a funcionalidade de " . $model->funcionalidade->des_funcionalidade .
                " no sistema."
            ]);

            $log->save();
        });

        $modelo::updated(function($model) {
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a edição do do modelo de grid e excel $model->des_modelo de ID $model->id
                 para a funcionalidade de " . $model->funcionalidade->des_funcionalidade .
                " no sistema."
            ]);

            $log->save();
        });

        $modelo::deleting(function($model) {
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a exclusão do do modelo de grid e excel $model->des_modelo de ID $model->id
                 para a funcionalidade de " . $model->funcionalidade->des_funcionalidade .
                " no sistema."
            ]);

            $log->save();
        });
    }
}
