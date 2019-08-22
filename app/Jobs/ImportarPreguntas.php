<?php

namespace App\Jobs;

use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\PonderacionRespuesta;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Autoevaluacion\TipoRespuesta;
use Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportarPreguntas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero de veces que intenta ejecutar la cola
     *
     * @var int
     */
    public $tries = 3;

    protected $urlArchivo, $idProceso;

    /**
     * Constructor del job para recibir la url del archivo excel que se guarda temporalmente
     * para ser importado, ademas del proceso al cual pertenece.
     *
     * @param string $urlArchivo
     * @param int $idProceso
     */
    public function __construct($urlArchivo, $idProceso)
    {
        $this->urlArchivo = $urlArchivo;
        $this->idProceso = $idProceso;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $idProceso = $this->idProceso;
            //Se seleccionan solo las hojas del archivo escel especificadas en la funcion
            Excel::selectSheets('TIPO', 'PONDERACION', 'PREGUNTA', 'RESPUESTA')->load(public_path($this->urlArchivo), function ($reader) use ($idProceso) {
                // obtiene todas las hojas del excel y las conveirte en array
                $sheets = $reader->all()->toArray();

                $tipoRespuestas = [];

                $count = count($sheets);
                //Si contiene menos de cuatro hojas y al menos una en este caso sera el tipo de respuesta
                if ($count <= 4 and $count > 0) {
                    //Tipo respuesta
                    foreach ($sheets[0] as $row) {
                        $tipoRespuesta = new TipoRespuesta();
                        $tipoRespuesta->TRP_TotalPonderacion = $row['total_ponderacion'];
                        $tipoRespuesta->TRP_CantidadRespuestas = $row['cantidad_respuestas'];
                        $tipoRespuesta->TRP_Descripcion = $row['descripcion'];
                        $tipoRespuesta->FK_TRP_Estado = 1;
                        $tipoRespuesta->save();
                        $tipoRespuestas[$row['numero_tipo_respuesta']] = $tipoRespuesta->PK_TRP_Id;
                    }
                }
                //Si contiene menos de tres hojas y al menos mas de dos esta incluye ponderaciones para cada respuesta
                if ($count <= 4 and $count > 1) {
                    //Ponderaciones
                    $ponderaciones = [];
                    foreach ($sheets[1] as $row) {
                        $ponderacion = new PonderacionRespuesta();
                        $ponderacion->PRT_Ponderacion = $row['ponderacion'];
                        $ponderacion->PRT_Rango = $row['rango'];
                        $ponderacion->FK_PRT_TipoRespuestas = $tipoRespuestas[$row['tipo_respuesta']];
                        $ponderacion->save();
                        $ponderaciones[$row['numero_ponderacion']] = $ponderacion->PK_PRT_Id;
                    }
                }
                //El archivo puede ser unicamente cargado al sistema unicamente cuando exista proceso seleccionado
                $lineamiento = Proceso::select('FK_PCS_Lineamiento')
                    ->where('PK_PCS_Id', '=', $idProceso)
                    ->first();
                $caracteristicas = Caracteristica::whereHas('factor', function ($query) use ($lineamiento) {
                    return $query->where('FK_FCT_Lineamiento', $lineamiento->FK_PCS_Lineamiento);
                })
                    ->select('PK_CRT_Id', 'CRT_Identificador')
                    ->get();
                //Se almacenan las preguntas apuntando a las caracteristicas pertenecientes al lineamiento del proceso seleccionado
                if ($count <= 4 and $count > 3) {
                    //Preguntas
                    $preguntas = [];
                    foreach ($sheets[2] as $row) {
                        $pregunta = new Pregunta();
                        $pregunta->PGT_Texto = $row['pregunta'];
                        $pregunta->FK_PGT_Estado = 1;
                        $pregunta->FK_PGT_TipoRespuesta = $tipoRespuestas[$row['tipo_respuesta']];
                        $id = $caracteristicas->where('CRT_Identificador', $row['numero_caracteristica'])->first();

                        $pregunta->FK_PGT_Caracteristica = $id->PK_CRT_Id;

                        $pregunta->save();
                        $preguntas[$row['numero_pregunta']] = $pregunta->PK_PGT_Id;
                    }
                }
                //Si tiene exactamente cuatro hojas contiene respuestas
                if ($count == 4) {
                    //Respuestas
                    foreach ($sheets[3] as $row) {
                        $respuesta = new RespuestaPregunta();
                        $respuesta->RPG_Texto = $row['respuesta'];
                        $respuesta->FK_RPG_Pregunta = $preguntas[$row['numero_pregunta']];
                        $respuesta->FK_RPG_PonderacionRespuesta = $ponderaciones[$row['numero_ponderacion']];
                        $respuesta->save();
                    }
                }
            });
        } catch (\Exception $e) {

        } finally {
            /**
             * Clausula finally sin importar que siempre elimina el archivo temporal
             * que fue guardado en el servidor
             */

            $ruta = str_replace('storage', 'public', $this->urlArchivo);
            Storage::delete($ruta);
        }
    }
}
