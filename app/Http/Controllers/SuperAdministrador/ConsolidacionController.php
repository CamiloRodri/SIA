<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;

use App\Models\Autoevaluacion\Consolidacion;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Fase;
use App\Models\Autoevaluacion\Proceso;

use App\Http\Requests\ConsolidacionesRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConsolidacionController extends Controller
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
    	$this->middleware('permission:ACCEDER_CONSOLIDACION_FACTORES');
        $this->middleware(['permission:MODIFICAR_CONSOLIDACION_FACTORES', 'permission:VER_CONSOLIDACION_FACTORES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_CONSOLIDACION_FACTORES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_CONSOLIDACION_FACTORES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$fase = Fase::where('FSS_Nombre', 'consolidacion')->value('PK_FSS_Id');
    	$consolidacion = Proceso::where('PK_PCS_Id', '=', session()->get('id_proceso'))
        	->where('FK_PCS_Fase',$fase)
            ->first();
   		$factores = Factor::pluck('FCT_Nombre', 'PK_FCT_Id');

        return view('autoevaluacion.SuperAdministrador.ConsolidacionFactores.index', compact('consolidacion', 'factores'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista en el datatable las Consolidaciones existentes
     * en el sistema
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $consolidaciones=Consolidacion::where('FK_CNS_Proceso', '=', session()->get('id_proceso'))
            	->with('caracteristica.factor')
            ->get();

            return DataTables::of($consolidaciones)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addColumn('nombre_caracteristica', function ($consolidaciones) {
                    return $consolidaciones->caracteristica->nombre_caracteristica;
                })
                ->addColumn('nombre_factor', function ($consolidaciones) {
                    return $consolidaciones->caracteristica->factor->nombre_factor;
                })
                ->addColumn('id_factor', function ($consolidaciones) {
                    return $consolidaciones->caracteristica->factor->PK_FCT_Id;
                })
                ->addColumn('id_caracteristica', function ($consolidaciones) {
                    return $consolidaciones->caracteristica->PK_CRT_Id;
                })
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion retorna el formulario crear
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea las Consolidaciones
     */
    public function store(ConsolidacionesRequest $request)
    {
    	$consolidacion = new Consolidacion();
        $consolidacion->CNS_Debilidad = $request->get('CNS_Debilidad');
        $consolidacion->CNS_Fortaleza = $request->get('CNS_Fortaleza');
        $consolidacion->FK_CNS_Caracteristica = $request->get('PK_CRT_Id');
        $consolidacion->FK_CNS_Proceso = session()->get('id_proceso');
        $consolidacion->save();

        return response([
            'msg' => 'Consolidacion de Factores registrado correctamente.',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     *Esta funcion retorna de formulario editar
     */
    public function edit($id)
    {
        $consolidacion = Consolidacion::findorFail($id);
        $factores = Factor::pluck('FCT_Nombre', 'PK_FCT_Id');

        $caracteristica = new Caracteristica();
        $idCaracteristica = $consolidacion->caracteristica->factor()->pluck('PK_FCT_Id')[0];
        $caracteristicas = $caracteristica->where('FK_CRT_Factor', $idCaracteristica)->get()->pluck('nombre_caracteristica', 'PK_CRT_Id');

        return view(
            'autoevaluacion.SuperAdministrador.ConsolidacionFactores.edit',
            compact('consolidacion',  'factores', 'caracteristicas')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion edita las Consolidaciones
     */
    public function update($id, ConsolidacionesRequest $request)
    {
        $consolidacion = Consolidacion::findOrFail($id);
        $consolidacion->CNS_Debilidad = $request->get('CNS_Debilidad');
        $consolidacion->CNS_Fortaleza = $request->get('CNS_Fortaleza');
        $consolidacion->FK_CNS_Caracteristica = $request->get('PK_CRT_Id');
        $consolidacion->update();

        return response([
            'msg' => 'La Consolidacion de Factores ha sido modificada exitosamente.',
            'title' => 'Consolidacion de Factores Modificada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion elimina las Consolidaciones
     */
    public function destroy($id)
    {
    	$consolidacion = Consolidacion::findOrFail($id);
        $consolidacion->delete();

        return response([
            'msg' => 'La Consolidacion de Factores ha sido eliminada exitosamente.',
            'title' => '¡Consolidacion de Factores Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
