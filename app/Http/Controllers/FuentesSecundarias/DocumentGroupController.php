<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentGroupRequest;
use App\Models\Autoevaluacion\GrupoDocumento;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DocumentGroupController extends Controller
{
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_GRUPO_DOCUMENTOS')->except('show');
        $this->middleware(['permission:MODIFICAR_GRUPO_DOCUMENTOS', 'permission:VER_GRUPO_DOCUMENTOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_GRUPO_DOCUMENTOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_GRUPO_DOCUMENTOS', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.DocumentGroup.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $grupoDoc = GrupoDocumento::all();
            return Datatables::of($grupoDoc)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos mmmm!',
            'No se pudo completar tu solicitud.'
        );

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('autoevaluacion.SuperAdministrador.Users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentGroupRequest $request)
    {

        GrupoDocumento::create($request->except('_token'));
        return response(['msg' => 'Grupo de documentos almacenado correctamente.',
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
        return view('autoevaluacion.FuentesSecundarias.DocumentGroup.edit', [
            'grupoDocumento' => GrupoDocumento::findOrFail($id),
            'edit' => true
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentGroupRequest $request, $id)
    {
        $grupoDocumento = GrupoDocumento::find($id);
        $grupoDocumento->fill($request->all());
        $grupoDocumento->save();
        return response(['msg' => 'El grupo ha sido modificado exitosamente.',
            'title' => 'Grupo Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        GrupoDocumento::destroy($id);

        return response(['msg' => 'El Registro ha sido eliminado exitosamente.',
            'title' => 'Grupo Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');


    }
}
