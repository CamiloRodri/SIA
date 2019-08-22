<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Autoevaluacion\SolucionEncuesta;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReportesEncuestasController extends Controller
{
    /*
    Este controlador es responsable de manejar los reportes de fuentes primarias.
    */

    public function index()
    {
        $grupos = GrupoInteres::where('FK_GIT_Estado', '=', '1')
            ->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
        $idLineamiento = Proceso::find(session()->get('id_proceso'))->FK_PCS_Lineamiento ?? null;
        $factores = Factor::where('FK_FCT_Lineamiento', '=', $idLineamiento)
            ->get()->pluck('nombre_factor', 'PK_FCT_Id');
        return view('autoevaluacion.FuentesPrimarias.Reportes.index', compact('grupos', 'factores'));
    }

    public function obtenerDatos(Request $request)
    {
        //cantidad de encuestados
        $encuesta = Encuesta::where('FK_ECT_Proceso', '=', session()->get('id_proceso'))->first();
        $encuestados = Encuestado::with('grupos')
            ->where('FK_ECD_Encuesta', '=', $encuesta->PK_ECT_Id ?? null)
            ->selectRaw('*, COUNT(FK_ECD_GrupoInteres) as cantidad')
            ->groupby('FK_ECD_GrupoInteres')
            ->get();
        $labelsEncuestado = [];
        $dataEncuestado = [];
        foreach ($encuestados as $encuestado) {
            array_push($labelsEncuestado, $encuestado->grupos->GIT_Nombre);
            array_push($dataEncuestado, $encuestado->cantidad);
        }

        //valorizacion de las caraCaracteristica = [];
        $labelsCaracteristica = [];
        $dataCaracteristicas = [];
        $dataFactor = [];

        $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados.encuesta', function ($query) {
            return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
        })
            ->where('FK_CRT_Factor', '=', '1')
            ->groupby('PK_CRT_Id')
            ->get();

        foreach ($caracteristicas as $caracteristica) {
            array_push($labelsCaracteristica, $caracteristica->CRT_Nombre);
            $soluciones = SolucionEncuesta::whereHas('encuestados.encuesta', function ($query) {
                return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
            })
                ->whereHas('respuestas.pregunta.caracteristica', function ($query) use ($caracteristica) {
                    return $query->where('PK_CRT_Id', '=', $caracteristica->PK_CRT_Id);
                })
                ->with('respuestas.ponderacion')
                ->get();
            $totalPonderacion = 0;
            $prueba = $soluciones->count();
            foreach ($soluciones as $solucion) {
                $totalPonderacion = $totalPonderacion + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
            }
            $prueba = $totalPonderacion / $prueba;
            array_push($dataCaracteristicas, $prueba);
        }
        $datos = [];
        $datos['labels_encuestado'] = $labelsEncuestado;
        $datos['data_encuestado'] = array($dataEncuestado);
        $datos['labels_caracteristicas'] = $labelsCaracteristica;
        $datos['data_caracteristicas'] = array($dataCaracteristicas);
        $datos['data_factor'] = array($dataFactor);
        return json_encode($datos);
    }

    public function filtro(Request $request)
    {
        /**
         * Se utilizan consultas con filtros para obtener diferentes resultados deseados por el
         * usuario
         */
        $preguntas = Pregunta::findOrFail($request->get('PK_PGT_Id'));
        $respuestas = RespuestaPregunta::selectRaw('PK_RPG_Id,FK_RPG_Pregunta,SUBSTRING(RPG_Texto,1,170) as RPG_Texto')
            ->where('FK_RPG_Pregunta', '=', $request->get('PK_PGT_Id'))
            ->get();
        $encuesta = Encuesta::where('FK_ECT_Proceso', '=', session()->get('id_proceso'))
            ->first();
        $encuestados = Encuestado::selectRaw('COUNT(FK_ECD_GrupoInteres) as cantidad')
            ->where('FK_ECD_Encuesta', '=', $encuesta->PK_ECT_Id ?? null)
            ->where('FK_ECD_GrupoInteres', '=', $request->get('PK_GIT_Id'))
            ->first();
        //cantidad de respuestas por cada pregunta
        $labelsEncuestas = [];
        $dataRespuestas = [];
        $dataTitulo = [];
        array_push($dataTitulo, $preguntas->PGT_Texto);
        foreach ($respuestas as $respuesta) {
            $total_respuestas = SolucionEncuesta::whereHas('encuestados', function ($query) use ($request, $encuesta) {
                return $query->where('FK_ECD_GrupoInteres', '=', $request->get('PK_GIT_Id'))
                    ->where('FK_ECD_Encuesta', '=', $encuesta->PK_ECT_Id ?? null);
            })
                ->where('FK_SEC_Respuesta', '=', $respuesta->PK_RPG_Id)
                ->get();
            if ($encuestados->cantidad != 0)
                array_push($labelsEncuestas, $respuesta->RPG_Texto . " " . number_format($total_respuestas->count() * 100 / $encuestados->cantidad, 1) . "%");
            array_push($dataRespuestas, $total_respuestas->count());
        }
        $datos = [];
        $datos['labels_respuestas'] = $labelsEncuestas;
        $datos['data_respuestas'] = array($dataRespuestas);
        $datos['data_titulo'] = array($dataTitulo);
        return json_encode($datos);

    }

    public function obtenerPreguntas($id)
    {
        $encuesta = Encuesta::where('FK_ECT_Proceso', '=', session()->get('id_proceso'))->first();
        $preguntas = PreguntaEncuesta::whereHas('preguntas', function ($query) {
            return $query->where('FK_PGT_Estado', '1');
        })
            ->with('preguntas')
            ->where('FK_PEN_GrupoInteres', '=', $id)
            ->where('FK_PEN_Banco_Encuestas', '=', $encuesta->FK_ECT_Banco_Encuestas)
            ->get()->pluck('preguntas.PGT_Texto', 'preguntas.PK_PGT_Id');
        return json_encode($preguntas);
    }

    public function filtro_factores(Request $request)
    {
        /*filtro para obtener la valorizacion de las caracteristicas pertenecientes al factor digitado 
        por el usuario.
        */
        $labelsCaracteristica = [];
        $dataCaracteristicas = [];
        $dataFactor = [];


        $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados.encuesta', function ($query) {
            return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
        })
            ->where('FK_CRT_Factor', '=', $request->get('PK_FCT_Id'))
            ->groupby('PK_CRT_Id')
            ->get();

        array_push($dataFactor, Factor::where('PK_FCT_Id', $request->get('PK_FCT_Id'))->first()->FCT_Nombre);
        foreach ($caracteristicas as $caracteristica) {
            array_push($labelsCaracteristica, $caracteristica->CRT_Nombre);
            $soluciones = SolucionEncuesta::whereHas('encuestados.encuesta', function ($query) {
                return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
            })
                ->whereHas('respuestas.pregunta.caracteristica', function ($query) use ($caracteristica) {
                    return $query->where('PK_CRT_Id', '=', $caracteristica->PK_CRT_Id);
                })
                ->with('respuestas.ponderacion')
                ->get();
            $totalPonderacion = 0;
            $prueba = $soluciones->count();
            foreach ($soluciones as $solucion) {
                $totalPonderacion = $totalPonderacion + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
            }
            $prueba = $totalPonderacion / $prueba;
            array_push($dataCaracteristicas, $prueba);
        }
        $datos = [];
        $datos['labels_caracteristicas'] = $labelsCaracteristica;
        $datos['data_caracteristicas'] = array($dataCaracteristicas);
        $datos['data_factor'] = array($dataFactor);
        return json_encode($datos);

    }

    public function pdf_documento_encuestas(Request $request)
    {
        $imagenes = explode('|', $request->get('json_datos'));
        $pdf = PDF::loadView('autoevaluacion.FuentesPrimarias.Reportes.pdf_documentos_encuestas', compact('imagenes'));
        return $pdf->download('reporte_encuestas.pdf');
    }
}
