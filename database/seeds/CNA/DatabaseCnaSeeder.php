<?php

use Illuminate\Database\Seeder;

class DatabaseCnaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'TBL_Fechas_corte', 'TBL_Facultades', 'TBL_Programas_Academicos', 'TBL_Sedes', 'TBL_Procesos'
        ]);

    	$this->truncateTables([
            'TBL_Lineamientos', 'TBL_Factores', 'TBL_Ambitos_Responsabilidad', 'TBL_Caracteristicas'
        ]);

        $this->call(LineamientosTableSeeder::class);
        $this->call(FactoresTableSeeder::class);
        $this->call(AmbitosTableSeeder::class);
        $this->call(CaracteristicasTableSeeder::class);
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
