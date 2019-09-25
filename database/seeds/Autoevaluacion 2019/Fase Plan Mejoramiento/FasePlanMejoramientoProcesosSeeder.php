<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\ProgramaAcademico;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\Fase;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\PlanMejoramiento;
use Carbon\Carbon;

class FasePlanMejoramientoProcesosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Fases: 
        *cerrado
        *suspendido
        *construccion
        *captura de datos
        *consolidacion
        *plan de mejoramiento
        */
        $programa = ProgramaAcademico::where('PAC_Nombre', 'Ingenieria de Sistemas')->value('PK_PAC_Id');
        $fase = Fase::where('FSS_Nombre', 'plan de mejoramiento')->value('PK_FSS_Id');
        $lineamiento = Lineamiento::where('LNM_Nombre', 'PREGADO')->value('PK_LNM_Id');
        $todayDate = Carbon::now();
        $todayDate = $todayDate->format('Y-m-d');	
        $procesoauto = Proceso::where('PCS_Nombre','Autoevaluación 2019')->value('PK_PCS_Id');
        //dd($proceso);
        $proceso = Proceso::find($procesoauto);
        $proceso->PCS_Nombre = 'Autoevaluación 2019';
        $proceso->PCS_FechaInicio = '2019-05-10';
        $proceso->PCS_FechaFin = $todayDate;
        $proceso->PCS_Institucional = false;
        $proceso->FK_PCS_Fase = $fase;
        $fase = Fase::where('PK_FSS_Id', '=', $fase)->first();
        if ($fase->FSS_Nombre == "plan de mejoramiento") {
            $verificarPlan = PlanMejoramiento::where('FK_PDM_Proceso', '=', $procesoauto)->first();
            if ($verificarPlan == null) {
                $planMejoramiento = new PlanMejoramiento();
                $planMejoramiento->PDM_Nombre = 'Plan de Mejoramiento Autoevaluación 2019';
                $planMejoramiento->PDM_Descripcion = 'Autoevaluacion 2019';
                $planMejoramiento->FK_PDM_Proceso = $procesoauto;
                $planMejoramiento->save();
            }
        }
        $proceso->FK_PCS_Programa = $programa;
        $proceso->FK_PCS_Lineamiento = $lineamiento;
        $nombres = explode(' ', ProgramaAcademico::where('PK_PAC_Id', $programa)->first()->PAC_Nombre);
        $slug = "";
        foreach ($nombres as $nombre) {
            $slug = $slug . '_' . $nombre;
        }

        $proceso->PCS_Slug_Procesos = $slug . Carbon::now()->toDateString();
        $proceso->update();
    }
}
