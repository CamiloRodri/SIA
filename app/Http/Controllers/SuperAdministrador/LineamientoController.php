<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\LineamientosRequest;
use App\Jobs\ImportarLineamiento;
use App\Models\Autoevaluacion\Lineamiento;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LineamientoController extends Controller
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
        $this->middleware('permission:ACCEDER_LINEAMIENTOS');
        $this->middleware(['permission:MODIFICAR_LINEAMIENTOS', 'permission:VER_LINEAMIENTOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_LINEAMIENTOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_LINEAMIENTOS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Lineamientos.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion llena el datatable de todos los lineamientos
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $lineamiento = Lineamiento::all();
            return Datatables::of($lineamiento)
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
        return view('autoevaluacion.SuperAdministrador.Lineamientos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea nuevos lineamientos
     */
    public function store(LineamientosRequest $request)
    {
        $archivo = $request->file('archivo');
        $results = "";
        $id = Lineamiento::create($request->except('archivo'))->PK_LNM_Id;
        if ($archivo) {
            $urlTemporal = Storage::url($archivo->store('public'));
            ImportarLineamiento::dispatch($urlTemporal, $id);
        }
        return response(['msg' => 'Lineamiento registrado correctamente.',
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
        $lineamiento = Lineamiento::findOrFail($id);

        return view(
            'autoevaluacion.SuperAdministrador.Lineamientos.edit',
            compact('lineamiento')
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
     * Esta funcion modifica los lineamientos
     */
    public function update(LineamientosRequest $request, $id)
    {
        $lineamiento = Lineamiento::findOrFail($id);
        $lineamiento->update($request->all());

        return response(['msg' => 'El Lineamiento ha sido modificado exitosamente.',
            'title' => 'Lineamiento Modificado!',
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
     * Esta funcion elimina los lineamientos
     */
    public function destroy($id)
    {
        $lineamiento = Lineamiento::findOrFail($id);
        $lineamiento->delete();

        return response(['msg' => 'El Lineamiento ha sido eliminado exitosamente.',
            'title' => '¡Lineamiento Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
