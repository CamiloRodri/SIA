<?php

namespace App\Console;

use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Autoevaluacion\SolucionEncuesta;
use App\Models\Historial\Caracteristica;
use App\Models\Historial\DocumentoProceso;
use App\Models\Historial\Factor;
use App\Models\Historial\Pregunta;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     * Funciones que se ejecutan segun el intervalo de tiempo
     * definido
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * Schedule utilizado para comprobar si el proceso ya termino
         * si ya termino el estado cambia a 1 el cual significa cerrado
         */
        $schedule->call(function () {
            $proceso = new Proceso();
            $proceso->where('PCS_FechaFin', '<', Carbon::now())
                ->update(['FK_PCS_Fase' => 1]);
        })->daily();

        /**
         * Schedule usado para comprobar hace cuanto el proceso esta cerrado  si lleva
         * 3 meses cerrado se elimina
         */
        $schedule->call(/**
         *
         */
            function () {
                $proceso = new Proceso();
                $proceso = $proceso->where('FK_PCS_Fase', '=', 1)
                    ->where('PCS_FechaFin', '<', Carbon::now()->subMonths(3))
                    ->get();

                /**
                 * LLenar historial con el lieneamiento, factor, caractersitica, indicador
                 */
                foreach ($proceso as $process) {
                    $factores = [];
                    $caracteristicas = [];
                    $indicadores = [];
                    $preguntas = [];
                    $respuestasArray = [];


                    /**
                     * Para las graficas documentales
                     */
                    $indicadoresDocumentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($process) {
                        $query->where('FK_FCT_Lineamiento', '=', $process->FK_PCS_Lineamiento);
                    })
                        ->with('documentosAutoevaluacion', 'caracteristica')
                        ->get();
                    $documentosAux = DocumentoAutoevaluacion::with('indicadorDocumental')
                        ->where('FK_DOA_Proceso', '=', $process->PK_PCS_Id)
                        ->oldest()
                        ->get();

                    $documentos = $documentosAux->groupBy('FK_DOA_IndicadorDocumental');


                    $lineamientosAutoevaluacion = Lineamiento::with('factor_.caracteristica.indicadoresDocumentales')
                        ->where('PK_LNM_Id', '=', $process->FK_PCS_Lineamiento)
                        ->get();

                    $lineamientosHistorial = new \App\Models\Historial\Lineamiento();
                    $lineamientosHistorial->LNM_Nombre = $lineamientosAutoevaluacion[0]->LNM_Nombre;
                    $lineamientosHistorial->save();


                    $procesoHistorial = new \App\Models\Historial\Proceso();
                    $procesoHistorial->PCS_Nombre = $process->nombre_proceso;
                    $procesoHistorial->PCS_Completitud_Documental = (($documentos->count() / $indicadoresDocumentales->count()) * 100);
                    $procesoHistorial->FK_PCS_Lineamiento = $lineamientosHistorial->PK_LNM_Id;
                    $procesoHistorial->PCS_Anio_Proceso = $process->PCS_FechaInicio;
                    $procesoHistorial->save();

                    foreach ($lineamientosAutoevaluacion[0]->factor_ as $factor) {
                        $factorHistorial = new Factor();
                        $factorHistorial->FCT_Nombre = $factor->FCT_Identificador . '.' . $factor->FCT_Nombre;
                        $factorHistorial->FK_FCT_Lineamiento = $lineamientosHistorial->PK_LNM_Id;
                        $factorHistorial->save();
                        $factores[$factor->PK_FCT_Id] = $factorHistorial->PK_FCT_Id;

                        foreach ($factor->caracteristica as $caracteristica) {
                            $caracteristicaHistorial = new Caracteristica();
                            $caracteristicaHistorial->CRT_Nombre = $caracteristica->CRT_Identificador . '.' . $caracteristica->CRT_Nombre;
                            $caracteristicaHistorial->FK_CRT_Factor = $factores[$caracteristica->FK_CRT_Factor];
                            $caracteristicaHistorial->save();

                            $caracteristicas[$caracteristica->PK_CRT_Id] = $caracteristicaHistorial->PK_CRT_Id;

                            foreach ($caracteristica->indicadoresDocumentales as $indicador_documental) {
                                $indicadorDocumentalHistorial = new \App\Models\Historial\IndicadorDocumental();
                                $indicadorDocumentalHistorial->IDO_Nombre = $indicador_documental->IDO_Nombre;
                                $indicadorDocumentalHistorial->FK_IDO_Caracteristica = $caracteristicaHistorial->PK_CRT_Id;
                                $indicadorDocumentalHistorial->save();
                                $indicadores[$indicador_documental->PK_IDO_Id] = $indicadorDocumentalHistorial->PK_IDO_Id;
                            }
                        }
                    }

                    $documentosAutoevaluacion = DocumentoAutoevaluacion::all()
                        ->where('FK_DOA_Proceso', '=', $process->PK_PCS_Id);


                    foreach ($documentosAutoevaluacion as $documento) {
                        $documentosHistorial = new DocumentoProceso();
                        $documentosHistorial->DPC_Fecha_Subida = $documento->created_at;
                        $documentosHistorial->FK_DPC_Proceso = $procesoHistorial->PK_PCS_Id;
                        $documentosHistorial->FK_DPC_Indicador = $indicadores[$documento->FK_DOA_IndicadorDocumental];
                        $documentosHistorial->save();
                    }

                    $preguntasAutoevaluacion = \App\Models\Autoevaluacion\Pregunta::whereHas('caracteristica.factor', function ($query) use ($lineamientosAutoevaluacion) {
                        $query->where('FK_FCT_Lineamiento', $lineamientosAutoevaluacion[0]->PK_LNM_Id);
                    })
                        ->get();


                    foreach ($preguntasAutoevaluacion as $pregunta) {
                        $preguntasHistorial = new Pregunta();
                        $preguntasHistorial->PGT_Texto = $pregunta->PGT_Texto;
                        $preguntasHistorial->FK_PGT_Caracteristica = $caracteristicas[$pregunta->FK_PGT_Caracteristica];
                        $preguntasHistorial->FK_PGT_Proceso = $procesoHistorial->PK_PCS_Id;
                        $preguntasHistorial->save();

                        $preguntas[$pregunta->PK_PGT_Id] = $preguntasHistorial->PK_PGT_Id;
                    }

                    $respuestasAutoevaluacion = RespuestaPregunta::whereHas('pregunta.caracteristica.factor', function ($query) use ($lineamientosAutoevaluacion) {
                        $query->where('FK_FCT_Lineamiento', $lineamientosAutoevaluacion[0]->PK_LNM_Id);
                    })
                        ->get();

                    foreach ($respuestasAutoevaluacion as $respuestas) {
                        $respuestasHistorial = new \App\Models\Historial\RespuestaPregunta();
                        $respuestasHistorial->RPG_Texto = $respuestas->RPG_Texto;
                        $respuestasHistorial->FK_RPG_Pregunta = $preguntas[$respuestas->FK_RPG_Pregunta];
                        $respuestasHistorial->save();

                        $respuestasArray[$respuestas->PK_RPG_Id] = $respuestasHistorial->PK_RPG_Id;
                    }

                    $encuestas = SolucionEncuesta::with('encuestados.grupos')
                        ->with(['encuestados.encuesta' => function ($query) use ($process) {
                                $query->where('FK_ECT_Proceso', '=', $process->PK_PCS_Id);
                            }]
                        )
                        ->with('respuestas.ponderacion')
                        ->get();

                    $encuestasRespuesta = $encuestas->groupBy('FK_SEC_Respuesta')
                        ->transform(function ($item, $key) {
                            return $item->groupBy('encuestados.grupos.GIT_Nombre');
                        });

                    $idRespuesta = $encuestasRespuesta->keys()->toArray();
                    $encuestasRespuesta = $encuestasRespuesta->toArray();

                    foreach ($encuestasRespuesta as $encuesta_respuesta) {
                        $id_respuesta = $respuestasArray[array_shift($idRespuesta)];
                        foreach ($encuesta_respuesta as $key => $encuesta_grupo) {
                            $solucionEncuesta = new \App\Models\Historial\SolucionEncuesta();
                            $solucionEncuesta->SEC_Total_Encuestados = count($encuesta_grupo);
                            $solucionEncuesta->SEC_Grupo_Interes = $key;
                            $solucionEncuesta->FK_SEC_Respuesta = $id_respuesta;
                            $solucionEncuesta->SEC_Total_Ponderacion =
                                (10 / array_get($encuesta_grupo, '0.respuestas.ponderacion.PRT_Rango', 0) *
                                    count($encuesta_grupo)) / count($encuesta_grupo);
                            $solucionEncuesta->save();
                        }
                    }
                    $process->delete();
                }
            })->daily();

        /**
         * Schedule usado para comprobar la fecha en la que inicia la
         * encuesta relacionada con el proceso, si ya inicio la coloca en fase 4
         * la cual significa recolección de datos
         */

        $schedule->call(function () {
            $proceso = Proceso::whereHas('encuestas', function ($query) {
                return $query->where('ECT_FechaPublicacion', '<=', Carbon::now());
            })
                ->where('FK_PCS_Fase', '!=', '1')
                ->update(['FK_PCS_Fase' => 4]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
