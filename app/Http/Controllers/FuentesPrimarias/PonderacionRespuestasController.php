<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\PonderacionRespuesta;
use DataTables;
use Illuminate\Http\Request;
use Session;

class PonderacionRespuestasController extends Controller
{
    /*
    Este controlador es responsable de mostrar las ponderaciones de las respuestas para las preguntas
    almacenadas en el banco de preguntas.
    */

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PONDERACION_RESPUESTAS');
        $this->middleware(['permission:MODIFICAR_PONDERACION_RESPUESTAS', 'permission:VER_PONDERACION_RESPUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PONDERACION_RESPUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PONDERACION_RESPUESTAS', ['only' => ['destroy']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * Se obtienen las ponderaciones para ser cargadas en selects utilizados en algunos formularios.
     */
    public function mostrarPonderaciones($id)
    {
        $ponderaciones = PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $id)
            ->get()
            ->pluck('PRT_Ponderacion', 'PK_PRT_Id')
            ->toArray();
        return json_encode($ponderaciones);
    }

}
