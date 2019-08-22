<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentoInstitucionalRequest;
use App\Models\Autoevaluacion\Archivo;
use App\Models\Autoevaluacion\DocumentoInstitucional;
use App\Models\Autoevaluacion\GrupoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;


class DocumentoInstitucionalController extends Controller
{

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_DOCUMENTOS_INSTITUCIONALES');
        $this->middleware(['permission:MODIFICAR_DOCUMENTOS_INSTITUCIONALES', 'permission:VER_DOCUMENTOS_INSTITUCIONALES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_DOCUMENTOS_INSTITUCIONALES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_DOCUMENTOS_INSTITUCIONALES', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $docInstitucional = DocumentoInstitucional::with('archivo', 'grupodocumento')
                ->get();
            return Datatables::of($docInstitucional)
                ->addColumn('archivo', function ($docInstitucional) {
                    /**
                     * Si el documento tiene una archivo guardado en el servidor
                     * Se obtiene el url y se coloca en un link, si no es asi es porque tiene
                     * una url entonces también se le asignar a un botón tipo link.
                     */
                    if (!$docInstitucional->archivo) {
                        return '<a class="btn btn-success btn-xs" href="' . $docInstitucional->link .
                            '"target="_blank" role="button">Enlace al documento</a>';
                    } else {

                        return '<a class="btn btn-success btn-xs" href="' . route('descargar') . '?archivo=' .
                            $docInstitucional->archivo->ruta .
                            '" target="_blank" role="button">' . $docInstitucional->archivo->ACV_Nombre . '</a>';


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
        $grupoDocumentos = GrupoDocumento::pluck('GRD_Nombre', 'PK_GRD_Id');
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.create', compact('grupoDocumentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentoInstitucionalRequest $request)
    {
        /**
         * Si la petición tenia un archivo incluido se guarda y se obtiene el
         * id del archivo guardado
         */
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $archivo = new Archivo;
            $archivo->ACV_Nombre = $file->getClientOriginalName();
            $archivo->ACV_Extension = $file->extension();
            $carpeta = GrupoDocumento::find($request->FK_DOI_GrupoDocumento);
            $nombreCarpeta = $carpeta->GRD_Nombre;
            $archivo->ruta = Storage::url($file->store('public/DocumentosInstitucionales/' . $nombreCarpeta));
            $archivo->save();

            $docInstitucional = new DocumentoInstitucional;
            $docInstitucional->DOI_Nombre = $request->DOI_Nombre;
            $docInstitucional->DOI_Descripcion = $request->DOI_Descripcion;
            $docInstitucional->link = $request->link;
            $docInstitucional->FK_DOI_Archivo = $archivo->PK_ACV_Id;
            $docInstitucional->FK_DOI_GrupoDocumento = $request->FK_DOI_GrupoDocumento;
            $docInstitucional->save();
        } else {
            DocumentoInstitucional::create($request->except('archivo'));
        }

        return response(['msg' => 'El documento ha sido almacenado exitosamente.',
            'title' => '¡Registro realizado exitosamente!'
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
        $grupoDocumentos = GrupoDocumento::pluck('GRD_Nombre', 'PK_GRD_Id');
        $documento = DocumentoInstitucional::findOrFail($id);
        $size = $documento->archivo ? filesize(public_path($documento->archivo->ruta)) : null;
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.edit', [
            'user' => $documento,
            'edit' => true,
        ], compact('grupoDocumentos', 'size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentoInstitucionalRequest $request, $id)
    {
        $borraArchivo = false;

        $documento = DocumentoInstitucional::findOrFail($id);

        /**
         * Si la peticion tenia un archivo incluido se guarda y se obtiene el
         * id del archivo guardado
         */

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();
            $carpeta = GrupoDocumento::find($request->FK_DOI_GrupoDocumento);
            $nombreCarpeta = $carpeta->GRD_Nombre;
            $url = Storage::url($archivo->store('public/DocumentosInstitucionales/' . $nombreCarpeta));

            /**
             * Si el documento y tenia un documento se elimina este y se guarda el nuevo,
             * si no es asi simplemente se guarda
             */
            if ($documento->archivo) {
                $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                Storage::delete($ruta);
                $archivos = Archivo::findOrfail($documento->FK_DOI_Archivo);
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

        if ($request->get('link') != null && $documento->archivo) {
            $documento->FK_DOI_Archivo = null;
            $borraArchivo = true;
            $ruta = $documento->archivo->ruta;
            $id = $documento->FK_DOI_Archivo;
        }

        $documento->fill($request->only([
            'DOI_Nombre',
            'DOI_Descripcion',
            'link',
        ]));

        if (isset($idArchivo)) {
            $documento->FK_DOI_Archivo = $idArchivo;
        }

        $documento->FK_DOI_GrupoDocumento = $request->FK_DOI_GrupoDocumento;
        $documento->update();

        /**
         * Se elimina el archivo al final debido a problemas de perdida de datos, esto ocurre
         * si la petición traía un link y el documento antes tenia un archivo guardado en el servidor
         */
        if ($borraArchivo) {
            Archivo::destroy($id);
        }

        return response(['msg' => 'El Documento ha sido modificado exitosamente.',
            'title' => 'Documento Institucional Modificado!'
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
        $documento = DocumentoInstitucional::findOrfail($id);
        if ($documento->archivo) {
            $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
            Storage::delete($ruta);
            $documento->archivo()->delete();
        } else {
            $documento->delete();
        }
        return response(['msg' => 'El Documento ha sido eliminado exitosamente.',
            'title' => '¡Registro Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

}