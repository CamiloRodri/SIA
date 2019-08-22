<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Http\Requests\SolucionEncuestaRequest;
use App\Models\Autoevaluacion\CargoAdministrativo;
use App\Models\Autoevaluacion\DatosEncuesta;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\SolucionEncuesta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EncuestasController extends Controller
{
    /*
    Este controlador es responsable de manejar el proceso para almacenar las respuestas
    digitadas por un encuestado.
    */

    /**
     * La busqueda de los datos del proceso, la encuesta y el grupo de interes se hace por medio de slugs
     * almacenados en la bd para presentarle al usuario una url amigable y entendible.
     */
    public function index($slug_proceso)
    {
        $id_proceso = Proceso::where('PCS_Slug_Procesos', $slug_proceso)
            ->first()->PK_PCS_Id;
        $id_encuesta = Encuesta::where('FK_ECT_Proceso', $id_proceso)
            ->first()->FK_ECT_Banco_Encuestas;
        $grupos = GrupoInteres::whereHas('preguntas_encuesta', function ($query) use ($id_encuesta) {
            return $query->where('FK_PEN_Banco_Encuestas', '=', $id_encuesta);
        })
            ->where('FK_GIT_Estado', '=', '1')
            ->get()->pluck('GIT_Nombre', 'GIT_Slug');
        $cargos = CargoAdministrativo::all()->pluck('CAA_Cargo', 'CAA_Slug');
        return view('public.Encuestas.index', compact('grupos', 'cargos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug_proceso, $grupo, $cargo = null)
    {
        $id_proceso = Proceso::where('PCS_Slug_Procesos', $slug_proceso)
            ->first()->PK_PCS_Id;
        $id_grupo = GrupoInteres::where('GIT_Slug', $grupo)
            ->first()->PK_GIT_Id;
        $id_encuesta = Encuesta::where('FK_ECT_Proceso', $id_proceso)
            ->first()->FK_ECT_Banco_Encuestas;
        $preguntas = PreguntaEncuesta::whereHas('preguntas.respuestas', function ($query) {
            return $query->where('FK_PGT_Estado', '1');
        })
            ->with('preguntas.respuestas')
            ->where('FK_PEN_GrupoInteres', '=', $id_grupo)
            ->where('FK_PEN_Banco_Encuestas', '=', $id_encuesta)
            ->get();
        $datos = DatosEncuesta::whereHas('grupos', function ($query) use ($id_grupo) {
            return $query->where('PK_GIT_Id', '=', $id_grupo);
        })->get()->first();
        return view('public.Encuestas.encuestas', compact('preguntas', 'datos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolucionEncuestaRequest $request)
    {
        $id_proceso = Proceso::where('PCS_Slug_Procesos', $request->get('proceso'))
            ->first()->PK_PCS_Id;
        $id_encuesta = Encuesta::where('FK_ECT_Proceso', '=', $id_proceso)
            ->first();
        $id_cargo = CargoAdministrativo::where('CAA_Slug', '=', $request->get('cargo'))
                ->first()->PK_CAA_Id ?? null;
        $id_grupo = GrupoInteres::where('GIT_Slug', $request->get('grupo'))
            ->first()->PK_GIT_Id;
        $encuestados = new Encuestado();
        $encuestados->ECD_FechaSolucion = Carbon::now();
        $encuestados->FK_ECD_Encuesta = $id_encuesta->PK_ECT_Id;
        $encuestados->FK_ECD_GrupoInteres = $id_grupo;
        $encuestados->FK_ECD_CargoAdministrativo = $id_cargo;
        $encuestados->save();

        $preguntasR = PreguntaEncuesta::whereHas('preguntas.respuestas', function ($query) {
            return $query->where('FK_PGT_Estado', '1');
        })
            ->with('preguntas.respuestas')
            ->where('FK_PEN_GrupoInteres', '=', $id_grupo)
            ->where('FK_PEN_Banco_Encuestas', '=', $id_encuesta->FK_ECT_Banco_Encuestas)
            ->get();
        /**
         * Se hace la peticion de las preguntas que conforman la encuesta para obtener el id de cada
         * una de estas y asi obtener la respuesta digitada por el encuestado ya que el id del grupo
         * de radio buttons para las respuestas es la pk de la pregunta.
         */
        foreach ($preguntasR as $pregunta) {
            $respuestaUsuario = $request->get($pregunta->preguntas->PK_PGT_Id);
            $respuesta_encuesta = new SolucionEncuesta();
            $respuesta_encuesta->FK_SEC_Respuesta = $respuestaUsuario;
            $respuesta_encuesta->FK_SEC_Encuestado = $encuestados->PK_ECD_Id;
            $respuesta_encuesta->save();
        }
        return response(['msg' => 'Proceso finalizado correctamente.',
            'title' => '¡Gracias por su contribución!'
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
