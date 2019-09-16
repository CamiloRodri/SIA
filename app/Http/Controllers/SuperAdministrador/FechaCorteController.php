<?php

namespace App\Http\Controllers\SuperAdministrador;
use App\Models\Autoevaluacion\FechaCorte;
use App\Models\Autoevaluacion\Proceso;

use App\Http\Requests\FechasCorteRequest;
use App\Models\Autoevaluacion\Sede;
use App\Models\Autoevaluacion\Estado;

use Illuminate\Http\Request;
use DataTables;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class FechaCorteController extends Controller
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
    	$this->middleware('permission:ACCESO_FECHA_CORTE');
    	$this->middleware(['permission:MODIFICAR_FECHA_CORTE', 'permission:VER_FECHA_CORTE'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_FECHA_CORTE', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_FECHA_CORTE', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
    	$procesos = Proceso::pluck('PCS_Nombre', 'PK_PCS_Id');
        return view('autoevaluacion.SuperAdministrador.FechasdeCorte.index', compact('estados','procesos'));
        //return view('autoevaluacion.SuperAdministrador.FechasdeCorte.index', compact('procesos'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista en el datatable las Fechas de Corte existentes
     * en el sistema
     */
    public function data(Request $request)
    {
    	if ($request->ajax() && $request->isMethod('GET')) {
            $fechacorte=FechaCorte::with(['proceso' => function ($query) {
                    return $query->select('PK_PCS_Id', 'PCS_Nombre');
                }])->get();
            return DataTables::of($fechacorte)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion retorna de formulario crear
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
     * Esta funcion crea las fechas de corte
     */
    public function store(FechasCorteRequest $request)
    {
        //$fecha = Carbon::createFromFormat('d/m/Y', $request->get('FCO_Fecha'));
     	$fechacorte = new FechaCorte();
        // $fechacorte->FCO_Fecha = $fecha;
        $fechacorte->FCO_Fecha = $request->get('FCO_Fecha');
        $fechacorte->FK_FCO_Proceso = $request->get('PK_PCS_Id');
        $fechacorte->save();

        return response([
            'msg' => 'Fecha de Corte registrada correctamente.',
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion edita las fechas de corte
     */
    public function update($id, FechasCorteRequest $request)
    {
        //$fecha = Carbon::createFromFormat('d/m/Y', $request->get('FCO_Fecha'));
        $fechacorte = FechaCorte::findOrFail($id);
        //$fechacorte->FCO_Fecha = $fecha;
        $fechacorte->FCO_Fecha =  $request->get('FCO_Fecha');
        $fechacorte->FK_FCO_Proceso = $request->get('PK_PCS_Id');
        $fechacorte->update();

        return response([
            'msg' => 'La fecha de corte ha sido modificada exitosamente.',
            'title' => 'Fecha de Corte Modificada!',
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
     * Esta funcion elimina las fechas de corte
     */
    public function destroy($id)
    {
        $sede = FechaCorte::findOrFail($id);
        $sede->delete();

        return response([
            'msg' => 'La fecha de corte ha sido eliminada exitosamente.',
            'title' => '¡Fecha de corte Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
