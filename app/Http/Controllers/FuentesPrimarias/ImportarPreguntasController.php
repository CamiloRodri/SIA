<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportarPreguntasRequest;
use App\Jobs\ImportarPreguntas;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ImportarPreguntasController extends Controller
{
    /*
    Este controlador es responsable de manejar el proceso para importar
    tipo de respuestas, ponderacion, respuestas y preguntas por medio de un archivo de excel
    */

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crear
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_IMPORTAR_PREGUNTAS');
        $this->middleware('permission:IMPORTAR_PREGUNTAS', ['only' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('autoevaluacion.FuentesPrimarias.Preguntas.importar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportarPreguntasRequest $request)
    {
        $archivo = $request->file('archivo');
        $results = "";
        if ($archivo) {
            $urlTemporal = Storage::url($archivo->store('public'));
            ImportarPreguntas::dispatch($urlTemporal, session()->get('id_proceso'));
        }
        return response(['msg' => 'Preguntas registradas correctamente.',
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
