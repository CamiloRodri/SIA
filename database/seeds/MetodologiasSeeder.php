<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Metodologia;

class MetodologiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Metodologia::create([
        	'MTD_Nombre' => 'Presencial'
        ]);

        Metodologia::create([
        	'MTD_Nombre' => 'Virtual'
        ]);
    }
}
