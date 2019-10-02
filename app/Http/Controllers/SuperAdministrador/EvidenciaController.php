<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Evidencia;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Barryvdh\Debugbar;

class EvidenciaController extends Controller
{

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_EVIDENCIA')->except('show');
        $this->middleware(['permission:MODIFICAR_EVIDENCIA', 'permission:VER_EVIDENCIA'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_EVIDENCIA', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_EVIDENCIA', ['only' => ['destroy']]);
    }

    public function datos(Request $request, $id)
    {
        // \Debugbar::info($id);
        // if ($request->ajax() && $request->isMethod('GET')) {
            $evidencia = Evidencia::all()->where('FK_EVD_Actividad_Mejoramiento', $id);
            return Datatables::of($evidencia)
                ->make(true);
        // }
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $evidencia = Evidencia::all();
            return Datatables::of($evidencia)
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $actividad = ActividadesMejoramiento::find($id);
        return view('autoevaluacion.SuperAdministrador.Evidencias.index', compact('actividad'));
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
        $now = new \DateTime();
        $now->format('d-m-Y H:i:s');
        $evidencia = new Evidencia();
        $evidencia->fill($request->only(['EVD_Nombre']));
        $evidencia->fill($request->only(['EVD_Link']));
        $evidencia->EVD_Fecha_Subido =  Carbon::now();
        $evidencia->fill($request->only(['EVD_Descripcion_General']));
        $evidencia->fill($request->only(['FK_EVD_Actividad_Mejoramiento']));
        $evidencia->save();

        return response(['msg' => 'Ambito registrado correctamente.',
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
        $evidencia = Evidencia::find($id);
        $evidencia->fill($request->only(['EVD_Nombre']));
        $evidencia->fill($request->only(['EVD_Link']));
        $evidencia->EVD_Fecha_Subido =  Carbon::now();
        $evidencia->fill($request->only(['EVD_Descripcion_General']));
        $evidencia->fill($request->only(['FK_EVD_Actividad_Mejoramiento']));
        $evidencia->update();
        return response(['msg' => 'La Evidencia ha sido modificada exitosamente.',
            'title' => 'Evidencia modificada :*!',
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
        Evidencia::destroy($id);

        return response(['msg' => 'La Evidencia ha sido eliminada exitosamente.',
            'title' => '¡Evidencia Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
