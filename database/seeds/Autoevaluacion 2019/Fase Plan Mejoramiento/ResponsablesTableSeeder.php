<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Responsable;
use App\Models\Autoevaluacion\User;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\CargoAdministrativo;

class ResponsablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$responsable = User::where('name','Camilo')->value('id');
    	$cargo = CargoAdministrativo::where('CAA_Cargo', 'DIRECTOR/COORDINADOR DE EXTENSION')->value('PK_CAA_Id');
    	$proceso = Proceso::where('PCS_Nombre', 'Autoevaluación 2019')->value('PK_PCS_Id');
        Responsable::create([
        	'FK_RPS_Responsable' => $responsable,
        	'FK_RPS_Cargo' => $cargo,
        	'FK_RPS_Proceso' => $proceso
        ]);

        $responsable = User::where('name','Admin')->value('id');
        $cargo = CargoAdministrativo::where('CAA_Cargo', 'DIRECTOR/COORDINADOR DE PROGRAMA')->value('PK_CAA_Id');
    	Responsable::create([
        	'FK_RPS_Responsable' => $responsable,
        	'FK_RPS_Cargo' => $cargo,
        	'FK_RPS_Proceso' => $proceso
        ]);

        $responsable = User::where('name','Resposable')->value('id');
        $cargo = CargoAdministrativo::where('CAA_Cargo', 'DIRECTOR/COORDINADOR DE PROGRAMA')->value('PK_CAA_Id');
    	Responsable::create([
        	'FK_RPS_Responsable' => $responsable,
        	'FK_RPS_Cargo' => $cargo,
        	'FK_RPS_Proceso' => $proceso
        ]);
    }
}
