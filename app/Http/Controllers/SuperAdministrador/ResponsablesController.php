<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Responsable;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Autoevaluacion\CargoAdministrativo;
use App\Models\Autoevaluacion\ProcesoUsuario;
use App\Http\Requests\ResponsableRequest;

class ResponsablesController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_RESPONSABLES');
        $this->middleware(['permission:MODIFICAR_RESPONSABLES', 'permission:VER_RESPONSABLES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_RESPONSABLES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_RESPONSABLES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = CargoAdministrativo::get()->pluck('CAA_Cargo', 'PK_CAA_Id');
        $usuarios = ProcesoUsuario::with(['usuarios' => function($query){
            $query->selectRaw('*, CONCAT(name," ",lastname) as nombre');
        }])
        ->where('FK_PCU_Proceso','=',session()->get('id_proceso')??null)
        ->get()
        ->pluck('usuarios.nombre', 'usuarios.id');
        return view('autoevaluacion.SuperAdministrador.Responsables.index', compact('usuarios','cargos'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista en el datatable todos los responsables por proceso
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $responsables = Responsable::with('usuarios','cargo')
            ->where('FK_RPS_Proceso','=',session()->get('id_proceso')??null)
            ->get();
            return Datatables::of($responsables)
                ->addColumn('responsable', function($responsables){
                    return $responsables->usuarios->name." ".$responsables->usuarios->lastname;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResponsableRequest $request)
    {
        $responsable = new Responsable();
        $responsable->FK_RPS_Responsable = $request->get('id');
        $responsable->FK_RPS_Cargo = $request->get('PK_CAA_Id');
        $responsable->FK_RPS_Proceso = session()->get('id_proceso');
        $responsable->save();

        return response([
            'msg' => 'Responsable registrado correctamente.',
            'title' => '¡Registro exitoso!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResponsableRequest $request, $id)
    {
        $responsable = Responsable::findOrFail($id);
        $responsable->FK_RPS_Responsable = $request->get('id');
        $responsable->FK_RPS_Cargo = $request->get('PK_CAA_Id');
        $responsable->update();
        return response([
            'msg' => 'El responsable se ha sido modificado exitosamente.',
            'title' => 'Responsable Modificado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $responsable = Responsable::findOrFail($id);
        $responsable->delete();
        return response([
            'msg' => 'El responsable ha sido eliminado exitosamente.',
            'title' => '¡Responsable Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}