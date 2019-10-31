<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Evidencia;
use App\Models\Autoevaluacion\Archivo;
use App\Models\Autoevaluacion\Responsable;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Http\Requests\EvidenciaRequest;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $actividad = ActividadesMejoramiento::find($id);
        $responsable = Responsable::where('PK_RPS_Id','=',$actividad->FK_ACM_Responsable)
        ->first();
        $id_usuario = Auth::user()->id;

        \Debugbar::info($id_usuario);
        \Debugbar::info($responsable->FK_RPS_Responsable);
        if(!Auth::user()->hasRole('SUPERADMIN') || !Auth::user()->hasRole('SUPERADMIN'))
        {
            if($id_usuario != $responsable->FK_RPS_Responsable )
            {
                return redirect()->back()->with('error','Mensaje Error');
            }
            else
            {
                return view('autoevaluacion.SuperAdministrador.Evidencias.index', compact('actividad'));
            }
        }
        else
        {
            return view('autoevaluacion.SuperAdministrador.Evidencias.index', compact('actividad'));
        } 
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
    public function store(EvidenciaRequest $request)
    {
        $now = new \DateTime();
        $now->format('d-m-Y H:i:s');
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $archivo = new Archivo;
            $archivo->ACV_Nombre = $file->getClientOriginalName();
            $archivo->ACV_Extension = $file->extension();
            $archivo->ruta = Storage::url($file->store('public/DocumentosAutoevaluacion/EVIDENCIA'));
            $archivo->save();

            $evidencia = new Evidencia;
            $evidencia->EVD_Nombre = $request->EVD_Nombre;
            $evidencia->EVD_Descripcion_General = $request->EVD_Descripcion_General;
            $evidencia->EVD_link = $request->EVD_link;
            $evidencia->FK_EVD_Archivo = $archivo->PK_ACV_Id;
            $evidencia->FK_EVD_Actividad_Mejoramiento = $request->FK_EVD_Actividad_Mejoramiento;
            $evidencia->EVD_Fecha_Subido =  Carbon::now();
            $evidencia->save();
        } else {
            $evidencia = new Evidencia;
            $evidencia->EVD_Nombre = $request->EVD_Nombre;
            $evidencia->EVD_Descripcion_General = $request->EVD_Descripcion_General;
            $evidencia->EVD_Link = $request->EVD_Link;
            $evidencia->FK_EVD_Actividad_Mejoramiento = $request->FK_EVD_Actividad_Mejoramiento;
            $evidencia->EVD_Fecha_Subido =  Carbon::now();
            $evidencia->save();
        }

        $actividadesMejoramiento = ActividadesMejoramiento::findOrFail($request->FK_EVD_Actividad_Mejoramiento);
        $actividadesMejoramiento->ACM_Estado = 1;
        $actividadesMejoramiento->update();

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
        $evidencia = Evidencia::findOrFail($id);

        if($evidencia->archivo){
            $size = filesize(public_path($evidencia->archivo->ruta));
        }
        else{
            $size = null;
        }
        \Debugbar::info($evidencia);
        \Debugbar::info($evidencia->archivo);
        \Debugbar::info($size);
        return view('autoevaluacion.SuperAdministrador.Evidencias.edit', [
            'actividad' => $evidencia,
            'edit' => true,
        ], compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EvidenciaRequest $request, $id)
    {
        $borraArchivo = false;
        $borrarLink = false;

        $evidencia = Evidencia::findOrFail($id);

        /**
         * Si la peticion tenia un archivo incluido se guarda y se obtiene el
         * id del archivo guardado
         */
        if ($request->hasFile('archivo')) {
            $borrarLink = true;
            $archivo = $request->file('archivo');
            $nombre = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();
            $url = Storage::url($archivo->store('public/DocumentosAutoevaluacion/EVIDENCIA'));

            /**
             * Si el documento y tenia un documento se elimina este y se guarda el nuevo,
             * si no es asi simplemente se guarda
             */
            if ($evidencia->archivo) {
                $ruta = str_replace('storage', 'public', $evidencia->archivo->ruta);
                Storage::delete($ruta);
                $archivos = Archivo::findOrfail($evidencia->FK_EVD_Archivo);
                $archivos->ACV_Nombre = $nombre;
                $archivos->ACV_Extension = $extension;
                $archivos->ruta = $url;
                $archivos->update();
                $idArchivo = $archivos->PK_ACV_Id;
            } 
            else {
                $archivos = new Archivo();
                $archivos->ACV_Nombre = $nombre;
                $archivos->ACV_Extension = $extension;
                $archivos->ruta = $url;
                $archivos->save();
                $idArchivo = $archivos->PK_ACV_Id;
            }
        }

        /**
         * Si se guardo un link y existía un archivo se elimina el archivo y se guarda el link
         */
        if ($request->get('EVD_Link') != null && $evidencia->archivo) {
            $evidencia->FK_EVD_Archivo = null;
            $borraArchivo = true;
            $id = $evidencia->FK_EVD_Archivo;
            // $evidencia->EVD_Link = $request->get('EDV_Link');
        }
        // else{
        //     $evidencia->EVD_Link = $request->get('EDV_Link');
        // }

        $evidencia->fill($request->only([
            'EVD_Nombre',
            'EVD_Descripcion_General',
            'EVD_Link',
            'FK_EVD_Actividad_Mejoramiento',
        ]));

        $id_Actividad_Mejoramiento = $request->get('FK_EVD_Actividad_Mejoramiento');

        if (isset($idArchivo)) {
            $evidencia->FK_EVD_Archivo = $idArchivo;
        }
        /**
         * Se elimina el archivo al final debido a problemas de perdida de datos, esto ocurre
         * si la petición traía un link y el documento antes tenia un archivo guardado en el servidor
         */
        if ($borraArchivo) {
            Archivo::destroy($id);
        }
        if ($borrarLink){
            $evidencia->EVD_Link = null;
        }


        $evidencia->update();

        // return redirect()->route('admin.evidencia.index', $id_Actividad_Mejoramiento);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evidencia = Evidencia::findOrfail($id);
        if ($evidencia->archivo) {
            $ruta = str_replace('storage', 'public', $evidencia->archivo->ruta);
            Storage::delete($ruta);
            $evidencia->archivo()->delete();
        } else {
            $evidencia->delete();
        }
        return response(['msg' => 'La Evidencia ha sido eliminada exitosamente.',
            'title' => '¡Registro Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
