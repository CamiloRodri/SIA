<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\AmbitoResponsabilidad;

class AmbitosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Ambito de Responsabilidad
        AmbitoResponsabilidad::create([
        	'AMB_Nombre' => 'Programa',
        ]);

        AmbitoResponsabilidad::create([
        	'AMB_Nombre' => 'Institución',
        ]);

    }
}
