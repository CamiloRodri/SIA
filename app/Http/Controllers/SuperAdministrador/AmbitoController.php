<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\AmbitoResponsabilidad;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class AmbitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:ACCEDER_AMBITOS')->except('show');
        $this->middleware(['permission:MODIFICAR_AMBITOS', 'permission:VER_AMBITOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_AMBITOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_AMBITOS', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
        return view('autoevaluacion.SuperAdministrador.Ambito.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $ambito = AmbitoResponsabilidad::all();
            return Datatables::of($ambito)
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
    public function store(Request $request)
    {
        $ambito = new AmbitoResponsabilidad();
        $ambito->fill($request->only(['AMB_Nombre']));
        $ambito->save();

        return response(['msg' => 'Ambito registrado correctamente.',
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ambito = AmbitoResponsabilidad::find($id);
        $ambito->fill($request->only(['AMB_Nombre']));
        $ambito->update();
        return response(['msg' => 'El Ambito ha sido modificado exitosamente.',
            'title' => '¡Ambito modificado :*!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
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
        AmbitoResponsabilidad::destroy($id);

        return response(['msg' => 'El Ambito ha sido eliminado exitosamente.',
            'title' => '¡Ambito Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
