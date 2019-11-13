<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\ProgramaAcademico;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\ProcesoUsuario;
use App\Models\Autoevaluacion\Fase;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\User;
use Carbon\Carbon;


class ProcesosProgramasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $programa = ProgramaAcademico::where('PAC_Nombre', 'Ingenieria de Sistemas')->value('PK_PAC_Id');
        $fase = Fase::where('FSS_Nombre', 'construccion')->value('PK_FSS_Id');
        $lineamiento = Lineamiento::where('LNM_Nombre', 'PREGADO')->value('PK_LNM_Id');
        $todayDate = Carbon::now();
        $todayDate = $todayDate->format('Y-m-d');

        Proceso::create([
        	'PCS_Nombre' => 'Autoevaluación 2019',
        	'PCS_FechaInicio' => $todayDate,
        	'PCS_FechaFin' => '2019-12-10',
        	'PCS_Institucional' => false,
        	'FK_PCS_Programa' => $programa,
        	'FK_PCS_Fase' => $fase,
        	'FK_PCS_Lineamiento' => $lineamiento,
        	'PCS_Slug_Procesos' => 'auto2019'
        ]);

        $proceso = Proceso::where('PCS_Nombre', 'Autoevaluación 2019')->value('PK_PCS_Id');
        $usuario = User::where('name','Camilo')->value('id');
        ProcesoUsuario::create([
            'FK_PCU_Proceso' => $proceso,
            'FK_PCU_Usuario' => $usuario
        ]);

        $usuario = User::where('name','Fuentes Primarias')->value('id');
        ProcesoUsuario::create([
            'FK_PCU_Proceso' => $proceso,
            'FK_PCU_Usuario' => $usuario
        ]);

        $usuario = User::where('name','Fuentes Secundarias')->value('id');
        ProcesoUsuario::create([
            'FK_PCU_Proceso' => $proceso,
            'FK_PCU_Usuario' => $usuario
        ]);

        $usuario = User::where('name','Admin')->value('id');
        ProcesoUsuario::create([
            'FK_PCU_Proceso' => $proceso,
            'FK_PCU_Usuario' => $usuario
        ]);

        $usuario = User::where('name','Evaluador')->value('id');
        ProcesoUsuario::create([
            'FK_PCU_Proceso' => $proceso,
            'FK_PCU_Usuario' => $usuario
        ]);
    }
}
