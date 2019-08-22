<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Historial\Caracteristica;
use App\Models\Historial\DocumentoProceso;
use App\Models\Historial\Factor;
use App\Models\Historial\IndicadorDocumental;
use App\Models\Historial\Proceso;
use App\Models\Historial\SolucionEncuesta;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index()
    {
        $procesosHistorial = Proceso::pluck('PCS_Nombre', 'PK_PCS_Id');
        $procesosAnios = Proceso::orderBy('PCS_Anio_Proceso', 'desc')
            ->get()
            ->pluck('PCS_Anio_Proceso', 'PCS_Anio_Proceso');

        return view('autoevaluacion.SuperAdministrador.Historial.index', compact(
            'procesosHistorial', 'procesosAnios'
        ));
    }

    public function obtenerProceso($anio)
    {
        $procesos = Proceso::where('PCS_Anio_Proceso', '=', $anio)
            ->get()
            ->pluck('PCS_Nombre', 'PK_PCS_Id');
        return json_encode($procesos);
    }

    public function obtenerDatosGraficas($idProceso)
    {
        //Documental
        $proceso = Proceso::find($idProceso);

        $indicadoresDocumentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($proceso) {
            $query->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento);
        })
            ->with('documentosAutoevaluacion', 'caracteristica')
            ->get();
        $documentosAux = DocumentoProceso::with('indicadorDocumental')
            ->where('FK_DPC_Proceso', '=', $idProceso)
            ->oldest()
            ->get();

        $documentos = $documentosAux->groupBy('FK_DPC_IndicadorDocumental');

        $documentosAuto = $documentosAux->groupBy(function ($date) {
            return $date->created_at->format('Y-m-d');
        });

        //Grafico barras
        $labelsIndicador = [];
        $dataIndicador = [];
        foreach ($indicadoresDocumentales as $documentoIndicador) {
            array_push($labelsIndicador, $documentoIndicador->IDO_Nombre);
            array_push($dataIndicador, $documentoIndicador->documentosAutoevaluacion->count());
        }

        //grafico historial fechas
        $labelsFechas = $documentosAuto->keys()->toArray();
        $dataFechas = [];

        foreach ($documentosAuto as $documentoAuto) {
            array_push($dataFechas, $documentoAuto->count());
        }

        //Grafico pie
        $completado = $proceso->PCS_Completitud_Documental;
        $dataPie = [array(number_format($completado, 1), 100 - number_format($completado, 1))];

        $datos = [];
        $datos['completado'] = number_format($completado, 1);
        $datos['dataPie'] = $dataPie;
        $datos['labels_fecha'] = $labelsFechas;
        $datos['data_fechas'] = array($dataFechas);
        $datos['labels_indicador'] = $labelsIndicador;
        $datos['data_indicador'] = array($dataIndicador);
        $datos['factores'] = Factor::whereHas('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)
            ->get()
            ->pluck('nombre_factor', 'PK_FCT_Id')
            ->toArray();

        //Encuestas

        //cantidad de encuestados
        $labelsEncuestado = [];
        $dataEncuestado = [];
        $encuestasCantidad = SolucionEncuesta::whereHas('respuestas.pregunta', function ($query) use ($proceso) {
            $query->where('FK_PGT_Proceso', '=', $proceso->PK_PCS_Id);
        })
            ->get()
            ->groupBy('SEC_Grupo_Interes');

        $contador = 0;
        foreach ($encuestasCantidad as $key => $encuestados) {
            array_push($labelsEncuestado, $key);
            array_push($dataEncuestado, $encuestados[$contador]->SEC_Total_Encuestados);
            $contador++;
        }

        //valorizacion de las caracteristicas
        $labelsCaracteristicas = [];
        $dataCaracteristicas = [];
        $dataFactor = [];

        $factor = Factor::where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)->first();

        $caracteristicas = Caracteristica::whereHas('preguntas', function ($query) use ($proceso) {
            return $query->where('FK_PGT_Proceso', '=', $proceso->PK_PCS_Id);
        })
            ->whereHas('preguntas.respuestas.solucion')
            ->where('FK_CRT_Factor', '=', $factor->PK_FCT_Id)
            ->with('preguntas.respuestas.solucion')
            ->get()
            ->groupBy('PK_CRT_Id');

        foreach ($caracteristicas as $key_caracteristica => $caracteristica) {
            array_push($labelsCaracteristicas, $caracteristica[0]->CRT_Nombre);
            $total_ponderaciones = 0;
            $cantidad = 0;
            foreach ($caracteristica[0]->preguntas as $pregunta) {
                foreach ($pregunta->respuestas as $respuestas) {
                    foreach ($respuestas->solucion as $solucion) {
                        $cantidad++;
                        $total_ponderaciones = $total_ponderaciones + $solucion->SEC_Total_Ponderacion;
                    }
                }
            }
            $data = $total_ponderaciones != 0 ? $total_ponderaciones / $cantidad : 0;
            array_push($dataCaracteristicas, $data);
        }

        $dataFactor = Factor::where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)
            ->get()
            ->pluck('FCT_Nombre', 'PK_FCT_Id');

        $datos['labels_encuestado'] = $labelsEncuestado;
        $datos['data_encuestado'] = array($dataEncuestado);
        $datos['labels_caracteristicas'] = $labelsCaracteristicas;
        $datos['data_caracteristicas'] = array($dataCaracteristicas);
        $datos['factor_elegido'] = array($factor->FCT_Nombre);
        $datos['data_factor'] = $dataFactor;

        return json_encode($datos);
    }

    public function obtenerCaracteristicas($idFactor)
    {
        $caracteristicas = Caracteristica::has('indicadores_documentales')
            ->where('FK_CRT_Factor', '=', $idFactor)
            ->get()
            ->pluck('CRT_Nombre', 'PK_CRT_Id');
        return json_encode($caracteristicas);
    }

    public function filtroDocumental(Request $request, $idProceso)
    {
        $proceso = Proceso::find($idProceso);
        $idFactor = $request->get('PK_FCT_Id');
        $idCaracteristica = $request->get('PK_CRT_Id');

        /**
         * Se utilizan consultas con filtros para obtner diferentes resultados deseados por el
         * usuario
         */
        $indicadoresDocumentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($proceso, $idFactor) {
            $query->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)
                ->when($idFactor, function ($q) use ($idFactor) {
                    return $q->where('PK_FCT_Id', $idFactor);
                });
        })
            ->when($idCaracteristica, function ($q) use ($idCaracteristica) {
                return $q->where('FK_IDO_Caracteristica', $idCaracteristica);
            })
            ->get();

        //Grafico barras
        $labelsIndicador = [];
        $dataIndicador = [];
        foreach ($indicadoresDocumentales as $documentoIndicador) {
            array_push($labelsIndicador, $documentoIndicador->IDO_Nombre);
            array_push($dataIndicador, $documentoIndicador->documentosAutoevaluacion->count());
        }

        $datos = [];
        $datos['labels_indicador'] = $labelsIndicador;
        $datos['data_indicador'] = array($dataIndicador);

        return json_encode($datos);
    }

    public function filtroEncuestas(Request $request, $idProceso)
    {
        $labelsCaracteristicas = [];
        $dataCaracteristicas = [];
        $dataFactor = [];

        $factor = Factor::find($request->get('PK_FCT_Id'));

        $caracteristicas = Caracteristica::whereHas('preguntas', function ($query) use ($idProceso) {
            return $query->where('FK_PGT_Proceso', '=', $idProceso);
        })
            ->whereHas('preguntas.respuestas.solucion')
            ->where('FK_CRT_Factor', '=', $request->get('PK_FCT_Id'))
            ->with('preguntas.respuestas.solucion')
            ->get()
            ->groupBy('PK_CRT_Id');

        foreach ($caracteristicas as $key_caracteristica => $caracteristica) {
            array_push($labelsCaracteristicas, $caracteristica[0]->CRT_Nombre);
            $total_ponderaciones = 0;
            $cantidad = 0;
            foreach ($caracteristica[0]->preguntas as $pregunta) {
                foreach ($pregunta->respuestas as $respuestas) {
                    foreach ($respuestas->solucion as $solucion) {
                        $cantidad++;
                        $total_ponderaciones = $total_ponderaciones + $solucion->SEC_Total_Ponderacion;
                    }
                }
            }
            $data = $total_ponderaciones != 0 ? $total_ponderaciones / $cantidad : 0;
            array_push($dataCaracteristicas, $data);
        }

        $datos['labels_caracteristicas'] = $labelsCaracteristicas;
        $datos['data_caracteristicas'] = array($dataCaracteristicas);
        $datos['factor_elegido'] = array($factor->FCT_Nombre);

        return json_encode($datos);
    }
}
