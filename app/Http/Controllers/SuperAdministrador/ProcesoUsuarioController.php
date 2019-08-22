<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\User;
use DataTables;
use Illuminate\Http\Request;

class ProcesoUsuarioController extends Controller
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
        $this->middleware('permission:ACCEDER_PROCESOS_INSTITUCIONALES');
        $this->middleware(['permission:MODIFICAR_PROCESOS_INSTITUCIONALES', 'permission:VER_PROCESOS_INSTITUCIONALES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PROCESOS_INSTITUCIONALES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PROCESOS_INSTITUCIONALES', ['only' => ['destroy']]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista los usuarios para los procesos
     */
    public function data(Request $request, $id)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $usuarios = User::with('procesos')->get();

            return DataTables::of($usuarios)
                ->addColumn('seleccion', function ($usuario) use ($id) {
                    $checked = '';
                    foreach ($usuario->procesos as $proceso) {
                        if ($proceso->PK_PCS_Id == $id) {
                            $checked = 'checked';
                            break;
                        }
                    }
                    return '<input type="checkbox" class="ids_usuarios" name="seleccion" value="' . $usuario->id . '" ' . $checked . ' />';
                })
                ->rawColumns(['seleccion'])
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proceso = Proceso::findOrFail($id)->nombre_proceso;
        $proceso = str_limit($proceso, 40, '...');

        return view('autoevaluacion.SuperAdministrador.ProcesosUsuarios.index', compact('proceso'));
    }

    /**
     * asignar usuarios a procesos
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion asigna un usuario a un proceso
     */
    public function asignarUsuarios(Request $request, $id)
    {
        $proceso = Proceso::findOrFail($id);
        $proceso->users()->sync($request->get('usuarios'));

        return response([
            'msg' => 'Proceso asignado correctamente.',
            'title' => '¡Asignacion exitosa!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');

    }

    /**
     * desasignar usuarios de procesos
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function desasignarUsuarios(Request $request)
    {

        return response([
            'errors' => ['La fecha de inicio tiene que ser menor que la fecha de terminación del proceso.'],
            'title' => '¡Error!',
        ], 422) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
