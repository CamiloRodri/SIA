<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\SedesRequest;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Sede;
use DataTables;
use Illuminate\Http\Request;

class SedeController extends Controller
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
        $this->middleware('permission:ACCEDER_SEDES');
        $this->middleware(['permission:MODIFICAR_SEDES', 'permission:VER_SEDES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_SEDES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_SEDES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.SuperAdministrador.Sedes.index', compact('estados'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista en el datatable todas las sedes
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $sedes = Sede::with('estado')->get();
            return Datatables::of($sedes)
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea las sedes
     */
    public function store(SedesRequest $request)
    {
        $sede = new Sede();
        $sede->fill($request->only(['SDS_Nombre', 'SDS_Descripcion']));
        $sede->FK_SDS_Estado = $request->get('PK_ESD_Id');
        $sede->save();

        return response([
            'msg' => 'Sede registrada correctamente.',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion modifica las sedes
     */
    public function update(SedesRequest $request, $id)
    {
        $sede = Sede::findOrFail($id);
        $sede->fill($request->only(['SDS_Nombre', 'SDS_Descripcion']));
        $sede->FK_SDS_Estado = $request->get('PK_ESD_Id');
        $sede->update();
        return response([
            'msg' => 'La sede ha sido modificada exitosamente.',
            'title' => 'Sede Modificada!',
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
     * Esta funcion elimina las sedes
     */
    public function destroy($id)
    {
        $sede = Sede::findOrFail($id);
        $sede->delete();

        return response([
            'msg' => 'La sede ha sido eliminada exitosamente.',
            'title' => '¡Sede Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
