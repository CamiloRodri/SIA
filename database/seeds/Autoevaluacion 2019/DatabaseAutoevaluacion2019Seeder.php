<?php

use Illuminate\Database\Seeder;

class DatabaseAutoevaluacion2019Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Documentacion
        $this->call(DatabaseDocumentosAutoevaluacionSeeder::class);

        //Fase Construccion
        $this->call(DatabaseConstruccionSeeder::class);

        //Fase Captura de Datos
        //$this->call(DatabaseCapturaDatosSeeder::class);

        //Fase Consolidacion
        $this->call(DatabaseConsolidacionSeeder::class);

        //Fase Plan de Mejoramiento
        //$this->call(DatabasePlanMejoramientoSeeder::class);

    }
}
