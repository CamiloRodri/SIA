<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoDocumentalRequest;
use App\Models\Autoevaluacion\TipoDocumento;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class tipoDocumentoController extends Controller
{
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */

    public function __construct()
    {
        $this->middleware('permission:ACCEDER_TIPO_DOCUMENTO')->except('show');
        $this->middleware(['permission:MODIFICAR_TIPO_DOCUMENTO', 'permission:VER_TIPO_DOCUMENTO'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_TIPO_DOCUMENTO', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_TIPO_DOCUMENTO', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.TipoDocumento.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $tipos = TipoDocumento::all();
            return Datatables::of($tipos)
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoDocumentalRequest $request)
    {
        TipoDocumento::create($request->except('_token'));
        return response([
            'msg' => 'Tipo de documento registrado correctamente.',
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoDocumentalRequest $request, $id)
    {
        $user = TipoDocumento::find($id);
        $user->fill($request->all());
        $user->save();
        return response([
            'msg' => 'El tipo de documento ha sido modificado exitosamente.',
            'title' => '¡Tipo de documento Modificado!'
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

        TipoDocumento::destroy($id);

        return response([
            'msg' => 'El tipo de documento ha sido eliminado exitosamente.',
            'title' => '¡Tipo de documento Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');


    }
}
