<?php

use Illuminate\Database\Seeder;

class DatabaseUcundinamarcaSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            //'TBL_Fechas'
        ]);

        $this->call(FechascorteSeeder::class);
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
