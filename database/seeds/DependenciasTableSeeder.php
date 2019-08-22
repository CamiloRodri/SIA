<?php

use App\Models\Autoevaluacion\Dependencia;
use Illuminate\Database\Seeder;

class DependenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dependencia::insert([
            ['DPC_Nombre' => 'MINISTERIO DE EDUCACIÓN NACIONAL'],
            ['DPC_Nombre' => 'RECTORIA'],
            ['DPC_Nombre' => 'CONSEJO SUPERIOR UNIVERSITARIO'],
            ['DPC_Nombre' => 'CONSEJO ACADÉMICO'],
            ['DPC_Nombre' => 'SECRETARIA GENERAL'],
            ['DPC_Nombre' => 'OFICINA DE PLANEACIÓN INSTITUCIONAL'],
            ['DPC_Nombre' => 'VICERECTORIA GENERAL'],
            ['DPC_Nombre' => 'VICERECTORIA ACADÉMICA'],
            ['DPC_Nombre' => 'BIENESTAR UNIVERSITARIO']
        ]);
    }
}
