<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\FrenteEstrategico;
use App\Models\Autoevaluacion\Institucion;
use App\Http\Requests\FrenteEstrategicoRequest;
use Yajra\DataTables\DataTables;

class FrenteEstrategicoController extends Controller
{
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_FRENTE_ESTRATEGICO')->except('show');
        $this->middleware(['permission:MODIFICAR_FRENTE_ESTRATEGICO', 'permission:VER_FRENTE_ESTRATEGICO'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_FRENTE_ESTRATEGICO', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_FRENTE_ESTRATEGICO', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.FrentesEstrategicos.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $frente_estrategicio = FrenteEstrategico::all();
            return Datatables::of($frente_estrategicio)
                ->make(true);
            $institucion = Institucion::pluck('ITN_Nombre', 'PK_ITN_Id');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $frente_estrategicio = new FrenteEstrategico();
        $institucion = Institucion::pluck('ITN_Nombre', 'PK_ITN_Id');
        $frente_estrategicio->fill($request->only(['FES_Nombre']));
        $frente_estrategicio->fill($request->only(['FES_Descripcion']));
        $frente_estrategicio->fill($request->only(['FK_FES_Institucion']));
        //$frente_estrategicio->fill($request->only(['FK_FES_Institucion']));
        $frente_estrategicio->save();

        return response(['msg' => 'Frente estrategico registrado correctamente.',
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
        $frente_estrategicio = FrenteEstrategico::findOrFail($id);
        $frente_estrategicio->fill($request->all());
        $frente_estrategicio->FK_FES_Institucion = $request->get('FK_FES_Institucion');
        $frente_estrategicio->update();

        return response(['msg' => 'Frente estrategico modificado correctamente.',
            'title' => '¡Registro exitoso!',
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
        FrenteEstrategico::destroy($id);

        return response([
            'msg' => 'La Institución ha sido eliminada exitosamente.',
            'title' => 'Institución Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
