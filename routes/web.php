<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

/** Rotas bloqueadas - Acessível apenas para os IPs configurados no whitelist */
Route::group(['middleware' => 'whitelist:ips_habilitados'], function() {
    /** Rotas do Administrador **/
    Route::middleware(['web'])->prefix('admin')->namespace('Admin')->group(function ()
    {
        /** Rotas de autenticação **/
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login')->name('loginSubmit');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        /** Rotas para resetar a senha */
        Route::get('/esqueci-minha-senha', 'Auth\ForgotPasswordController@getEmail')->name('formForgotPassword');
        Route::post('/esqueci-minha-senha', 'Auth\ForgotPasswordController@resetPassword')->name('forgotPassword');
        Route::get('/redefinir-senha/{token}', 'Auth\ResetPasswordController@getPassword')->name('forgotPasswordToken');
        Route::post('/redefinir-senha', 'Auth\ResetPasswordController@updatePassword')->name('resetPassword');

        Route::get('/', function ()
        {
            return view('Admin.dashboard');
        })->name('home')->middleware('auth');

        /** Configurações **/
        Route::group(['namespace' => 'Configuracoes'], function()
        {
            /** Usuários **/
            Route::get('usuario/ajaxDataTable', 'UsuarioController@ajaxDataTable')->name('usuario.ajaxDataTable');
            Route::resource('usuario', UsuarioController::class);
            Route::get('alterarMeusDados/{usuario}/edit', 'UsuarioController@alterarMeusDados')->name('usuario.alterarMeusDados');
            Route::put('alterarMeusDados/{usuario}', 'UsuarioController@updateDados')->name('usuario.updateDados');
            
            /** Logs de Acesso **/
            Route::get('log/ajaxDataTable', 'LogController@ajaxDataTable')->name('log.ajaxDataTable');
            Route::resource('log', LogController::class);

            /** Cadastro dos menus do sistema **/
            Route::get('menu/ajaxDataTable', 'MenuController@ajaxDataTable')->name('menu.ajaxDataTable');
            Route::resource('menu', MenuController::class);

            /** Cadastro de funcionalidades **/
            Route::get('funcionalidade/ajaxDataTable', 'FuncionalidadeController@ajaxDataTable')->name('funcionalidade.ajaxDataTable');
            Route::resource('funcionalidade', FuncionalidadeController::class);

            /** Perfis de acesso **/
            Route::get('perfilAcesso/ajaxDataTable', 'PerfilAcessoController@ajaxDataTable')->name('perfilAcesso.ajaxDataTable');
            Route::resource('perfilAcesso', PerfilAcessoController::class);
        });

        /** Cadastros **/
        Route::group(['namespace' => 'Cadastros'], function()
        {
            /** Clientes **/
            Route::post('clientes/deleteAllSelected', 'ClientesController@deleteAllSelected')->name('clientes.deleteAllSelected');
            Route::get('clientes/ajaxCpfCnpj/{cpfCnpj}', 'ClientesController@ajaxCpfCnpj')->name('clientes.ajaxCpfCnpj');
            Route::get('clientes/exportarExcel/{idModelo}', 'ClientesController@exportarExcel')->name('clientes.exportarExcel');
            Route::get('clientes/gridModelo/{idModelo}', 'ClientesController@exibeGridModelo')->name('clientes.exibeGridModelo');
            Route::get('clientes/ajaxDataTable/{idModelo}', 'ClientesController@ajaxDataTable')->name('clientes.ajaxDataTable');
            Route::resource('clientes', ClientesController::class);

            /** Motoristas **/
            Route::post('motoristas/deleteAllSelected', 'MotoristasController@deleteAllSelected')->name('motoristas.deleteAllSelected');
            Route::get('motoristas/ajaxCpfCnpj/{cpfCnpj}', 'MotoristasController@ajaxCpfCnpj')->name('motoristas.ajaxCpfCnpj');
            Route::get('motoristas/exportarExcel/{idModelo}', 'MotoristasController@exportarExcel')->name('motoristas.exportarExcel');
            Route::get('motoristas/gridModelo/{idModelo}', 'MotoristasController@exibeGridModelo')->name('motoristas.exibeGridModelo');
            Route::get('motoristas/ajaxDataTable/{idModelo}', 'MotoristasController@ajaxDataTable')->name('motoristas.ajaxDataTable');
            Route::resource('motoristas', MotoristasController::class);

            /** Veículos **/
            Route::resource('veiculos', VeiculosController::class);
        });

        /** Campos Personalizados **/
        Route::group(['namespace' => 'CamposPersonalizados'], function()
        {
            /** Tipos de Atividade **/
            Route::get('tipoAtividade/ajaxDataTable', 'TipoAtividadeController@ajaxDataTable')->name('tipoAtividade.ajaxDataTable');
            Route::resource('tipoAtividade', TipoAtividadeController::class);

            /** Modelos personalizados para visualização da grid e geração do excel */
            Route::get('modeloGridExcel/getModelo/{modelo}', 'ModelosGridExcelController@getModelo')->name('modelosGridExcel.getModelo');
            Route::resource('modelosGridExcel', ModelosGridExcelController::class, ['only' => ['store', 'update', 'destroy']]); // usamos somente essas 3 rotas do resource
        });

        /** Consultas dos dados CPF e CNPJ */
        Route::group(['namespace' => 'Consultas'], function() {
            Route::get('consultaCpfCnpj', 'CpfCnpjController')->name('consultaCpfCnpj');
            Route::post('consultaCpfCnpj', 'CpfCnpjController')->name('postConsultaCpfCnpj');
        });
    });
});

/** Rotas do login para o cliente */
Route::middleware(['cliente'])->namespace('Cliente')->group(function() {
    /** Rotas de autenticação **/
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('clienteLogin');
    Route::post('login', 'Auth\LoginController@login')->name('clienteLoginSubmit');
    Route::post('logout', 'Auth\LoginController@logout')->name('clienteLogout');

    /** Rotas para resetar a senha */
    Route::get('/esqueci-minha-senha', 'Auth\ForgotPasswordController@getEmail')->name('clienteFormForgotPassword');
    Route::post('/esqueci-minha-senha', 'Auth\ForgotPasswordController@resetPassword')->name('clienteForgotPassword');
    Route::get('/redefinir-senha/{token}', 'Auth\ResetPasswordController@getPassword')->name('clienteForgotPasswordToken');
    Route::post('/redefinir-senha', 'Auth\ResetPasswordController@updatePassword')->name('clienteResetPassword');

    Route::get('/', function ()
    {
        return view('Cliente.dashboard');
    })->name('homeCliente')->middleware('auth:cliente');
});