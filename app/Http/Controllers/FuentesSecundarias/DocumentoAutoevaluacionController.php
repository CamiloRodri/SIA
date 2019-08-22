<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentosAutoevaluacionRequest;
use App\Models\Autoevaluacion\Archivo;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Dependencia;
use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\TipoDocumento;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoAutoevaluacionController extends Controller
{

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_DOCUMENTOS_AUTOEVALUACION');
        $this->middleware(['permission:MODIFICAR_DOCUMENTOS_AUTOEVALUACION', 'permission:VER_DOCUMENTOS_AUTOEVALUACION'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_DOCUMENTOS_AUTOEVALUACION', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_DOCUMENTOS_AUTOEVALUACION', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            /**
             * Obtiene todos los documentos que tengan archivo, dependencia, proceso
             */
            $documentosAutoevaluacion = DocumentoAutoevaluacion::with('indicadorDocumental.caracteristica.factor')
                ->with('archivo')
                ->with(['tipoDocumento' => function ($query) {
                    return $query->select('PK_TDO_Id', 'TDO_Nombre');
                }])
                ->with(['dependencia' => function ($query) {
                    return $query->select('PK_DPC_Id', 'DPC_Nombre');
                }])
                ->where('FK_DOA_Proceso', '=', session()->get('id_proceso'))
                ->get();

            return DataTables::of($documentosAutoevaluacion)
                ->addColumn('file', function ($documentoAutoevaluacion) {
                    /**
                     * Si el documento tiene una archivo guardado en el servidor
                     * Se obtiene el url y se coloca en un link, si no es asi es porque tiene
                     * una url entonces también se le asignar a un botón tipo link.
                     */
                    if (!$documentoAutoevaluacion->archivo) {
                        return '<a class="btn btn-success btn-xs" href="' . $documentoAutoevaluacion->DOA_Link .
                            '"target="_blank" role="button">Descargar</a>';
                    } else {

                        return '<a class="btn btn-success btn-xs" href="' . route('descargar') . '?archivo=' .
                            $documentoAutoevaluacion->archivo->ruta .
                            '" target="_blank" role="button">Descargar</a>';
                    }
                })
                ->addColumn('nombre', function ($documentoAutoevaluacion) {
                    /**
                     * Se agrega el nombre original del archivo si no tiene es porque
                     * tiene un link, simplemente se le coloca link para identificar.
                     */
                    if ($documentoAutoevaluacion->archivo) {
                        return $documentoAutoevaluacion->archivo->ACV_Nombre;
                    } else {
                        return 'Link';
                    }
                })
                ->addColumn('nombre_factor', function ($documentoAutoevaluacion) {
                    return $documentoAutoevaluacion->indicadorDocumental->caracteristica->factor->nombre_factor;
                })
                ->addColumn('nombre_caracteristica', function ($documentoAutoevaluacion) {
                    return $documentoAutoevaluacion->indicadorDocumental->caracteristica->nombre_caracteristica;
                })
                ->addColumn('nombre_indicador', function ($documentoAutoevaluacion) {
                    return $documentoAutoevaluacion->indicadorDocumental->nombre_indicador;
                })
                ->rawColumns(['file'])
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
        /**
         * Se obtiene el lineamiento del proceso que tiene seleccionado
         * sino tiene un proceso selecionado se deja nulo el idLineamiento
         */
        $idLineamiento = Proceso::find(session()->get('id_proceso'))->FK_PCS_Lineamiento ?? null;

        /**
         * Se obtiene los factores que tenga características y que estas características
         * también tengan relacionados indicadores
         */
        $factores = Factor::has('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $idLineamiento)
            ->where('FK_FCT_estado', '=', '1')
            ->get()
            ->pluck('nombre_factor', 'PK_FCT_Id');
        $dependencias = Dependencia::pluck('DPC_Nombre', 'PK_DPC_Id');
        $tipoDocumentos = TipoDocumento::pluck('TDO_Nombre', 'PK_TDO_Id');

        return view('autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion.create',
            compact('factores', 'dependencias', 'tipoDocumentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentosAutoevaluacionRequest $request)
    {
        /**
         * Si la petición tenia un archivo incluido se guarda y se obtiene el
         * id del archivo guardado
         */
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $archivo->getClientOriginalExtension();
            $url = Storage::url($archivo->store('public/documentosAutoevaluacion'));

            $archivos = new Archivo();
            $archivos->ACV_Nombre = $nombre;
            $archivos->ACV_Extension = $extension;
            $archivos->ruta = $url;
            $archivos->save();

            $idArchivo = $archivos->PK_ACV_Id;
        }

        $documentoAuto = new DocumentoAutoevaluacion();
        $documentoAuto->fill($request->only(['IDO_Nombre',
            'DOA_Numero',
            'DOA_Anio',
            'DOA_Link',
            'DOA_DescripcionGeneral',
            'DOA_ContenidoEspecifico',
            'DOA_ContenidoAdicional',
            'DOA_Observaciones']));
        /**
         * Si fue guardado un archivo si no se deja nulo el id del archivo
         */
        $documentoAuto->FK_DOA_Archivo = isset($idArchivo) ? $idArchivo : null;
        $documentoAuto->FK_DOA_IndicadorDocumental = $request->get('PK_IDO_Id');
        $documentoAuto->FK_DOA_TipoDocumento = $request->get('PK_TDO_Id');
        $documentoAuto->FK_DOA_Dependencia = $request->get('PK_DPC_Id');
        $documentoAuto->FK_DOA_Proceso = session()->get('id_proceso');
        $documentoAuto->save();

        return response(['msg' => 'El documento se ha registrado correctamente.',
            'title' => '¡Registro exitoso!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
    public function edit($id)
    {
        $documento = DocumentoAutoevaluacion::findOrFail($id);
        /**
         * Se utiliza la Gate autorizar para verificar si el usuario tiene permisos
         * de actualizar este documento, si no es asi lo redirige al home
         */
        $this->authorize('autorizar', $documento->FK_DOA_Proceso);

        /**
         * Se obtiene los factores que tenga características y que estas características
         * también tengan relacionados indicadores
         */
        $factores = Factor::has('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $documento->proceso->FK_PCS_Lineamiento)
            ->where('FK_FCT_estado', '=', '1')
            ->get()
            ->pluck('FCT_Nombre', 'PK_FCT_Id');
        /**
         * Se obtienen las características que tenga indicadores relacionados
         */

        $caracteristicas = Caracteristica::has('indicadores_documentales')
            ->where('FK_CRT_Factor', '=', $documento->indicadorDocumental->caracteristica->FK_CRT_Factor)
            ->where('FK_CRT_estado', '=', '1')
            ->get()
            ->pluck('CRT_Nombre', 'PK_CRT_Id');

        /**
         * Se obtienen los indicadores que tenga la caracteristica previamente seleccionada
         */
        $indicadores = IndicadorDocumental::where('FK_IDO_Caracteristica', '=', $documento->indicadorDocumental->FK_IDO_Caracteristica)
            ->pluck('IDO_Nombre', 'PK_IDO_Id');
        $dependencias = Dependencia::pluck('DPC_Nombre', 'PK_DPC_Id');
        $tipoDocumentos = TipoDocumento::pluck('TDO_Nombre', 'PK_TDO_Id');
        $size = $documento->archivo ? filesize(public_path($documento->archivo->ruta)) : null;

        return view(
            'autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion.edit',
            compact('documento', 'factores', 'caracteristicas', 'indicadores', 'dependencias', 'tipoDocumentos', 'size')
        );
    }

    public function evaluar($id_documento)
    {
        $documento = DocumentoAutoevaluacion::where('PK_DOA_Id', '=', $id_documento)
            ->with(['archivo', 'indicadorDocumental', 'tipoDocumento', 'dependencia'])
            ->get();
        return view('autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion.evaluar', 
        compact('documento'));
    }
    public function evaluarFormulario(Request $request, $id_documento)
    {
        $documento = DocumentoAutoevaluacion::findOrFail($id_documento);
        $documento->DOA_Observaciones = $request->get('DOA_Observaciones');
        $documento->update();
        return response([
            'msg' => 'El Indicador documental ha sido modificado exitosamente.',
            'title' => 'Indicador Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentosAutoevaluacionRequest $request, $id)
    {
        $borraArchivo = false;

        $documento = DocumentoAutoevaluacion::findOrFail($id);

        /**
         * Se utiliza la Gate autorizar para verificar si el usuario tiene permisos
         * de actualizar este documento, si no es asi lo redirige al home
         */
        $this->authorize('autorizar', $documento->FK_DOA_Proceso);

        /**
         * Si la peticion tenia un archivo incluido se guarda y se obtiene el
         * id del archivo guardado
         */
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $archivo->getClientOriginalExtension();
            $url = Storage::url($archivo->store('public/documentosAutoevaluacion'));

            /**
             * Si el documento y tenia un documento se elimina este y se guarda el nuevo,
             * si no es asi simplemente se guarda
             */
            if ($documento->archivo) {
                $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                Storage::delete($ruta);
                $archivos = Archivo::findOrfail($documento->FK_DOA_Archivo);
                $archivos->ACV_Nombre = $nombre;
                $archivos->ACV_Extension = $extension;
                $archivos->ruta = $url;
                $archivos->update();
                $idArchivo = $archivos->PK_ACV_Id;
            } else {
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
        if ($request->get('DOA_Link') != null && $documento->archivo) {
            $documento->FK_DOA_Archivo = null;
            $borraArchivo = true;
            $ruta = $documento->archivo->ruta;
            $id = $documento->FK_DOA_Archivo;
        }

        $documento->fill($request->only([
            'IDO_Nombre',
            'DOA_Numero',
            'DOA_Anio',
            'DOA_Link',
            'DOA_DescripcionGeneral',
            'DOA_ContenidoEspecifico',
            'DOA_ContenidoAdicional',
            'DOA_Observaciones'
        ]));

        if (isset($idArchivo)) {
            $documento->FK_DOA_Archivo = $idArchivo;
        }


        $documento->FK_DOA_IndicadorDocumental = $request->get('PK_IDO_Id');
        $documento->FK_DOA_TipoDocumento = $request->get('PK_TDO_Id');
        $documento->FK_DOA_Dependencia = $request->get('PK_DPC_Id');
        $documento->update();
        /**
         * Se elimina el archivo al final debido a problemas de perdida de datos, esto ocurre
         * si la petición traía un link y el documento antes tenia un archivo guardado en el servidor
         */
        if ($borraArchivo) {
            Archivo::destroy($id);
        }


        return response(['msg' => 'El Indicador documental ha sido modificado exitosamente.',
            'title' => 'Indicador Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
        $documento = DocumentoAutoevaluacion::findOrfail($id);

        /**
         * Se utiliza la Gate autorizar para verificar si el usuario tiene permisos
         * de actualizar este documento, si no es asi lo redirige al home
         */
        $this->authorize('autorizar', $documento->FK_DOA_Proceso);
        $proceso = Proceso::find($documento->FK_DOA_Proceso);

        /**
         * Si el proceso se encuentra en fase de captura de datos se puede eliminar si no es asi
         * no se permite
         */
        if ($proceso->FK_PCS_Fase == 4) {
            if ($documento->archivo) {
                $documento->archivo()->delete();
            }
            $documento->delete();
            return response([
                'msg' => 'El documento ha sido eliminado exitosamente.',
                'title' => 'Documento Eliminado!'
            ], 200)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
        return response([
            'errors' => ['El proceso se debe encontrar en fase de captura de datos para poder eliminar documentos.'],
            'title' => '¡Error!'
        ], 422)// 422 Status Code: Standard response for error HTTP request
        ->header('Content-Type', 'application/json');


    }

    /**
     * Función utilizada para poblar select que requieran las características
     * que contenga o estén relacionadas con indicadores documentales
     *
     * @param int $id
     * @return json
     */
    public function obtenerCaracteristicas($id)
    {
        $caracteristicas = Caracteristica::has('indicadores_documentales')
            ->where('FK_CRT_Factor', '=', $id)
            ->where('FK_CRT_estado', '=', '1')
            ->get()
            ->pluck('nombre_caracteristica', 'PK_CRT_Id');
        return json_encode($caracteristicas);
    }

    
}
