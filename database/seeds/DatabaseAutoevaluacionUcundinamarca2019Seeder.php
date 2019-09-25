<?php

use Illuminate\Database\Seeder;

class DatabaseAutoevaluacionUcundinamarca2019Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DatabaseCnaSeeder::class);
        $this->call(DatabaseUcundinamarcaSeeder::class);
        $this->call(DatabaseEncuestasSeeder::class);
        $this->call(DatabaseAutoevaluacion2019Seeder::class);
    }
}
