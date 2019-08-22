<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModificarPreguntasRequest;
use App\Http\Requests\PreguntasRequest;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\PonderacionRespuesta;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\SolucionEncuesta;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Autoevaluacion\TipoRespuesta;
use DataTables;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    /*
    Este controlador es responsable de manejar el banco de preguntas 
    almacenadas en el sistema que pueden ser establecidas en una encuesta para ser aplicada en un proceso
    de autoevaluacion. 
    */

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PREGUNTAS');
        $this->middleware(['permission:MODIFICAR_PREGUNTAS', 'permission:VER_PREGUNTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PREGUNTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PREGUNTAS', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.Preguntas.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            /**
             * Se obtienen todas las preguntas y a que caracteristica, factor y lineamiento pertenecen
             */
            $preguntas = Pregunta::with('estado', 'tipo', 'caracteristica', 'caracteristica.factor.lineamiento')->get();
            return DataTables::of($preguntas)
                ->addColumn('estado', function ($preguntas) {
                    if (!$preguntas->estado) {
                        return '';
                    } elseif (!strcmp($preguntas->estado->ESD_Nombre, 'HABILITADO')) {
                        return "<span class='label label-sm label-success'>" . $preguntas->estado->ESD_Nombre . "</span>";
                    } else {
                        return "<span class='label label-sm label-danger'>" . $preguntas->estado->ESD_Nombre . "</span>";
                    }
                    return "<span class='label label-sm label-primary'>" . $preguntas->estado->ESD_Nombre . "</span>";
                })
                ->addColumn('nombre_caracteristica', function ($preguntas) {
                    return $preguntas->caracteristica->nombre_caracteristica;
                })
                ->rawColumns(['estado'])
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
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
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $tipos = TipoRespuesta::whereHas('estado', function ($query) {
            return $query->where('ESD_Valor', '1');
        })->get()
            ->pluck('TRP_CantidadRespuestas', 'PK_TRP_Id');
        return view('autoevaluacion.FuentesPrimarias.Preguntas.create', compact('estados', 'lineamientos', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PreguntasRequest $request)
    {
        $pregunta = new Pregunta();
        $pregunta->fill($request->only(['PGT_Texto']));
        $pregunta->FK_PGT_Estado = $request->get('PK_ESD_Id');
        $pregunta->FK_PGT_TipoRespuesta = $request->get('PK_TRP_Id');
        $pregunta->FK_PGT_Caracteristica = $request->get('PK_CRT_Id');
        $pregunta->save();
        /**
         * Se obtiene la cantidad de respuestas de la preguntas para poder almacenar cada respuesta digitada
         */
        $tipos = TipoRespuesta::select('TRP_CantidadRespuestas')
            ->where('PK_TRP_Id', $request->get('PK_TRP_Id'))
            ->first();
        /**
         * Sabiendo la cantidad de respuestas, se buscan los campos creados dinamicamente en la vista
         * para digitar la totalidad de las respuestas y asi poder ser almacenadas en la base de datos
         */
        for ($i = 1; $i <= $tipos->TRP_CantidadRespuestas; $i++) {
            $respuestas = new RespuestaPregunta();
            $respuestas->RPG_Texto = $request->get('Respuesta_' . $i);
            $respuestas->FK_RPG_Pregunta = $pregunta->PK_PGT_Id;
            $respuestas->FK_RPG_PonderacionRespuesta = $request->get('Ponderacion_' . $i);
            $respuestas->save();
        }
        return response(['msg' => 'Pregunta registrada correctamente.',
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
        $pregunta = Pregunta::where('FK_PGT_Caracteristica', $id)->pluck('PGT_Texto', 'PK_PGT_Id');
        return json_encode($pregunta);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        /**
         * Se obtiene todas las respuestas posibles para la pregunta
         */
        $respuestas = RespuestaPregunta::where('FK_RPG_Pregunta', $id)->get();
        /**
         * Se obtiene las ponderaciones de cada posible respuesta para la pregunta
         */
        $ponderaciones = PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $pregunta->FK_PGT_TipoRespuesta)->get()
            ->pluck('PRT_Ponderacion', 'PK_PRT_Id');
        /**
         * Se obtiene los factores que estan siendo afectados y tienen relacion con las preguntas
         */
        $factor = new Factor();
        $idFactor = $pregunta->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id')[0];
        $factores = $factor->where('FK_FCT_Lineamiento', $idFactor)->get()->pluck('nombre_factor', 'PK_FCT_Id');
        /**
         * Se obtiene los caracteristicas que estan siendo apuntadas por las preguntas
         */
        $caracteristica = new Caracteristica();
        $idCaracteristica = $pregunta->caracteristica->factor()->pluck('PK_FCT_Id')[0];
        $caracteristicas = $caracteristica->where('FK_CRT_Factor', $idCaracteristica)->get()->pluck('nombre_caracteristica', 'PK_CRT_Id');
        
        $uso = SolucionEncuesta::whereHas('respuestas.pregunta', function ($query) use($id){
            return $query->where('PK_PGT_Id', '=', $id);
        })->get()->count();
        
        return view('autoevaluacion.FuentesPrimarias.Preguntas.edit',
            compact('pregunta', 'estados', 'factores', 'caracteristicas', 'respuestas', 'lineamientos', 'ponderaciones','uso')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModificarPreguntasRequest $request, $id)
    {
        $pregunta = Pregunta::find($id);
        $pregunta->fill($request->only(['PGT_Texto']));
        $pregunta->FK_PGT_Estado = $request->get('PK_ESD_Id');
        $pregunta->FK_PGT_Caracteristica = $request->get('PK_CRT_Id');
        $pregunta->update();
        $respuestas = RespuestaPregunta::where('FK_RPG_Pregunta', $id)->get();
        foreach ($respuestas as $index => $respuesta) {
            $rpta = RespuestaPregunta::find($respuesta->PK_RPG_Id);
            $rpta->RPG_Texto = $request->get($respuesta->PK_RPG_Id);
            $rpta->FK_RPG_Pregunta = $id;
            $rpta->FK_RPG_PonderacionRespuesta = $request->ponderaciones[$index];
            $rpta->update();
        }
        return response(['msg' => 'La pregunta ha sido modificada exitosamente.',
            'title' => '¡Pregunta Modificada!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Para que el proceso de eliminacion de una pregunta sea exitoso, el sistema
     * debe verificar si la pregunta pertenece a alguna encuesta vinculada a un proceso en fase de
     * captura de datos, en el caso que se cumpla esta condicion no se permitira eliminar la pregunta
     * ya que esto afectaria el correcto desarrollo del proceso de autoevaluacion en cuestion.
     */
    public function destroy($id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $preguntasEncuesta = PreguntaEncuesta::with('banco.encuestas')
            ->where('FK_PEN_Pregunta', '=', $pregunta->PK_PGT_Id)
            ->get();
        $contador = 0;
        foreach ($preguntasEncuesta as $preguntaEncuesta) {
            foreach ($preguntaEncuesta->banco->encuestas as $encuesta) {
                $proceso = Proceso::find($encuesta->FK_ECT_Proceso);
                if ($proceso->FK_PCS_Fase == 4) $contador = 1;
                break;
            }
            if ($contador == 1) break;
        }
        if ($contador == 0) {
            $pregunta->delete();
            return response(['msg' => 'La pregunta ha sido eliminada exitosamente.',
                'title' => '¡Pregunta Eliminada!'
            ], 200)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        } else {
            return response([
                'errors' => ['La pregunta hace parte de una encuesta en uso para un proceso que se encuentra en fase de captura de datos'],
                'title' => '¡Error!'
            ], 422)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
    }
}
