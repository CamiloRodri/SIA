<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Models\Autoevaluacion\Evidencia;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
// use App\Models\Autoevaluacion\
use Yajra\DataTables\DataTables;
use App\Models\Autoevaluacion\Archivo;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CalificaActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_CALIFICA_ACTIVIDADES')->except('show'); //Se puede comentar
        $this->middleware(['permission:MODIFICAR_CALIFICA_ACTIVIDADES', 'permission:VER_CALIFICA_ACTIVIDADES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_CALIFICA_ACTIVIDADES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_CALIFICA_ACTIVIDADES', ['only' => ['destroy']]);
    }

    public function data(Request $request, $id)
    {
        
        // if ($request->ajax() && $request->isMethod('GET')) {
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
        // }
    }

    public function index($id)
    {
        $id = 1;
        $actividad = ActividadesMejoramiento::find($id);
        return view('autoevaluacion.SuperAdministrador.CalificaActividades.index', compact('actividad'));
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
        //
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
        //
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
        //
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
