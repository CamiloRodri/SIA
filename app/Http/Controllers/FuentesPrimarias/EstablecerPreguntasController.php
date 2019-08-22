<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstablecerPreguntasRequest;
use App\Http\Requests\ModificarEstablecerPreguntasRequest;
use App\Models\Autoevaluacion\BancoEncuestas;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use DataTables;
use Illuminate\Http\Request;

class EstablecerPreguntasController extends Controller
{
    /**
     * Este controlador es responsable de manejar las preguntas que conforman las encuestas
     * almacenadas en el banco de encuestas y que pueden ser aplicables a procesos de autoevaluacion
     */

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_ESTABLECER_PREGUNTAS');
        $this->middleware(['permission:MODIFICAR_ESTABLECER_PREGUNTAS', 'permission:VER_ESTABLECER_PREGUNTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ESTABLECER_PREGUNTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ESTABLECER_PREGUNTAS', ['only' => ['destroy']]);
    }

    public function index($id)
    {
        /**
         * En una variable de sesion se almacena el id de la encuesta a la cual se le
         * estableceran las preguntas y asi poder ser instanciado en otras funciones.
         */
        session()->put('id_encuesta', $id);
        return view('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            /**
             * Se hace la peticion de todas las preguntas pertenecientes a la encuesta
             */
            $preguntas = PreguntaEncuesta::with('preguntas', 'grupos')
                ->with('preguntas.estado')
                ->with('preguntas.tipo')
                ->with('preguntas.caracteristica')
                ->where('FK_PEN_Banco_Encuestas', session()->get('id_encuesta'))
                ->get();
            return DataTables::of($preguntas)
                ->addColumn('estado', function ($preguntas) {
                    if (!$preguntas->preguntas->estado) {
                        return '';
                    } elseif (!strcmp($preguntas->preguntas->estado->ESD_Nombre, 'HABILITADO')) {
                        return "<span class='label label-sm label-success'>" . $preguntas->preguntas->estado->ESD_Nombre . "</span>";
                    } else {
                        return "<span class='label label-sm label-danger'>" . $preguntas->preguntas->estado->ESD_Nombre . "</span>";
                    }
                    return "<span class='label label-sm label-primary'>" . $preguntas->preguntas->estado->ESD_Nombre . "</span>";
                })
                ->rawColumns(['estado'])
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos!',
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
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $grupos = GrupoInteres::whereHas('estado', function ($query) {
            return $query->where('ESD_Valor', '=', '1');
        })->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
        return view('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.create', compact('lineamientos', 'grupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstablecerPreguntasRequest $request)
    {
        /**
         * La pregunta es almacenada y vinculada a la encuesta para cada grupo de interes seleccionado
         */
        foreach ($request->get('gruposInteres') as $grupo => $valor) {
            $preguntasEncuesta = new PreguntaEncuesta();
            $preguntasEncuesta->FK_PEN_Pregunta = $request->get('PK_PGT_Id');
            $preguntasEncuesta->FK_PEN_Banco_Encuestas = $request->get('PK_BEC_Id');
            $preguntasEncuesta->FK_PEN_GrupoInteres = $valor;
            $preguntasEncuesta->save();
        }
        return response(['msg' => 'Datos registrados correctamente.',
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
        $preguntas = PreguntaEncuesta::findOrFail($id);
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $grupos = GrupoInteres::whereHas('estado', function ($query) {
            return $query->where('ESD_Valor', '1');
        })->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
        /**
         * Se obtiene los factores que estan siendo afectados y tienen relacion con las preguntas
         */
        $factor = new Factor();
        $idFactor = $preguntas->preguntas->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id')[0];
        $factores = $factor->where('FK_FCT_Lineamiento', $idFactor)->get()->pluck('FCT_Nombre', 'PK_FCT_Id');
        /**
         * Se obtiene los caracteristicas que estan siendo apuntadas por las preguntas
         */
        $caracteristica = new Caracteristica();
        $idCaracteristica = $preguntas->preguntas->caracteristica->factor()->pluck('PK_FCT_Id')[0];
        $caracteristicas = $caracteristica->where('FK_CRT_Factor', $idCaracteristica)->get()->pluck('CRT_Nombre', 'PK_CRT_Id');
        /**
         * Se obtiene el cuerpo de la pregunta
         */
        $preguntaEncuesta = new Pregunta();
        $idPregunta = $preguntas->preguntas->caracteristica()->pluck('PK_CRT_Id')[0];
        $preguntasEncuesta = $preguntaEncuesta->where('FK_PGT_Caracteristica', $idPregunta)->get()->pluck('PGT_Texto', 'PK_PGT_Id');
        return view('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.edit', compact('lineamientos', 'factores', 'grupos', 'caracteristicas', 'preguntas', 'preguntasEncuesta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModificarEstablecerPreguntasRequest $request, $id)
    {
        $preguntasEncuesta = PreguntaEncuesta::find($id);
        $preguntasEncuesta->FK_PEN_Pregunta = $request->get('PK_PGT_Id');
        $preguntasEncuesta->FK_PEN_Banco_Encuestas = $request->get('PK_BEC_Id');
        $preguntasEncuesta->update();
        return response(['msg' => 'La pregunta se ha modificado correctamente.',
            'title' => '¡Pregunta Modificada!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Para que el proceso de eliminacion de una pregunta de una encuesta sea exitoso, el sistema
     * debe verificar si existe algun proceso en fase de captura de datos, en el caso que se cumpla
     * esta condicion no se permitira eliminar la pregunta de la encuesta ya que esto afectaria el
     * correcto desarrollo del proceso de autoevaluacion en cuestion.
     */
    public function destroy($id)
    {
        $preguntasEncuesta = PreguntaEncuesta::findOrFail($id);
        $encuestas = Encuesta::whereHas('proceso', function ($query) {
            return $query->where('FK_PCS_Fase', '=', '4');
        })
            ->where('FK_ECT_Banco_Encuestas', '=', BancoEncuestas::findOrFail($preguntasEncuesta->FK_PEN_Banco_Encuestas)->PK_BEC_Id)
            ->get();
        if ($encuestas->count() == 0) {
            $preguntasEncuesta->delete();
            return response(['msg' => 'La pregunta ha sido eliminada exitosamente de la encuesta.',
                'title' => 'Pregunta Eliminada!'
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
