<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActividadesMejoramientoRequest;
use App\Http\Requests\ModificarActividadesRequest;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Responsable;
use App\Models\Autoevaluacion\FechaCorte;
use Carbon\Carbon;
use DataTables;
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
        $this->middleware('permission:ACCEDER_EVIDENCIA')->except('show');
        $this->middleware('permission:ACCEDER_CALIFICA_ACTIVIDADES')->except('show');
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
                    ->last();
        return view('autoevaluacion.SuperAdministrador.ActividadesMejoramiento.index', compact('planMejoramiento', 'fechacorte', 'fechascorte', 'fechahoy'));
    }

    public function data(Request $request)
    {
        $planMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso', '=', session()->get('id_proceso'))
            ->first();
        if ($planMejoramiento != null) {
            if ($request->ajax() && $request->isMethod('GET')) {
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
                        if($actividades->ACM_Estado == 0)
                        {
                            return "<span class='label label-sm label-warning'>Evidencia pendiente</span>";
                        }
                        elseif($actividades->ACM_Estado == 1)
                        {
                            return "<span class='label label-sm label-info'>Evidencia por calificar</span>";
                        }
                        else
                        {
                            return "<span class='label label-sm label-success'>Evidencia calificada</span>";
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

    public function calendario()
    {
        return view('autoevaluacion.SuperAdministrador.CalendarioPlanMejoramiento.index');
    }
}