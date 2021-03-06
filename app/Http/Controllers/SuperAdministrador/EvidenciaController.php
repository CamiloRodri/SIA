<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Evidencia;
use App\Models\Autoevaluacion\Archivo;
use App\Models\Autoevaluacion\Responsable;
use App\Models\Autoevaluacion\FechaCorte;
use App\Models\Autoevaluacion\CalificaActividad;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $fechacorte = FechaCorte::whereDate('FCO_Fecha', '>=', Carbon::now()->format('Y-m-d'))
                    ->where('FK_FCO_Proceso', '=', session()->get('id_proceso'))
                    ->get()
                    ->first();
        if(!$fechacorte)
        {
            return redirect()->back()->with('fecha_corte_error','Mensaje Error');
        }
        else
        {
            $actividad = ActividadesMejoramiento::find($id);

            if(strlen($actividad->ACM_Nombre) > 35){
                $nombre_actividad = substr($actividad->ACM_Nombre, 0, 35) . " ...";
            }

            $responsable = Responsable::where('PK_RPS_Id','=',$actividad->FK_ACM_Responsable)
            ->first();
            $id_usuario = Auth::user()->id;

            if($actividad->ACM_Fecha_Fin > Carbon::now()->format('Y-m-d') )
            {
                $calificacion = CalificaActividad::where('FK_CLA_Actividad_Mejoramiento', $id)->get()->last();
                if($calificacion)
                {
                    if($calificacion->CLA_Calificacion == 5){
                        return redirect()->back()->with('califica_completo','Mensaje Info');
                    }
                    else{
                        Session::put('calificacion', $calificacion->CLA_Calificacion);
                        Session::put('observacion', $calificacion->CLA_Observacion);
                    }

                }
                else
                {
                    Session::put('calificacion', 'null');
                }

                if(!Auth::user()->hasRole('SUPERADMIN') || !Auth::user()->hasRole('SUPERADMIN'))
                {
                    if($id_usuario = $responsable->FK_RPS_Responsable )
                    {
                        return view('autoevaluacion.SuperAdministrador.Evidencias.index', compact('actividad', 'nombre_actividad'));
                    }
                    else
                    {
                        return redirect()->back()->with('error','Mensaje Error');
                    }
                }
                else
                {
                    return view('autoevaluacion.SuperAdministrador.Evidencias.index', compact('actividad', 'nombre_actividad'));
                }
            }
            else
            {
                return redirect()->back()->with('date_error','Fecha Error');
            }
        }
    }

    public function datos(Request $request, $id)
    {
        $fechacorte = FechaCorte::whereDate('FCO_Fecha', '>=', Carbon::now()->format('Y-m-d'))
                    ->where('FK_FCO_Proceso', '=', session()->get('id_proceso'))
                    ->get()
                    ->first();
        $fechacorteanterior = FechaCorte::where('PK_FCO_Id', '<', $fechacorte->PK_FCO_Id)->orderBy('PK_FCO_Id', 'des')->first();
        if ($request->ajax() && $request->isMethod('GET')) {
            if(!$fechacorteanterior)
            {
                $docEvidencia = Evidencia::with('archivo')
                                            ->where('FK_EVD_Actividad_Mejoramiento', $id)
                                            ->whereDate('EVD_Fecha_Subido', '<=', $fechacorte->FCO_Fecha)
                    ->get();//dd($fechacorteanterior);
            }
            else
            {
                $docEvidencia = Evidencia::with('archivo')
                                            ->where('FK_EVD_Actividad_Mejoramiento', $id)
                                            ->whereDate('EVD_Fecha_Subido', '<=', $fechacorte->FCO_Fecha)
                                            ->whereDate('EVD_Fecha_Subido', '>', $fechacorteanterior->FCO_Fecha)
                    ->get();//dd($fechacorteanterior);
            }
            return Datatables::of($docEvidencia)
                ->addColumn('archivo', function ($docEvidencia) {
                    /**
                     * Si el documento tiene una archivo guardado en el servidor
                     * Se obtiene el url y se coloca en un link, si no es asi es porque tiene
                     * una url entonces también se le asignar a un botón tipo link.
                     */
                    if (!$docEvidencia->archivo)
                    {
                        return '<a class="btn btn-success btn-xs" href="' . $docEvidencia->EVD_Link .
                            '"target="_blank" role="button">Enlace al documento</a>';
                    }
                    else
                    {
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
            $evidencia->EVD_Fecha_Subido =  Carbon::now()->format('Y-m-d');
            $evidencia->save();
        } else {
            $evidencia = new Evidencia;
            $evidencia->EVD_Nombre = $request->EVD_Nombre;
            $evidencia->EVD_Descripcion_General = $request->EVD_Descripcion_General;
            $evidencia->EVD_Link = $request->EVD_Link;
            $evidencia->FK_EVD_Actividad_Mejoramiento = $request->FK_EVD_Actividad_Mejoramiento;
            $evidencia->EVD_Fecha_Subido =  Carbon::now()->format('Y-m-d');
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

        return response(['msg' => 'La Evidencia ha sido modificado exitosamente.',
            'title' => 'Evidencia Modificada!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
