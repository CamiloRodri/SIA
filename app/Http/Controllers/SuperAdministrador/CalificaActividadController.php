<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Requests\CalificaActividadRequest;
use App\Models\Autoevaluacion\Evidencia;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\CalificaActividad;
use App\Models\Autoevaluacion\FechaCorte;
use Yajra\DataTables\DataTables;
use App\Models\Autoevaluacion\Archivo;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class CalificaActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_CALIFICA_ACTIVIDADES')->except('show');
        $this->middleware(['permission:MODIFICAR_CALIFICA_ACTIVIDADES', 'permission:VER_CALIFICA_ACTIVIDADES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_CALIFICA_ACTIVIDADES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_CALIFICA_ACTIVIDADES', ['only' => ['destroy']]);
    }

    public function index($id)
    {
        $actividad = ActividadesMejoramiento::find($id);

        $fechahoy = Carbon::now()->format('Y-m-d');
        $fechacorte = FechaCorte::whereDate('FCO_Fecha', '>=', Carbon::now()->format('Y-m-d'))
                    ->where('FK_FCO_Proceso', '=', session()->get('id_proceso'))
                    ->get()
                    ->first();

        if(!$fechacorte)
        {
            return redirect()->back()->with('fecha_corte_error','Mensaje Error'); 
        }
        elseif($fechahoy <= $fechacorte->FCO_Fecha)
        {
            $calificacion = CalificaActividad::where('FK_CLA_Actividad_Mejoramiento', $actividad->PK_ACM_Id)->first();

            return view('autoevaluacion.SuperAdministrador.CalificaActividades.index', compact('actividad', 'calificacion'));
        }
        else
        {
            return redirect()->back()->with('califica_error','Fecha Error');
        }
    }
    public function data(Request $request, $id)
    {
        
        if ($request->ajax() && $request->isMethod('GET')) {
            $docEvidencia = Evidencia::with('archivo')->where('FK_EVD_Actividad_Mejoramiento', $id)
                ->get();
            return Datatables::of($docEvidencia)
                ->addColumn('archivo', function ($docEvidencia) {
                    /**
                     * Si el documento tiene una archivo guardado en el servidor
                     * Se obtiene el url y se coloca en un link, si no es asi es porque tiene
                     * una url entonces también se le asignar a un botón tipo link.
                     */
                    if (!$docEvidencia->archivo) {
                        return '<a class="btn btn-success btn-xs" href="' . $docEvidencia->EVD_Link .
                            '"target="_blank" role="button">Enlace al documento</a>';
                    } else {

                        return '<a class="btn btn-success btn-xs" href="' . route('descargar') . '?archivo=' .
                            $docEvidencia->archivo->ruta .
                            '" target="_blank" role="button">' . $docEvidencia->archivo->ACV_Nombre . '</a>';


                    }
                })
                ->rawColumns(['archivo'])
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->get('CLA_Calificacion') || !$request->get('CLA_Observacion'))
        {
            return redirect()->route('admin.califica_actividad.index', $request->get('FK_CLA_Actividad_Mejoramiento'))->with('error', 'Datos Incompletos');
        }

        $fechacorte = FechaCorte::whereDate('FCO_Fecha', '>=', Carbon::now()->format('Y-m-d'))
                    ->where('FK_FCO_Proceso', '=', session()->get('id_proceso'))
                    ->get()
                    ->first();
                    
        $valida = CalificaActividad::where('FK_CLA_Actividad_Mejoramiento', $request->get('FK_CLA_Actividad_Mejoramiento'))->get()->last();

        if(!$valida)
        {
            $calificacion = new CalificaActividad();
            $calificacion->fill($request->only(['CLA_Calificacion', 
                                                'CLA_Observacion',
                                                'FK_CLA_Actividad_Mejoramiento']));

            $calificacion->FK_CLA_Fecha_Corte = $fechacorte->PK_FCO_Id;
            $calificacion->save();

            $actividadesMejoramiento = ActividadesMejoramiento::findOrFail($request->FK_CLA_Actividad_Mejoramiento);
            $actividadesMejoramiento->ACM_Estado = 2;
            $actividadesMejoramiento->update();
        }
        else
        {
            // dd($valida, $fechacorte);
            if($valida->FK_CLA_Fecha_Corte == $fechacorte->PK_FCO_Id)
            {
                // dd("no deberia");
                $valida->CLA_Calificacion = $request->get('CLA_Calificacion');
                $valida->CLA_Observacion = $request->get('CLA_Observacion');
                $valida->update();
            }
            else
            {
                // dd("entro");
                $calificacion_nueva = new CalificaActividad();
                $calificacion_nueva->fill($request->only(['CLA_Calificacion', 
                                                    'CLA_Observacion',
                                                    'FK_CLA_Actividad_Mejoramiento']));
                $calificacion_nueva->FK_CLA_Fecha_Corte = $fechacorte->PK_FCO_Id;
                $calificacion_nueva->save();
            }
            
            $actividadesMejoramiento = ActividadesMejoramiento::findOrFail($request->FK_CLA_Actividad_Mejoramiento);
            $actividadesMejoramiento->ACM_Estado = 3;
            $actividadesMejoramiento->update();
        }

        return redirect()->route('admin.actividades_mejoramiento.index')->with('status', 'Actividad Calificada');
        
        return response(['msg' => 'Calificación registrado correctamente.',
            'title' => '¡Registro exitoso!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('autoevaluacion.SuperAdministrador.CalificaActividades.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fechacorte = FechaCorte::whereDate('FCO_Fecha', '>=', Carbon::now()->format('Y-m-d'))
                    ->where('FK_FCO_Proceso', '=', session()->get('id_proceso'))
                    ->get()
                    ->last();       

        $calificacion = new CalificaActividad();
        $calificacion->fill($request->only(['CLA_Calificacion', 
                                            'CLA_Observacion',
                                            'FK_CLA_Actividad_Mejoramiento']));

        $calificacion->FK_CLA_Fecha_Corte = $fechacorte->PK_FCO_Id;
        $calificacion->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
