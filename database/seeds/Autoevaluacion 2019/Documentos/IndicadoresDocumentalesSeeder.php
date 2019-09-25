<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Caracteristica;

class IndicadoresDocumentalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = Estado::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
        $caracteristica = Caracteristica::where('CRT_Nombre', 'RELEVANCIA ACADÉMICA Y PERTINENCIA SOCIAL DEL PROGRAMA')->value('PK_CRT_Id');
        IndicadorDocumental::create([
        	'IDO_Nombre' => 'Estudio de mercado del programa',
        	'IDO_Descripcion' => 'Estudio de mercado del programa',
        	'IDO_Identificador' => '1',
        	'FK_IDO_Caracteristica' => $caracteristica,
        	'FK_IDO_Estado' => $estado
        ]);
    }
}
