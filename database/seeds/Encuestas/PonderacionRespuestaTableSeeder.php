<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\PonderacionRespuesta;
use App\Models\Autoevaluacion\TipoRespuesta;

class PonderacionRespuestaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//Dos opciones de respuesta
     	$tipoRespuesta = TipoRespuesta::where('TRP_Descripcion' , 'Dos opciones de respuesta')->value('PK_TRP_Id');  
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '7.0',
        	'PRT_Rango' => '1',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '3.0',
        	'PRT_Rango' => '2',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        //Opciones de respuesta distribuidas (3 opciones)
        $tipoRespuesta = TipoRespuesta::where('TRP_Descripcion' , 'Opciones de respuesta distribuidas (3 opciones)')->value('PK_TRP_Id');  
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '5.0',
        	'PRT_Rango' => '1',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '3.0',
        	'PRT_Rango' => '2',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '2.0',
        	'PRT_Rango' => '3',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        //Opciones de respuesta distribuidas (4 opciones)
        $tipoRespuesta = TipoRespuesta::where('TRP_Descripcion' , 'Opciones de respuesta distribuidas (4 opciones)')->value('PK_TRP_Id');  
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '3.50',
        	'PRT_Rango' => '1',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '3.0',
        	'PRT_Rango' => '2',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '2.0',
        	'PRT_Rango' => '3',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '1.50',
        	'PRT_Rango' => '4',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        //Opciones de respuesta distribuidas (5 opciones)
        $tipoRespuesta = TipoRespuesta::where('TRP_Descripcion' , 'Opciones de respuesta distribuidas (5 opciones)')->value('PK_TRP_Id');  
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '3.0',
        	'PRT_Rango' => '1',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '2.50',
        	'PRT_Rango' => '2',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '2.00',
        	'PRT_Rango' => '3',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '1.50',
        	'PRT_Rango' => '4',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
        PonderacionRespuesta::create([
        	'PRT_Ponderacion' => '1.00',
        	'PRT_Rango' => '5',
        	'FK_PRT_TipoRespuestas' => $tipoRespuesta
        ]);
    }
}
