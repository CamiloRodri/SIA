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
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection as Collection;

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

        /**
         * Esta es la logica empleada para el envio de notificaciones por correos
         */
        $act_msg = ActividadesMejoramiento::where('ACM_Estado', '!=', '2')->where('ACM_Estado', '!=', '3')->get();
        for($i = 0; $i < sizeof($act_msg); $i++ ) {
            $dias_restantes = $act_msg[$i]->ACM_Fecha_Fin->diffInDays(Carbon::now()) + 1;

            if(Carbon::now()->format('Y-m-d') != $act_msg[$i]->ACM_Notificacion) {
                if($dias_restantes >= 1 || $dias_restantes < 5) {
                    $dias_restantes_alert = "<span class='label danger'>Tener en cuenta, días restantes: $dias_restantes</span>";
                    $act_msg[$i] = array_add($act_msg[$i], 'dias_restantes', $dias_restantes_alert);
                    $datos_responsable = ActividadesMejoramiento::findOrFail($act_msg[$i]->PK_ACM_Id);
                    $act_msg[$i] = array_add($act_msg[$i], 'nombre_responsable', $datos_responsable->responsable->usuarios->name);
                    $act_msg[$i] = array_add($act_msg[$i], 'apellido_responsable', $datos_responsable->responsable->usuarios->lastname);
                    $for = $act_msg[$i]->nombre_responsable . " " . $act_msg[$i]->apellido_responsable;
                    $act_msg[$i] = array_add($act_msg[$i], 'correo_responsable', $datos_responsable->responsable->usuarios->email);
                    $to = $act_msg[$i]->correo_responsable;
                    $subject = "Acitividad de Mejoramiento [Notificación]";
                    $colletion = Collection::make($act_msg[$i]);
                    $info_mensaje = $colletion->toArray();

                    Mail::send('email_actividades', $info_mensaje, function ($message) use ($for, $to, $subject){
                        $message->from($to, $for);
                        $message->subject($subject);
                        $message->to($to);
                        $message->priority(1);
                    });

                    $actualizar_fecha = ActividadesMejoramiento::find($act_msg[$i]->PK_ACM_Id);
                    $actualizar_fecha->ACM_Notificacion = Carbon::now()->format('Y-m-d');
                    $actualizar_fecha->update();
                }
                elseif($dias_restantes >= 5 && $dias_restantes < 10) {
                    if(!$act_msg[$i]->ACM_Notificacion) {
                        $dias_restantes_alert = "<span class='label warning'>Tener en cuenta, días restantes: $dias_restantes</span>";
                        $act_msg[$i] = array_add($act_msg[$i], 'dias_restantes', $dias_restantes_alert);
                        $datos_responsable = ActividadesMejoramiento::findOrFail($act_msg[$i]->PK_ACM_Id);
                        $act_msg[$i] = array_add($act_msg[$i], 'nombre_responsable', $datos_responsable->responsable->usuarios->name);
                        $act_msg[$i] = array_add($act_msg[$i], 'apellido_responsable', $datos_responsable->responsable->usuarios->lastname);
                        $for = $act_msg[$i]->nombre_responsable . " " . $act_msg[$i]->apellido_responsable;
                        $act_msg[$i] = array_add($act_msg[$i], 'correo_responsable', $datos_responsable->responsable->usuarios->email);
                        $to = $act_msg[$i]->correo_responsable;
                        $subject = "Acitividad de Mejoramiento [Notificación]";
                        $colletion = Collection::make($act_msg[$i]);
                        $info_mensaje = $colletion->toArray();

                        Mail::send('email_actividades', $info_mensaje, function ($message) use ($for, $to, $subject){
                            $message->from($to, $for);
                            $message->subject($subject);
                            $message->to($to);
                            $message->priority(2);
                        });

                        $actualizar_fecha = ActividadesMejoramiento::find($act_msg[$i]->PK_ACM_Id);
                        $actualizar_fecha->ACM_Notificacion = Carbon::now()->format('Y-m-d');
                        $actualizar_fecha->update();
                    }
                    else{
                        $fecha_notificacion = Carbon::parse($act_msg[$i]->ACM_Notificacion);
                        $dif_dias_notificacion = $fecha_notificacion->diffInDays(Carbon::now()->format('Y-m-d'));
                        if($dif_dias_notificacion > 2) {
                            $dias_restantes_alert = "<span class='label warning'>Tener en cuenta, días restantes: $dias_restantes</span>";
                            $act_msg[$i] = array_add($act_msg[$i], 'dias_restantes', $dias_restantes_alert);
                            $datos_responsable = ActividadesMejoramiento::findOrFail($act_msg[$i]->PK_ACM_Id);
                            $act_msg[$i] = array_add($act_msg[$i], 'nombre_responsable', $datos_responsable->responsable->usuarios->name);
                            $act_msg[$i] = array_add($act_msg[$i], 'apellido_responsable', $datos_responsable->responsable->usuarios->lastname);
                            $for = $act_msg[$i]->nombre_responsable . " " . $act_msg[$i]->apellido_responsable;
                            $act_msg[$i] = array_add($act_msg[$i], 'correo_responsable', $datos_responsable->responsable->usuarios->email);
                            $to = $act_msg[$i]->correo_responsable;
                            $subject = "Acitividad de Mejoramiento [Notificación]";
                            $colletion = Collection::make($act_msg[$i]);
                            $info_mensaje = $colletion->toArray();

                            Mail::send('email_actividades', $info_mensaje, function ($message) use ($for, $to, $subject){
                                $message->from($to, $for);
                                $message->subject($subject);
                                $message->to($to);
                                $message->priority(2);
                            });

                            $actualizar_fecha = ActividadesMejoramiento::find($act_msg[$i]->PK_ACM_Id);
                            $actualizar_fecha->ACM_Notificacion = Carbon::now()->format('Y-m-d');
                            $actualizar_fecha->update();
                        }
                    }
                }
            }
        }
        /**
         * Esta es la logica empleada para el envio de notificaciones por correos
         */


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
        return view('autoevaluacion.SuperAdministrador.ActividadesMejoramiento.index', compact('planMejoramiento', 'fechacorte', 'fechascorte', 'fechahoy'));
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
                        ->with('Caracteristicas.factor', 'responsable.usuarios')
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
                    ->addColumn('avance', $califica ."".'%' //function ($califica) {
                        // foreach($califica as $cal){
                        //     return $cal;
                        // }
                    )// })
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
