<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModificarTipoRespuestaRequest;
use App\Http\Requests\TipoRespuestaRequest;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\PonderacionRespuesta;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\TipoRespuesta;
use DataTables;
use Illuminate\Http\Request;

class TipoRespuestaController extends Controller
{
    /*
    Este controlador es responsable de manejar el tipo de respuestas para una pregunta 
    almacenada en el sistema que pueden ser aplicable a procesos de autoevaluacion 
    */

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_TIPO_RESPUESTAS')->except('show');
        $this->middleware(['permission:MODIFICAR_TIPO_RESPUESTAS', 'permission:VER_TIPO_RESPUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_TIPO_RESPUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_TIPO_RESPUESTAS', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $tipoRespuestas = TipoRespuesta::with('estado')
                ->get();
            return Datatables::of($tipoRespuestas)
                ->addColumn('estado', function ($tipoRespuestas) {
                    if (!$tipoRespuestas->estado) {
                        return '';
                    } elseif (!strcmp($tipoRespuestas->estado->ESD_Nombre, 'HABILITADO')) {
                        return "<span class='label label-sm label-success'>" . $tipoRespuestas->estado->ESD_Nombre . "</span>";
                    } else {
                        return "<span class='label label-sm label-danger'>" . $tipoRespuestas->estado->ESD_Nombre . "</span>";
                    }
                    return "<span class='label label-sm label-primary'>" . $tipoRespuestas->estado->ESD_Nombre . "</span>";
                })
                ->rawColumns(['estado'])
                ->make(true);
        }
    }

    public function create()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoRespuestaRequest $request)
    {
        $tipoRespuestas = new TipoRespuesta();
        $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion', 'TRP_CantidadRespuestas', 'TRP_Descripcion']));
        $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
        $tipoRespuestas->save();
        /**
         * Se obtiene la cantidad de respuestas digita por el usuario para asi buscar los campos creados
         * dinamicamente en la vista y poder almacenar las ponderaciones para cada respuesta.
         */
        for ($i = 1; $i <= $request->TRP_CantidadRespuestas; $i++) {
            $ponderacion = new PonderacionRespuesta();
            $ponderacion->PRT_Ponderacion = $request->get('Ponderacion_' . $i);
            $ponderacion->PRT_Rango = $i;
            $ponderacion->FK_PRT_TipoRespuestas = $tipoRespuestas->PK_TRP_Id;
            $ponderacion->save();
        }
        return response([
            'msg' => 'Tipo de respuesta registrada correctamente.',
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
        $respuesta = TipoRespuesta::findOrFail($id);
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $ponderaciones = PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $id)
            ->get();
        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.edit',
            compact('respuesta', 'estados', 'ponderaciones')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModificarTipoRespuestaRequest $request, $id)
    {
        $tipoRespuestas = TipoRespuesta::findOrFail($id);
        $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion', 'TRP_Descripcion']));
        $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
        $tipoRespuestas->update();
        /**
         * Se obtiene la cantidad de respuestas para el tipo de respuesta para asi poder modificar
         * los campos creados las ponderaciones para cada respuesta.
         */
        foreach (PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $id)->get() as $ponderacion) {
            $ponderacionRpt = PonderacionRespuesta::find($ponderacion->PK_PRT_Id);
            $ponderacionRpt->PRT_Ponderacion = $request->get($ponderacion->PK_PRT_Id);
            $ponderacionRpt->FK_PRT_TipoRespuestas = $id;
            $ponderacionRpt->save();
        }
        return response([
            'msg' => 'El tipo de respuesta ha sido modificado exitosamente.',
            'title' => 'Tipo de respuesta Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');

    }

    /**
     * Para que el proceso de eliminacion de un tipo de respuesta sea exitoso, el sistema
     * debe verificar si el tipo de respuesta esta relacionado a una pregunta perteneciente
     * a alguna encuesta vinculada a un proceso en fase de captura de datos, en el caso que se
     * cumpla esta condicion no se permitira eliminar el tipo de respuesta ya que esto afectaria
     * el correcto desarrollo del proceso de autoevaluacion en cuestion.
     */
    public function destroy($id)
    {
        $tipoRespuestas = TipoRespuesta::findOrFail($id);
        $preguntas = Pregunta::with('preguntas_encuesta.banco.encuestas')
            ->where('FK_PGT_TipoRespuesta', '=', $tipoRespuestas->PK_TRP_Id)
            ->get();
        $contador = 0;
        foreach ($preguntas as $pregunta) {
            foreach ($pregunta->preguntas_encuesta as $pregunta) {
                foreach ($pregunta->banco->encuestas as $encuesta) {
                    $proceso = Proceso::find($encuesta->FK_ECT_Proceso);
                    if ($proceso->FK_PCS_Fase == 4) $contador = 1;
                    break;
                }
                if ($contador == 1) break;
            }
            if ($contador == 1) break;
        }
        if ($contador == 0) {
            $tipoRespuestas->delete();
            return response([
                'msg' => 'El tipo de respuesta ha sido eliminado exitosamente.',
                'title' => '¡Tipo de respuesta Eliminado!'
            ], 200)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        } else {
            return response([
                'errors' => ['Existe una pregunta que hace parte de una encuesta en uso para un proceso que se encuentra en fase de captura de datos'],
                'title' => '¡Error!'
            ], 422)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
    }
}
