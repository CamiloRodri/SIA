<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActividadesMejoramientoRequest;
use App\Http\Requests\ModificarActividadesRequest;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Responsable;
use App\Models\Autoevaluacion\FechaCorte;
use App\Models\Autoevaluacion\CalificaActividad;
use App\Models\Autoevaluacion\Evidencia;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActividadesMejoramientoController extends Controller
{
    /**
     * Display a listing of the resource.
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
        // $this->middleware('permission:ACCEDER_EVIDENCIA')->except('show');
        // $this->middleware('permission:ACCEDER_CALIFICA_ACTIVIDADES')->except('show');
        $this->middleware('permission:ACCEDER_ACTIVIDADES_MEJORAMIENTO')->except('show');
        $this->middleware(['permission:MODIFICAR_ACTIVIDADES_MEJORAMIENTO', 'permission:VER_ACTIVIDADES_MEJORAMIENTO'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ACTIVIDADES_MEJORAMIENTO', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ACTIVIDADES_MEJORAMIENTO', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso', '=', session()->get('id_proceso'))
            ->first();
        $fechascorte = FechaCorte::where('FK_FCO_Proceso', '=', session()->get('id_proceso'))
                    ->orderBy('FCO_Fecha')
                    ->get();
        $fechahoy = Carbon::now()->format('Y-m-d');
        $fechacorte = FechaCorte::whereDate('FCO_Fecha', '>=', Carbon::now()->format('Y-m-d'))
                    ->where('FK_FCO_Proceso', '=', session()->get('id_proceso'))
                    ->get()
                    ->first();

        if(Auth::user()->hasRole('SUPERADMIN') || Auth::user()->hasRole('EVALUADOR')
        )
        {
            $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
                return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso'));
            })
                ->with('Caracteristicas.factor', 'responsable.usuarios')
                ->get();
        }
        else
        {
            $responsable = Responsable::where('FK_RPS_Responsable','=',Auth::user()->id)
            ->first();
            $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
                return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso'));
            })
                ->with('Caracteristicas.factor', 'responsable.usuarios', 'califica')
                ->where('FK_ACM_Responsable','=',$responsable->PK_RPS_Id ?? null)
                ->get();
        }

       if(! is_null($fechacorte)){
            $fechacorteanterior = FechaCorte::where('PK_FCO_Id', '<', $fechacorte->PK_FCO_Id)->orderBy('PK_FCO_Id', 'des')->first();
            for($i = 0; $i < count($actividades); $i ++){
                if($fechacorteanterior) {
                    $docEvidencia = Evidencia::whereHas('actividad_mejoramiento.califica')
                                            ->where('FK_EVD_Actividad_Mejoramiento', $actividades[$i]->PK_ACM_Id)
                                            ->whereDate('EVD_Fecha_Subido', '<=', $fechacorte->FCO_Fecha)
                                            ->whereDate('EVD_Fecha_Subido', '>', $fechacorteanterior->FCO_Fecha)
                                            ->get();
                    if($docEvidencia->isEmpty()){

                        $actividadesMejoramiento = ActividadesMejoramiento::findOrFail($actividades[$i]->PK_ACM_Id);
                        $actividadesMejoramiento->ACM_Estado = 0;
                        $actividadesMejoramiento->update();
                    }
                    else{
                        $calificaciones = CalificaActividad::where('FK_CLA_Actividad_Mejoramiento', $actividades[$i]->PK_ACM_Id)
                                                            ->where('FK_CLA_Fecha_Corte', $fechacorte->PK_FCO_Id)
                                                            ->get();
                        if($calificaciones->isEmpty()){
                            $actividadesMejoramiento = ActividadesMejoramiento::findOrFail($actividades[$i]->PK_ACM_Id);
                            $actividadesMejoramiento->ACM_Estado = 1;
                            $actividadesMejoramiento->update();
                        }
                        else{
                            $actividadesMejoramiento = ActividadesMejoramiento::findOrFail($actividades[$i]->PK_ACM_Id);
                            $actividadesMejoramiento->ACM_Estado = 2;
                            $actividadesMejoramiento->update();
                        }
                    }
                }
            }
       }



        return view('autoevaluacion.SuperAdministrador.ActividadesMejoramiento.index',
        compact('planMejoramiento', 'fechacorte', 'fechascorte', 'fechahoy', 'actividades'));
    }

    public function data(Request $request)
    {
        $califica = CalificaActividad::pluck('CLA_Calificacion')->first();
        $planMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso', '=', session()->get('id_proceso'))
            ->first();
        if ($planMejoramiento != null) {
            if ($request->ajax() && $request->isMethod('GET')) {
                if(Auth::user()->hasRole('SUPERADMIN') || Auth::user()->hasRole('EVALUADOR')
                )
                {
                    $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
                        return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso'));
                    })
                        ->with('Caracteristicas.factor', 'responsable.usuarios')
                        ->get();
                }
                else
                {
                    $responsable = Responsable::where('FK_RPS_Responsable','=',Auth::user()->id)
                    ->first();
                    $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
                        return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso'));
                    })
                        ->with('Caracteristicas.factor', 'responsable.usuarios', 'califica')
                        ->where('FK_ACM_Responsable','=',$responsable->PK_RPS_Id ?? null)
                        ->get();

                }
                return DataTables::of($actividades)
                    ->editColumn('ACM_Fecha_Inicio', function ($actividades) {
                        return $actividades->ACM_Fecha_Inicio ? with(new Carbon($actividades->ACM_Fecha_Inicio))->format('d/m/Y') : '';
                    })
                    ->editColumn('ACM_Fecha_Fin', function ($actividades) {
                        return $actividades->ACM_Fecha_Fin ? with(new Carbon($actividades->ACM_Fecha_Fin))->format('d/m/Y') : '';
                    })
                    ->addColumn('responsable', function ($actividades) {
                        return $actividades->responsable->usuarios->name." ".$actividades->responsable->usuarios->lastname;

                    })
                    ->addColumn('estado', function ($actividades) {

                        switch ($actividades->ACM_Estado) {
                            case 0:
                                return "<span class='label label-sm label-warning'>Evidencia pendiente</span>";
                                break;
                            case 1:
                                return "<span class='label label-sm label-info'>Evidencia por calificar</span>";
                                break;
                            case 2:
                                return "<span class='label label-sm label-success'>Evidencia calificada</span>";
                                break;
                            case 3:
                                return "<span class='label label-sm label-success'>Evi. re-calificada</span>";
                            default:
                            return "<span class='label label-sm label-danger'>Error</span>";
                        }
                    })
                    // |---------|   |----------------|    |--------------------|
                    ->addColumn('avance', function ($actividades) {
                        if(!$actividades->califica){
                            return '0 %';
                        }
                        else{
                            return ((($actividades->califica->get()->sortByDesc('CLA_Calificacion')->first())->CLA_Calificacion)*100)/5.0 .'%';
                        }
                    })
                    ->rawColumns(['estado'])
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
    public function create($id)
    {
        session()->put('id_actividad', $id);
        $responsable = Responsable::with(['usuarios' => function($query){
            $query->selectRaw('*, CONCAT(name," ",lastname) as nombre');
        }])
        ->where('FK_RPS_Proceso','=',session()->get('id_proceso')??null)
        ->get()->pluck('usuarios.nombre','PK_RPS_Id');
        return view('autoevaluacion.SuperAdministrador.ActividadesMejoramiento.create', compact('responsable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActividadesMejoramientoRequest $request)
    {
        $actividades = new ActividadesMejoramiento();
        /**
         * Se debe cambiar el formato de la fecha de publicacion y de finalizacion.
         */
        $actividades->fill($request->only(['ACM_Nombre', 'ACM_Descripcion']));
        $actividades->ACM_Fecha_Inicio = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Inicio'));
        $actividades->ACM_Fecha_Fin = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Fin'));
        $actividades->FK_ACM_Responsable = $request->get('PK_RPS_Id');
        $actividades->FK_ACM_Caracteristica = session()->get('id_actividad');
        $actividades->ACM_Estado=0;
        $idPlanMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso', '=', session()->get('id_proceso'))->first()->PK_PDM_Id;
        $actividades->FK_ACM_Plan_Mejoramiento = $idPlanMejoramiento;
        $actividades->save();
        return response([
            'msg' => 'Actividad creada con exito.',
            'title' => '¡Proceso Exitoso!',
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
        $responsable = Responsable::with(['usuarios' => function($query){
            $query->selectRaw('*, CONCAT(name," ",lastname) as nombre');
        }])
        ->where('FK_RPS_Proceso','=',session()->get('id_proceso')??null)
        ->get()->pluck('usuarios.nombre','PK_RPS_Id');
        $actividades = ActividadesMejoramiento::findOrFail($id);
        return view(
            'autoevaluacion.SuperAdministrador.ActividadesMejoramiento.edit',
            compact('responsable', 'actividades')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModificarActividadesRequest $request, $id)
    {
        $actividades = ActividadesMejoramiento::find($id);
        $actividades->ACM_Fecha_Inicio = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Inicio'));
        $actividades->ACM_Fecha_Fin = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Fin'));

        $actividades->ACM_Nombre = $request->get('ACM_Nombre');
        $actividades->ACM_Descripcion = $request->get('ACM_Descripcion');
        $actividades->FK_ACM_Responsable = $request->get('PK_RPS_Id');
        $actividades->update();
        return response(['msg' => 'La actividad de mejoramiento se ha moficado.',
            'title' => 'Actividad de Mejoramiento Modificada!',
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
        ActividadesMejoramiento::destroy($id);

        return response(['msg' => 'La actividad de mejoramiento se ha sido eliminada exitosamente.',
            'title' => 'Actividad de Mejoramiento Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
    public function estado($id)
    {
        $actividades = ActividadesMejoramiento::find($id);
        $responsable = Responsable::where('PK_RPS_Id','=',$actividades->FK_ACM_Responsable)
        ->first();
        $id_usuario = Auth::user()->id;
        if(!Auth::user()->hasRole('SUPERADMIN') || !Auth::user()->hasRole('SUPERADMIN'))
        {
            if($id_usuario != $responsable->FK_RPS_Responsable )
            {
                return redirect()->back()->with('error','Mensaje Enviado');
            }
            else
            {
                if($actividades->ACM_Estado == 1){
                    $actividades->ACM_Estado=0;}
                else{
                    $actividades->ACM_Estado=1;}
                $actividades->update();
                return redirect()->back()->with('status','Mensaje Enviado');
            }
        }
        else
        {
            if($actividades->ACM_Estado == 1){
                $actividades->ACM_Estado=0;}
            else{
                $actividades->ACM_Estado=1;}
            $actividades->update();
            return redirect()->back()->with('status','Mensaje Enviado');
        }
    }

    public function calendario(Request $request)
    {
        $fechahoy = Carbon::now()->format('Y-m-d');
        $actividades = ActividadesMejoramiento::where('PK_ACM_Id', '0')->get();
        $planMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso', '=', session()->get('id_proceso'))
            ->first();
        if ($planMejoramiento != null) {
                if(Auth::user()->hasRole('SUPERADMIN') || Auth::user()->hasRole('SUPERADMIN'))
                {
                    $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
                        return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso'));
                    })
                        ->with('Caracteristicas.factor', 'responsable.usuarios')
                        ->get();
                }
                else
                {
                    $responsable = Responsable::where('FK_RPS_Responsable','=',Auth::user()->id)
                    ->first();
                    $actividades = ActividadesMejoramiento::where('FK_ACM_Plan_Mejoramiento', session()->get('id_proceso'))
                        ->where('FK_ACM_Responsable','=',$responsable->PK_RPS_Id ?? null)
                        ->get();
                }
        }

        foreach($actividades as $actividad){
            $nombre = ($actividad->ACM_Nombre);
            $inicio = substr($actividad->ACM_Fecha_Inicio, 0, 10);
            $fin = substr($actividad->ACM_Fecha_Fin, 0, 10);
            // $actividad->json = '[{"title'.'":"'.$nombre.'"},'.'{"start'.'":"'.$inicio.'"},'.'{"end'.'":"'.$fin.'"},'.']';
            $actividad->json = collect([['title' => $nombre , 'start' => $inicio, 'end' => $fin ]]);
            $actividad->json = $actividad->json->toJson();
        }

        //dd($actividades);

        return view('autoevaluacion.SuperAdministrador.CalendarioPlanMejoramiento.index', compact('planMejoramiento', 'fechahoy', 'actividades'));
    }
}
