<?php

use Illuminate\Database\Seeder;

class DatabaseEncuestasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'TBL_Tipo_Respuestas', 'TBL_Ponderacion_Respuestas', 'TBL_Banco_Encuestas', 'TBL_Preguntas',
            'TBL_Respuestas_Preguntas'
        ]);
        $this->call(TipoRespuestasTablaSeeder::class);
        $this->call(PonderacionRespuestaTableSeeder::class);
        $this->call(BancoEncuestasTableSeeder::class);
        $this->call(PreguntasSeeder::class);
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
    	foreach ($tables as $table)
        {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }	

}
