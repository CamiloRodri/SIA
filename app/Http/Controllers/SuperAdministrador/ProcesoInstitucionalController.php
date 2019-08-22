<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcesosInstitucionalesRequest;
use App\Models\Autoevaluacion\Fase;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Proceso;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class ProcesoInstitucionalController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.ProcesosInstitucionales.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion llena el datatable de todos los procesos institucionales
     * el cual requiere de lineamiendos, fecha inicio, fecha fin y fase
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {

            $procesosProgramas = Proceso::with(['fase' => function ($query) {
                return $query->select('PK_FSS_Id', 'FSS_Nombre');
            }])
                ->with(['lineamiento' => function ($query) {
                    return $query->select('PK_LNM_Id', 'LNM_Nombre');
                }])
                ->where('PCS_Institucional', '=', '1')
                ->get();

            return DataTables::of($procesosProgramas)
                ->editColumn('PCS_FechaInicio', function ($procesoPrograma) {
                    return $procesoPrograma->PCS_FechaInicio ? with(new Carbon($procesoPrograma->PCS_FechaInicio))->format('d/m/Y') : '';
                })
                ->editColumn('PCS_FechaFin', function ($procesoPrograma) {
                    return $procesoPrograma->PCS_FechaFin ? with(new Carbon($procesoPrograma->PCS_FechaFin))->format('d/m/Y') : '';;
                })
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
     * Cuando se crea un proceso se necesitan los lineamientos
     * y fases.
     */
    public function create()
    {
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');

        return view(
            'autoevaluacion.SuperAdministrador.ProcesosInstitucionales.create',
            compact('lineamientos', 'fases')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea los procesos institucionales
     */
    public function store(ProcesosInstitucionalesRequest $request)
    {
        $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaInicio'));
        $fechaFin = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaFin'));

        $proceso = new Proceso();
        $proceso->fill($request->only(['PCS_Nombre']));
        $proceso->PCS_FechaInicio = $fechaInicio;
        $proceso->PCS_FechaFin = $fechaFin;
        $proceso->PCS_Institucional = true;

        $proceso->FK_PCS_Fase = 3;
        $proceso->FK_PCS_Lineamiento = $request->get('PK_LNM_Id');
        $proceso->PCS_Slug_Procesos = "institucional_" . Carbon::now()->toDateString();
        $proceso->save();

        return response([
            'msg' => 'Proceso registrado correctamente.',
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
     * Cuando se modifica un proceso se necesitan los lineamientos
     * y fases.
     */
    public function edit($id)
    {
        $proceso = Proceso::findOrFail($id);
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');
        return view(
            'autoevaluacion.SuperAdministrador.ProcesosInstitucionales.edit',
            compact('proceso', 'programas', 'lineamientos', 'fases')
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
     * Esta funcion modifica los procesos institucionales
     */
    public function update(ProcesosInstitucionalesRequest $request, $id)
    {
        $proceso = Proceso::find($id);
        $proceso->fill($request->only(['PCS_Nombre']));
        $proceso->PCS_FechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaInicio'));
        $proceso->PCS_FechaFin = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaFin'));

        $proceso->FK_PCS_Fase = $request->get('PK_FSS_Id');
        $fase = Fase::where('PK_FSS_Id', '=', $request->get('PK_FSS_Id'))
            ->first();
        if ($fase->FSS_Nombre == "plan de mejoramiento") {
            $verificarPlan = PlanMejoramiento::where('FK_PDM_Proceso', '=', $id)
                ->first();
            if ($verificarPlan == null) {
                $planMejoramiento = new PlanMejoramiento();
                $planMejoramiento->PDM_Nombre = "Plan de Mejoramiento Institucional " . $request->get('PCS_Nombre');
                $planMejoramiento->PDM_Descripcion = "Esta es la descripcion mientrastanto :D ";
                $planMejoramiento->FK_PDM_Proceso = $id;
                $planMejoramiento->save();
            }
        }
        $proceso->FK_PCS_Lineamiento = $request->get('PK_LNM_Id');
        $proceso->update();

        return response([
            'msg' => 'El proceso se ha sido modificado exitosamente.',
            'title' => 'Proceso Modificado!',
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
     * Esta funcion elimina los pocesos institucionales
     */
    public function destroy($id)
    {
        Proceso::destroy($id);

        return response([
            'msg' => 'El Proceso ha sido eliminado exitosamente.',
            'title' => 'Proceso Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

}
