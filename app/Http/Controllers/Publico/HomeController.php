<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Encuesta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Se deben mostrar aquellos procesos que se encuentran en fase de captura de datos.
     */
    public function index()
    {
        $fecha = Carbon::now()->toDateString();
        $encuestas = Encuesta::whereHas('proceso.fase', function ($query) {
            return $query->where('FSS_Nombre', '=', 'captura de datos');
        })
            ->with('proceso.programa.sede')
            ->where('ECT_FechaPublicacion', '<=', $fecha)
            ->where('ECT_FechaFinalizacion', '>=', $fecha)
            ->where('FK_ECT_Estado', '=', '1')
            ->get();
        return view('public.dashboard.index', compact('encuestas'));
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
        //
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
