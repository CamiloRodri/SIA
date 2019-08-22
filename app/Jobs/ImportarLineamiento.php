<?php

namespace App\Jobs;

use App\Models\Autoevaluacion\Aspecto;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Factor;
use Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;


class ImportarLineamiento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero de veces que intenta ejecutar la cola
     *
     * @var int
     */
    public $tries = 3;

    protected $urlArchivo, $idLineamiento;

    /**
     * Constructor del job para recibir la url del archivo excel que se guarda temporalmente
     * para ser importado, ademas del lineamiento al cual pertenece.
     *
     * @param [string] $urlArchivo
     * @param [int] $idLineamiento
     */
    public function __construct($urlArchivo, $idLineamiento)
    {
        $this->urlArchivo = $urlArchivo;
        $this->idLineamiento = $idLineamiento;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $id = $this->idLineamiento;
            //Se seleccionan solo las hojas del archivo escel especificadas en la funcion
            Excel::selectSheets('FACTORES', 'CARACTERISTICAS', 'ASPECTOS')->load(public_path($this->urlArchivo), function ($reader) use ($id) {
                // obtiene todas las hojas del excel y las conveirte en array
                $sheets = $reader->all()->toArray();
                $factores = [];

                $count = count($sheets);
                //Si contiene menos de tres hojas y al menos una en este caso seria factores
                if ($count <= 3 and $count > 0) {
                    //Factores
                    foreach ($sheets[0] as $row) {
                        $factor = new Factor();
                        $factor->FCT_Nombre = $row['nombre'];
                        $factor->FCT_Descripcion = $row['descripcion'];
                        $factor->FCT_Identificador = $row['numero_factor'];
                        $factor->FCT_Ponderacion_Factor = $row['ponderacion'];

                        $factor->FK_FCT_Lineamiento = $this->idLineamiento;
                        $factor->FK_FCT_Estado = 1;
                        $factor->save();
                        $factores[$row['numero_factor']] = $factor->PK_FCT_Id;
                    }
                }
                //Si contiene menos de tres hojas y al menos mas de dos esta incluye características
                if ($count <= 3 and $count > 1) {
                    //Caracteristicas
                    $caracacteristicas = [];
                    foreach ($sheets[1] as $row) {
                        $caracacteristica = new Caracteristica();
                        $caracacteristica->CRT_Nombre = $row['nombre'];
                        $caracacteristica->CRT_Descripcion = $row['descripcion'];
                        $caracacteristica->CRT_Identificador = $row['numero_caracteristica'];
                        $caracacteristica->FK_CRT_Estado = 1;
                        $caracacteristica->FK_CRT_Factor = $factores[$row['factor']];
                        $caracacteristica->save();
                        $caracacteristicas[$row['numero_caracteristica']] = $caracacteristica->PK_CRT_Id;
                    }
                }
                //Si tiene exactamente tres hojas contiene Aspectos
                if ($count == 3) {
                    foreach ($sheets[2] as $row) {
                        $aspecto = new Aspecto();
                        $aspecto->ASP_Nombre = $row['nombre'];
                        $aspecto->ASP_Descripcion = $row['descripcion'];
                        $aspecto->ASP_Identificador = $row['identificador'];
                        $aspecto->FK_ASP_Caracteristica = $caracacteristicas[$row['caracteristica']];
                        $aspecto->save();
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
