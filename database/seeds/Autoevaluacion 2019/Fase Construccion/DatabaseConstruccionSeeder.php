<?php

use Illuminate\Database\Seeder;

class DatabaseConstruccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->truncateTables([
            'TBL_Banco_Encuestas', 'TBL_Encuestas'
        ]);

        $this->call(BancoEncuestasTableSeeder::class);
        $this->call(EncuestasTableSeeder::class);
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
