<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\FechaCorte;
use App\Models\Autoevaluacion\Proceso;
use Carbon\Carbon;

class FechascorteSeeder extends Seeder
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
        $proceso = Proceso::where('PCS_Nombre','Autoevaluación 2019')->value('PK_PCS_Id');
        FechaCorte::create([
        	'FCO_Fecha' => $todayDate,
        	'FK_FCO_Proceso' => $proceso
        ]);

    }
}
