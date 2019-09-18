<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\TipoRespuesta;
use App\Models\Autoevaluacion\Estado;

class TipoRespuestasTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = Estado::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
        TipoRespuesta::create([
        	'TRP_TotalPonderacion' => '10',
        	'TRP_CantidadRespuestas' => '2',
        	'TRP_Descripcion' => 'Dos opciones de respuesta',
        	'FK_TRP_Estado' => $estado
        ]);

        TipoRespuesta::create([
        	'TRP_TotalPonderacion' => '10',
        	'TRP_CantidadRespuestas' => '3',
        	'TRP_Descripcion' => 'Opciones de respuesta distribuidas (3 opciones)',
        	'FK_TRP_Estado' => $estado
        ]);

        TipoRespuesta::create([
        	'TRP_TotalPonderacion' => '10',
        	'TRP_CantidadRespuestas' => '4',
        	'TRP_Descripcion' => 'Opciones de respuesta distribuidas (4 opciones)',
        	'FK_TRP_Estado' => $estado
        ]);

        TipoRespuesta::create([
        	'TRP_TotalPonderacion' => '10',
        	'TRP_CantidadRespuestas' => '5',
        	'TRP_Descripcion' => 'Opciones de respuesta distribuidas (5 opciones)',
        	'FK_TRP_Estado' => $estado
        ]);
    }
}
