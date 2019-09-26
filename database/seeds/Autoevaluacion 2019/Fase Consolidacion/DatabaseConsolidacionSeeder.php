<?php

use Illuminate\Database\Seeder;

class DatabaseConsolidacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'TBL_Consolidaciones'
        ]);

        $this->call(FaseConsolidacionSeeder::class);
        $this->call(ConsolidacionTableSeeder::class);
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
