<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\AspectosRequest;
use App\Models\Autoevaluacion\Aspecto;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Lineamiento;
use DataTables;
use Illuminate\Http\Request;

class AspectoController extends Controller
{
    /**
     * Instantiate a new controller instance.
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
        $this->middleware('permission:ACCEDER_ASPECTOS')->except('show');
        $this->middleware(['permission:MODIFICAR_ASPECTOS', 'permission:VER_ASPECTOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ASPECTOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ASPECTOS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Aspectos.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion llena el datatable de aspecto que esta ligado
     * a caracteristica y factor
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $aspectos = Aspecto::with('caracteristica.factor.lineamiento')->get();
            return DataTables::of($aspectos)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addColumn('nombre_factor', function ($aspecto) {
                    return $aspecto->caracteristica->factor->nombre_factor;
                })
                ->addColumn('nombre_caracteristica', function ($aspecto) {
                    return $aspecto->caracteristica->nombre_caracteristica;
                })
                ->addColumn('nombre_aspecto', function ($aspecto) {
                    return $aspecto->nombre_aspecto;
                })
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
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');

        return view('autoevaluacion.SuperAdministrador.Aspectos.create', compact('lineamientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea los aspectos
     */
    public function store(AspectosRequest $request)
    {
        $aspecto = new Aspecto();
        $aspecto->fill($request->only(['ASP_Nombre', 'ASP_Descripcion', 'ASP_Identificador']));
        $aspecto->FK_ASP_Caracteristica = $request->get('PK_CRT_Id');
        $aspecto->save();

        return response(['msg' => 'Aspecto registrado correctamente.',
            'title' => '¡Registro exitoso!',
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
        $aspectos = Aspecto::where('FK_ASP_Caracteristica', $id)->pluck('ASP_Nombre', 'PK_ASP_Id');
        return json_encode($aspectos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion trae cada id y nombre del correspondiente lineamiento, caracteristica, factor
     * y aspecto a modificar
     */
    public function edit($id)
    {
        $aspecto = Aspecto::findOrFail($id);
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');

        $factor = new Factor();
        $idFactor = $aspecto->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id')[0];
        $factores = $factor->where('FK_FCT_Lineamiento', $idFactor)->get()->pluck('nombre_factor', 'PK_FCT_Id');

        $caracteristica = new Caracteristica();
        $idCaracteristica = $aspecto->caracteristica->factor()->pluck('PK_FCT_Id')[0];
        $caracteristicas = $caracteristica->where('FK_CRT_Factor', $idCaracteristica)->get()->pluck('nombre_caracteristica', 'PK_CRT_Id');

        return view(
            'autoevaluacion.SuperAdministrador.Aspectos.edit',
            compact('aspecto', 'lineamientos', 'factores', 'caracteristicas')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion modifica los aspectos
     */
    public function update(AspectosRequest $request, $id)
    {
        $aspecto = Aspecto::find($id);
        $aspecto->fill($request->only(['ASP_Nombre', 'ASP_Descripcion', 'ASP_Identificador']));
        $aspecto->FK_ASP_Caracteristica = $request->get('PK_CRT_Id');

        $aspecto->update();

        return response(['msg' => 'El Aspecto ha sido modificado exitosamente.',
            'title' => '¡Usuario Modificado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion elimina los aspectos
     */
    public function destroy($id)
    {
        Aspecto::destroy($id);

        return response(['msg' => 'El aspectos ha sido eliminado exitosamente.',
            'title' => '¡Aspecto Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
