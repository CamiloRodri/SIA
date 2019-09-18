<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\BancoEncuestas;

class BancoEncuestasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BancoEncuestas::create([
        	'BEC_Nombre' => 'Encuesta General',
        	'BEC_Descripcion' => 'Encuesta Aplicada a la Autoevaluación del Programa de Ingenieria de Sistemas - Facatatica en el año 2019'
        ]);
    }
}
