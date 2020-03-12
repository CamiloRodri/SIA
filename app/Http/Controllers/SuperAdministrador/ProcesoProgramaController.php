<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcesosProgramasRequest;
use App\Models\Autoevaluacion\Facultad;
use App\Models\Autoevaluacion\Fase;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\ProgramaAcademico;
use App\Models\Autoevaluacion\Sede;
use App\Models\Autoevaluacion\FechaCorte;
use App\Models\Autoevaluacion\Institucion;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProcesoProgramaController extends Controller
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
        $this->middleware('permission:ACCEDER_PROCESOS_PROGRAMAS');
        $this->middleware(['permission:MODIFICAR_PROCESOS_PROGRAMAS', 'permission:VER_PROCESOS_PROGRAMAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PROCESOS_PROGRAMAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PROCESOS_PROGRAMAS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.ProcesosProgramas.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Esta funcion llena el datatable de todos los procesos de programa
     * el cual requiere de sede, facultad, programa, fecha inicio;fin y fase
     * en caso de ser administrador solo se le muestra su programa
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            if (Gate::allows('SUPERADMINISTRADOR')) {
                $procesosProgramas = Proceso::with(['fase' => function ($query) {
                    return $query->select('PK_FSS_Id', 'FSS_Nombre');
                }])
                    ->with('programa.sede')
                    ->with('programa.facultad')
                    ->where('PCS_Institucional', '=', '0')
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
            } else {
                $procesosProgramas = Proceso::with(['fase' => function ($query) {
                    return $query->select('PK_FSS_Id', 'FSS_Nombre');
                }])
                    ->with('programa.sede')
                    ->with('programa.facultad')
                    ->where('PCS_Institucional', '=', '0')
                    ->where('FK_PCS_Programa', '=', Auth::user()->id_programa)
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Cuando se crea un proceso se necesitan las fases, facultades, sedes y lineamientos
     * en cado de ser administrador solo su sede y facultad
     */
    public function create()
    {
        $instituciones = Institucion::pluck('ITN_nombre', 'PK_ITN_Id');
        if (Gate::allows('SUPERADMINISTRADOR')) {
            $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
            $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');
            $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
            $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');
        } else {
            $sedes = Sede::where('PK_SDS_Id', '=', Auth::user()->programa->FK_PAC_Sede)
                ->pluck('SDS_Nombre', 'PK_SDS_Id');
            $facultades = Facultad::where('PK_FCD_Id', '=', Auth::user()->programa->FK_PAC_Facultad)
                ->pluck('FCD_Nombre', 'PK_FCD_Id');
            $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
            $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');
        }
        return view(
            'autoevaluacion.SuperAdministrador.ProcesosProgramas.create',
            compact('sedes', 'facultades', 'lineamientos', 'fases', 'instituciones')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea los procesos de programa
     */
    public function store(ProcesosProgramasRequest $request)
    {
        $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaInicio'));
        $fechaFin = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaFin'));

        $proceso = new Proceso();
        $proceso->fill($request->only(['PCS_Nombre']));
        $proceso->PCS_FechaInicio = $fechaInicio;
        $proceso->PCS_FechaFin = $fechaFin;
        $nombres = explode(' ', ProgramaAcademico::where('PK_PAC_Id', $request->get('PK_PAC_Id'))->first()->PAC_Nombre);
        $slug = "";
        foreach ($nombres as $nombre) {
            $slug = $slug . '_' . $nombre;
        }

        $proceso->PCS_Slug_Procesos = "Proceso" . $slug . Carbon::now()->toDateString();

        $proceso->FK_PCS_Fase = 3;
        $proceso->FK_PCS_Programa = $request->get('PK_PAC_Id');
        $proceso->FK_PCS_Lineamiento = $request->get('PK_LNM_Id');
        $proceso->save();

        $proceso = Proceso::where('PCS_Nombre', $request->only(['PCS_Nombre']))->value('PK_PCS_Id');

        $fechadeCorte = $fechaFin->subDays('10');

        $fechacorte = new FechaCorte();
        $fechacorte->FCO_Fecha = $fechadeCorte;
        $fechacorte->FK_FCO_Proceso = $proceso;
        $fechacorte->save();
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
     * Cuando se edita un proceso se necesitan las fases, facultades, sedes y lineamientos
     */
    public function edit($id)
    {
        $instituciones = Institucion::pluck('ITN_nombre', 'PK_ITN_Id');
        $proceso = Proceso::findOrFail($id);

        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');

        $sede = $proceso->programa->FK_PAC_Sede;
        $obtenerInstitucion = Sede::where('PK_SDS_Id', $sede)->get()->first();
        $idInstitucion = $obtenerInstitucion->FK_SDS_Institucion;

        $programas = new ProgramaAcademico();
        $programas = $programas::where('FK_PAC_Sede', '=', $proceso->programa->sede->PK_SDS_Id)
            ->where('FK_PAC_Facultad', '=', $proceso->programa->facultad->PK_FCD_Id)
            ->pluck('PAC_Nombre', 'PK_PAC_Id');

        return view(
            'autoevaluacion.SuperAdministrador.ProcesosProgramas.edit',
            compact('proceso', 'sedes', 'facultades', 'programas', 'lineamientos', 'fases',
                    'instituciones', 'idInstitucion')
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
     * Esta funcion edita los procesos de programa
     */
    public function update(ProcesosProgramasRequest $request, $id)
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
                $planMejoramiento->PDM_Nombre = "Plan de Mejoramiento " . $request->get('PCS_Nombre');
                $planMejoramiento->PDM_Descripcion = "Esta es la descripcion mientrastanto :D ";
                $planMejoramiento->FK_PDM_Proceso = $id;
                $planMejoramiento->save();
            }
        }
        $proceso->FK_PCS_Programa = $request->get('PK_PAC_Id');
        $proceso->FK_PCS_Lineamiento = $request->get('PK_LNM_Id');
        $nombres = explode(' ', ProgramaAcademico::where('PK_PAC_Id', $request->get('PK_PAC_Id'))->first()->PAC_Nombre);
        $slug = "";
        foreach ($nombres as $nombre) {
            $slug = $slug . '_' . $nombre;
        }

        $proceso->PCS_Slug_Procesos = $slug . Carbon::now()->toDateString();
        $proceso->update();

        if($request->get('PK_FSS_Id') != 1){
            if(session()->has('estado_proceso')){
                session()->forget('estado_proceso');
            }
        }
        else{
            session(['estado_proceso' => "cerrado" ]);
        }

        return response([
            'msg' => 'El proceso ha sido modificado exitosamente.',
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
     * Esta funcion elimina los procesos de programa
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

    public function ObtenerProgramas($id_sede, $id_facultad)
    {
        $programas = ProgramaAcademico::where('FK_PAC_Sede', '=', $id_sede)
            ->where('FK_PAC_Facultad', '=', $id_facultad)
            ->where('FK_PAC_Estado', '=', '1')
            ->pluck('PAC_Nombre', 'PK_PAC_Id');
        return json_encode($programas);
    }
}
