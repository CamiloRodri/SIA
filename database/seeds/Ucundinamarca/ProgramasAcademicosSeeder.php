<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\ProgramaAcademico;
use App\Models\Autoevaluacion\Facultad;
use App\Models\Autoevaluacion\Sede;
use App\Models\Autoevaluacion\Metodologia;

class ProgramasAcademicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = Estado::where('ESD_Nombre', 'HABILITADO')->value('PK_ESD_Id');
		$facultad = Facultad::where('FCD_Nombre', 'Ingenieria')->value('PK_FCD_Id');
        $sede = Sede::where('SDS_Nombre', 'Extension Facatativa')->value('PK_SDS_Id');
        $metodologia = Metodologia::where('MTD_Nombre', 'Presencial')->value('PK_MTD_Id');
		ProgramaAcademico::create([
    		'PAC_Nombre' => 'Ingenieria de Sistemas',
    		'PAC_Descripcion' => 'Programa de Ingenieria de Sistemas de Facatativá',
    		'FK_PAC_Estado' => $estado,
    		'FK_PAC_Facultad' => $facultad,
            'FK_PAC_Sede' => $sede,
            'FK_PAC_Metodologia' => $metodologia
    	]);
    }
}
