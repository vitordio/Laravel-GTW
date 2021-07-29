<?php

namespace App\Http\Controllers\Admin\Configuracoes;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracoes\MenuRequest;
use App\Models\Configuracoes\Menu;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    /**
     * Instância dos registros de menus
    */
    protected $menus;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Menu $menus)
    {
        $this->middleware('auth');
        $this->menus = $menus;

        /** Verifica as permissões **/
        $this->middleware('can:AcessarMenus');
        $this->middleware('can:CriarMenu', ['only' => ['create', 'store']]);
        $this->middleware('can:VisualizarMenu', ['only' => ['show']]);
        $this->middleware('can:EditarMenu', ['only' => ['edit', 'update']]);
        $this->middleware('can:ExcluirMenu', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->menus->all();

        $options = [
            'viewName' => '_grid',
        ];

        return view('Admin.configuracoes.menu.index', compact('model', 'options'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable()
    {
        $menus = $this->menus->select();
        $dataTable = DataTables::of($menus)
        ->editColumn('des_icon', function ($menu) {
            return '<span class="icon-holder">
                    <i class="anticon anticon-'. $menu->des_icon . '"></i>
                </span>' . $menu->des_icon;
        });

        // Colunas de ação
        if(Gate::allows('VisualizarMenu') || Gate::allows('EditarMenu') || Gate::allows('ExcluirMenu'))
        {
            $dataTable
            ->addColumn('action', function ($menu) {
                $actionColumns = '';

                if(Gate::allows('VisualizarMenu'))
                    $actionColumns = '<a href="'. route('menu.show', ['menu' => Crypt::encryptString($menu->id)]) .'" class="m-r-5 button-view" title='. trans('labels.show') . ' data-toggle="tooltip" data-placement="top">
                                    <i class="anticon anticon-eye"></i>
                                    <span class="m-l-3">' . trans('labels.show') . '</span>
                                </a>';

                if(Gate::allows('EditarMenu'))
                    $actionColumns .= '<a href="'. route('menu.edit', ['menu' => Crypt::encryptString($menu->id)]) .'" class="m-r-5 button-edit" title='. trans('labels.edit') . ' data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">' . trans('labels.edit') . '</span>
                            </a>';

                if(Gate::allows('ExcluirMenu'))
                    $actionColumns .= '<a class="delete-button button-delete" data-name="'. $menu->des_nome . '" data-id="' . $menu->id . '" data-method="DELETE" data-item="' . trans('labels.menu') . '"
                                title="' . trans('labels.delete') . '" data-toggle="tooltip" data-placement="top" onclick="deleteRegister(this)"
                                href="#"
                                data-href="' . route('menu.destroy', ['menu' => Crypt::encryptString($menu->id)]) . '"> 
                                    <i class="anticon anticon-delete"></i>
                                    <span class="m-l-3">' . trans('labels.delete') . '</span>
                        </a>';

                return $actionColumns;
            });
        }

        return $dataTable->rawColumns(['des_icon', 'action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Menu();
        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_POST,
            'route'  => route('menu.store')
        ];

        return view('Admin.configuracoes.menu.index', compact('model', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\MenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        try
        {
            $model = new Menu();
            $model->fill($request->all())->save();

            return redirect(route('menu.index'))->with('success', trans('messages.saved'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a criação do menu, tente novamente.');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idMenu = Biblioteca::desencriptar($id);
        $model = $this->menus->findOrFail($idMenu);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_SHOW,
            'route'  => route('menu.store'),
        ];

        return view('Admin.configuracoes.menu.index', compact('model', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idMenu = Biblioteca::desencriptar($id);
        $model = $this->menus->findOrFail($idMenu);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('menu.update', $model->id),
        ];


        return view('Admin.configuracoes.menu.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MenuRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {
        try
        {
            $model = $this->menus->findOrFail($id);
            $model->fill($request->all())->update();

            return redirect(route('menu.index'))->with('success', trans('messages.edited'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a atualização do menu, tente novamente.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $idMenu = Biblioteca::desencriptar($id);
            $model = $this->menus->findOrFail($idMenu);

            $model->delete();

            return response(['message' => trans('messages.deleted'), 'response' => 'ok']);

        } catch (Exception $ex) {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }
}
