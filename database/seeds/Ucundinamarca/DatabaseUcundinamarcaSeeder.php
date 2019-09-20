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
            'TBL_Fechas_corte', 'TBL_Facultades', 'TBL_Programas_Academicos', 'TBL_Sedes', 'TBL_Procesos', 'TBL_Instituciones'
        ]);

        $this->call(InstitucionSeeder::class);
        $this->call(SedesSeeder::class);
        $this->call(FacultadesSeeder::class);
        $this->call(ProgramasAcademicosSeeder::class);
        $this->call(ProcesosProgramasSeeder::class);
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
