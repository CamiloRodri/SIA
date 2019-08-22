<?php

use App\Models\Autoevaluacion\AlcanceAdministrativo;
use Illuminate\Database\Seeder;

class AlcancesAdministrativosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AlcanceAdministrativo::insert([
            ['AAD_Alcance' => 'TODOS LOS PROGRAMAS DE FORMACION'],
            ['AAD_Alcance' => 'PROGRAMAS DE SU FACULTAD'],
            ['AAD_Alcance' => 'PROGRAMA RESPECTIVO'],
            ['AAD_Alcance' => 'SEDE RESPECTIVA'],
        ]);
    }
}
