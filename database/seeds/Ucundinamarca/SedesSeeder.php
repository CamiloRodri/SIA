<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Institucion;
use App\Models\Autoevaluacion\Sede;
use App\Models\Autoevaluacion\Estado;

class SedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institucion = Institucion::where('ITN_Nombre' , 'Universidad de Cundinamarca')->value('PK_ITN_Id');
    	$estado = Estado::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
        Sede::create([
        	'SDS_Nombre' => 'Extension Facatativa',
        	'SDS_Descripcion' => 'Facatativa y Sabana de Occidente',
            'FK_SDS_Institucion' => $institucion,
        	'FK_SDS_Estado' => $estado
        ]);
    }
}
