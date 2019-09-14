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
            'TBL_Instituciones', 'TBL_Facultades', 'TBL_Procesos', 'TBL_Procesos_Usuarios',
            'TBL_Programas_Academicos', 'TBL_Responsables', 'TBL_Sedes'
        ]);

        $this->call(FacultadesSeeder::class);
        $this->call(InstitucionSeeder::class);
        $this->call(ProcesosInstitucionalesSeeder::class);
        $this->call(ProcesosProgramasSeeder::class);
        $this->call(ProgramasAcademicosSeeder::class);
        $this->call(SedesSeeder::class);

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
