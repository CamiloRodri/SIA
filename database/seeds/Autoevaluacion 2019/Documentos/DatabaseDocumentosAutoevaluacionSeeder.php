<?php

use Illuminate\Database\Seeder;

class DatabaseDocumentosAutoevaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'TBL_Indicadores_Documentales', 'TBL_Documentos_Autoevaluacion'
        ]);

        $this->call(IndicadoresDocumentalesSeeder::class);
        $this->call(DocumentosAutoevaluacionSeeder::class);
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
