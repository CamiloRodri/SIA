<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\GruposInteresRequest;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\GrupoInteres;
use DataTables;
use Illuminate\Http\Request;

class GruposInteresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_GRUPOS_INTERES');
        $this->middleware(['permission:MODIFICAR_GRUPOS_INTERES', 'permission:VER_GRUPOS_INTERES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_GRUPOS_INTERES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_GRUPOS_INTERES', ['only' => ['destroy']]);
    }

    public function index()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.SuperAdministrador.GruposInteres.index', compact('estados'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion llena el datatable de todos los grupos de interes
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $grupoInteres = GrupoInteres::with('estado')->get();
            return Datatables::of($grupoInteres)
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea los grupos de interes
     */
    public function store(GruposInteresRequest $request)
    {
        $grupoInteres = new GrupoInteres();
        $grupoInteres->fill($request->only(['GIT_Nombre']));
        $grupoInteres->FK_GIT_Estado = $request->get('PK_ESD_Id');
        $nombres = explode(' ', strtolower($request->get('GIT_Nombre')));
        $slug = "";
        foreach ($nombres as $nombre) {
            $slug = $slug . '_' . $nombre;
        }

        $grupoInteres->GIT_Slug = $slug;
        $grupoInteres->FK_GIT_Estado = $request->get('PK_ESD_Id');
        $grupoInteres->save();
        return response([
            'msg' => 'Grupo de interes registrado correctamente.',
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
    /**
     * Esta funcion modifica los grupos de interes
     */
    public function update(GruposInteresRequest $request, $id)
    {
        $grupoInteres = GrupoInteres::findOrFail($id);
        $grupoInteres->fill($request->only(['GIT_Nombre']));
        $grupoInteres->FK_GIT_Estado = $request->get('PK_ESD_Id');
        $nombres = explode(' ', strtolower($request->get('GIT_Nombre')));
        $slug = "";
        foreach ($nombres as $nombre) {
            $slug = $slug . '_' . $nombre;
        }

        $grupoInteres->GIT_Slug = $slug;
        $grupoInteres->update();
        return response([
            'msg' => 'El grupo de interes ha sido modificado exitosamente.',
            'title' => 'Grupo de Interes Modificado!',
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
     * Esta funcion elimina los grupos de interes
     */
    public function destroy($id)
    {
        $grupoInteres = GrupoInteres::findOrFail($id);
        $grupoInteres->delete();
        return response([
            'msg' => 'El grupo de interes ha sido eliminado exitosamente.',
            'title' => '¡Grupo de Interes Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
