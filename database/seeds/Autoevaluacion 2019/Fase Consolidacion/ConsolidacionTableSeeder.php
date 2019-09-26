<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Consolidacion;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\Caracteristica;

class ConsolidacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $caracteristica = Caracteristica::where('CRT_Nombre' , 'MISIÓN, VISIÓN Y PROYECTO INSTITUCIONAL')->value('PK_CRT_Id');
        $proceso = Proceso::where('PCS_Nombre','Autoevaluación 2019')->value('PK_PCS_Id');
    	Consolidacion::create([
    		'CNS_Debilidad' => 'Debilidad Mision',
    		'CNS_Fortaleza' => 'Fortaleza Mision',
    		'FK_CNS_Caracteristica' => $caracteristica,
    		'FK_CNS_Proceso' => $proceso
    	]);
    }
}
