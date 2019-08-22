<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DependenceRequest;
use App\Models\Autoevaluacion\Dependencia;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class DependenciaController extends Controller
{
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_DEPENDENCIAS')->except('show');
        $this->middleware(['permission:MODIFICAR_DEPENDENCIAS', 'permission:VER_DEPENDENCIAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_DEPENDENCIAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_DEPENDENCIAS', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.Dependence.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $dependencias = Dependencia::all();
            return Datatables::of($dependencias)
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DependenceRequest $request)
    {

        Dependencia::create($request->except('_token'));
        return response(['msg' => 'Dependencia registrada correctamente.',
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
        return view('autoevaluacion.FuentesSecundarias.Dependence.edit', [
            'dependencia' => Dependencia::findOrFail($id),
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
    public function update(DependenceRequest $request, $id)
    {
        $dependencia = Dependencia::find($id);
        $dependencia->fill($request->all());
        $dependencia->save();
        return response(['msg' => 'La dependencia ha sido modificada exitosamente.',
            'title' => '¡Dependencia Modificada!'
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

        Dependencia::destroy($id);

        return response(['msg' => 'El Registro ha sido eliminado exitosamente.',
            'title' => '¡Dependencia Eliminada!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');


    }
}

