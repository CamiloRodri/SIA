<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Evidencia;
use App\Models\Autoevaluacion\Archivo;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Barryvdh\Debugbar;
use App\Models\Autoevaluacion\DocumentoInstitucional;

class EvidenciaController extends Controller
{

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_EVIDENCIA')->except('show');
        $this->middleware(['permission:MODIFICAR_EVIDENCIA', 'permission:VER_EVIDENCIA'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_EVIDENCIA', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_EVIDENCIA', ['only' => ['destroy']]);
    }

    public function datos(Request $request, $id)
    {
        
        // if ($request->ajax() && $request->isMethod('GET')) {
            $docEvidencia = Evidencia::with('archivo')->where('FK_EVD_Actividad_Mejoramiento', $id)
                ->get();
                \Debugbar::info($docEvidencia);
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

    // public function data(Request $request)
    // {
    //     if ($request->ajax() && $request->isMethod('GET')) {
    //         $evidencia = Evidencia::all();
    //         return Datatables::of($evidencia)
    //             ->make(true);
    //     }
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $actividad = ActividadesMejoramiento::find($id);
        return view('autoevaluacion.SuperAdministrador.Evidencias.index', compact('actividad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $actividad = ActividadesMejoramiento::find($id);
        return view('autoevaluacion.SuperAdministrador.Evidencias.create', compact('actividad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = new \DateTime();
        $now->format('d-m-Y H:i:s');
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $archivo = new Archivo;
            $archivo->ACV_Nombre = $file->getClientOriginalName();
            $archivo->ACV_Extension = $file->extension();
            $archivo->ruta = Storage::url($file->store('public/DocumentosInstitucionales/EVIDENCIA'));
            $archivo->save();

            $docEvidencia = new Evidencia;
            $docEvidencia->EVD_Nombre = $request->EVD_Nombre;
            $docEvidencia->EVD_Descripcion_General = $request->EVD_Descripcion_General;
            $docEvidencia->EVD_link = $request->EVD_link;
            $docEvidencia->FK_EVD_Archivo = $archivo->PK_ACV_Id;
            $docEvidencia->FK_EVD_Actividad_Mejoramiento = $request->FK_EVD_Actividad_Mejoramiento;
            $docEvidencia->EVD_Fecha_Subido =  Carbon::now();
            $docEvidencia->save();
        } else {
            $docEvidencia = new Evidencia;
            $docEvidencia->EVD_Nombre = $request->EVD_Nombre;
            $docEvidencia->EVD_Descripcion_General = $request->EVD_Descripcion_General;
            $docEvidencia->EVD_Link = $request->EVD_Link;
            $docEvidencia->FK_EVD_Actividad_Mejoramiento = $request->FK_EVD_Actividad_Mejoramiento;
            $docEvidencia->EVD_Fecha_Subido =  Carbon::now();
            $docEvidencia->save();
        }

        return response(['msg' => 'Evidencia registrada correctamente.',
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
        $evidencia = Evidencia::find($id);
        $evidencia->fill($request->only(['EVD_Nombre']));
        $evidencia->fill($request->only(['EVD_Link']));
        $evidencia->EVD_Fecha_Subido =  Carbon::now();
        $evidencia->fill($request->only(['EVD_Descripcion_General']));
        $evidencia->fill($request->only(['FK_EVD_Actividad_Mejoramiento']));
        $evidencia->update();
        
        return response(['msg' => 'La Evidencia ha sido modificada exitosamente.',
            'title' => 'Evidencia modificada :*!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Evidencia::destroy($id);

        return response(['msg' => 'La Evidencia ha sido eliminada exitosamente.',
            'title' => '¡Evidencia Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
