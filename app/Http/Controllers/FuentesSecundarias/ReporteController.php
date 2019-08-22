<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Dependencia;
use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\DocumentoInstitucional;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\GrupoDocumento;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\TipoDocumento;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;


class ReporteController extends Controller
{
    public function index()
    {
        $idLineamiento = Proceso::find(session()->get('id_proceso'))->FK_PCS_Lineamiento ?? null;

        $factores = Factor::has('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $idLineamiento)
            ->where('FK_FCT_estado', '=', '1')
            ->get()
            ->pluck('nombre_factor', 'PK_FCT_Id');
        $dependencias = Dependencia::pluck('DPC_Nombre', 'PK_DPC_Id');
        $tipoDocumentos = TipoDocumento::pluck('TDO_Nombre', 'PK_TDO_Id');

        return view('autoevaluacion.FuentesSecundarias.Reportes.index',
            compact('factores', 'dependencias', 'tipoDocumentos')
        );
    }

    public function obtenerDatos(Request $request)
    {
        $proceso = Proceso::find(session()->get('id_proceso'));
        $indicadoresDocumentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($proceso) {
            $query->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento);
        })
            ->with('documentosAutoevaluacion', 'caracteristica')
            ->get();
        $documentosAux = DocumentoAutoevaluacion::with('indicadorDocumental')
            ->where('FK_DOA_Proceso', '=', session()->get('id_proceso'))
            ->oldest()
            ->get();


        $documentos = $documentosAux->groupBy('FK_DOA_IndicadorDocumental');

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
        $labelsFecha = $documentosAuto->keys()->toArray();
        $dataFechas = [];

        foreach ($documentosAuto as $documentoAuto) {
            array_push($dataFechas, $documentoAuto->count());
        }

        //Grafico pie
        $completado = ($documentos->count() / $indicadoresDocumentales->count()) * 100;
        $dataPie = [array(number_format($completado, 1), 100 - number_format($completado, 1))];


        $datos = [];
        $datos['completado'] = number_format($completado, 1);
        $datos['dataPie'] = $dataPie;
        $datos['labels_fecha'] = $labelsFecha;
        $datos['data_fechas'] = array($dataFechas);
        $datos['labels_indicador'] = $labelsIndicador;
        $datos['data_indicador'] = array($dataIndicador);

        return json_encode($datos);
    }

    public function filtro(Request $request)
    {
        $proceso = Proceso::find(session()->get('id_proceso'));
        $idFactor = $request->get('PK_FCT_Id');
        $idCaracteristica = $request->get('PK_CRT_Id');
        $tipoDocumento = $request->get('PK_TDO_Id');
        $dependencia = $request->get('PK_DPC_Id');

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
            ->with(['documentosAutoevaluacion' => function ($query) use ($tipoDocumento, $dependencia) {
                return $query
                    ->when($tipoDocumento, function ($q) use ($tipoDocumento) {
                        return $q->where('FK_DOA_TipoDocumento', $tipoDocumento);
                    })
                    ->when($dependencia, function ($q) use ($dependencia) {
                        return $q->where('FK_DOA_Dependencia', $dependencia);
                    });
            }])
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

    public function reportes()
    {
        return view('autoevaluacion.FuentesSecundarias.Reportes.index2');
    }

    public function obtenerDatosInst(Request $request)
    {
        $documentosAux = DocumentoInstitucional::with('grupodocumento')
            ->oldest()
            ->get();
        $documentosInst = $documentosAux->groupBy(function ($date) {
            return $date->created_at->format('Y-m-d');
        });


        //grafico historial fechas
        $labelsFecha = $documentosInst->keys()->toArray();
        $dataFechas = [];

        foreach ($documentosInst as $documentoInst) {
            array_push($dataFechas, $documentoInst->count());
        }


        //grafica documentos institucionales
        $labelsDocumento = [];
        $dataDocumento = [];
        $grupodocumento = GrupoDocumento::with('documentoinstitucional')
            ->get();
        foreach ($grupodocumento as $documentoInstitucional) {
            array_push($labelsDocumento, $documentoInstitucional->GRD_Nombre);
            array_push($dataDocumento, $documentoInstitucional->documentoinstitucional->count());
        }


        $datos = [];
        $datos['labels_fecha'] = $labelsFecha;
        $datos['data_fecha'] = array($dataFechas);
        $datos['labels_documento'] = $labelsDocumento;
        $datos['data_documento'] = array($dataDocumento);

        return json_encode($datos);
    }

    public function pdf_documento_autoevaluacion(Request $request)
    {
        $imagenes = explode('|', $request->get('json_datos'));
        $pdf = PDF::loadView('autoevaluacion.FuentesSecundarias.Reportes.pdf_documentos_autoevaluacion', compact('imagenes'));
        return $pdf->download('reporte_documental.pdf');
    }

    public function pdf_documentos_institucionales(Request $request)
    {
        $imagenes = explode('|', $request->get('json_datos'));
        $pdf = PDF::loadView('autoevaluacion.FuentesSecundarias.Reportes.pdf_documentos_institucionales', compact('imagenes'));
        return $pdf->download('reporte_documentos_institucionales.pdf');
    }


}
