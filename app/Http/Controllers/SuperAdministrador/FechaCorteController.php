<?php

namespace App\Http\Controllers\SuperAdministrador;
use App\Models\Autoevaluacion\FechaCorte;
use App\Models\Autoevaluacion\Proceso;

use App\Http\Requests\SedesRequest;
use App\Models\Autoevaluacion\Sede;
use App\Models\Autoevaluacion\Estado;

use Illuminate\Http\Request;
use DataTables;
use App\Http\Controllers\Controller;

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
    public function store()
    {

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
    public function update()
    {
        
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

    }
}
