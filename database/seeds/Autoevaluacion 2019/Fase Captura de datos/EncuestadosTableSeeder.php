<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\CargoAdministrativo;
use App\Models\Autoevaluacion\GrupoInteres;

class EncuestadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $encuesta = Encuesta::where('FK_ECT_Proceso', '=', $id_proceso)
        $estudiantes1 = GrupoInteres::where('GIT_Nombre', 'ESTUDIANTES_1')->value('PK_GIT_Id');
        $cargo = CargoAdministrativo::where('CAA_Slug', '=', $request->get('cargo'))  //DIRECTIVOS ACADEMICOS
    	Encuestado::create([
    		'ECD_FechaSolucion' => '',
    		'FK_ECD_Encuesta' => '',
    		'FK_ECD_GrupoInteres' => '',
    		'FK_ECD_CargoAdministrativo' => ''
    	]);

    }
}
