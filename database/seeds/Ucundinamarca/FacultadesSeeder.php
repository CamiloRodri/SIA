<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Facultad;
use App\Models\Autoevaluacion\Estado;

class FacultadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = Estado::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
        Facultad::create([
        	'FCD_Nombre' => 'Ingenieria',
        	'FCD_Descripcion' => 'Facultad de Ingenieria de la Universidad de Cundinamarca',
        	'FK_FCD_Estado' => $estado
        ]);
    }
}
