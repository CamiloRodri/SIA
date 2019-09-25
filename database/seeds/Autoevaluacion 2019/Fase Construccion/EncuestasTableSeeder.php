<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\BancoEncuestas;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\Estado;
use Carbon\Carbon;

class EncuestasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$todayDate = Carbon::now();
        $todayDate = $todayDate->format('Y-m-d');
    	$estado = Estado::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
    	$bancoencuesta= BancoEncuestas::where('BEC_Nombre', 'Encuesta General')->value('PK_BEC_Id');
    	$proceso = Proceso::where('PCS_Nombre', 'Autoevaluación 2019')->value('PK_PCS_Id');
    	
    	Encuesta::create([
    		//'ECT_FechaPublicacion' => $todayDate,
    		'ECT_FechaPublicacion' => '2019-08-08',
    		'ECT_FechaFinalizacion' => '2020-19-09',
    		'FK_ECT_Estado' => $estado,
    		'FK_ECT_Banco_Encuestas' => $bancoencuesta,
    		'FK_ECT_Proceso' => $proceso,

    	]);
    }
}
