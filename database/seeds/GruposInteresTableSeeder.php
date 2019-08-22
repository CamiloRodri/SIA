<?php

use App\Models\Autoevaluacion\GrupoInteres;
use Illuminate\Database\Seeder;

class GruposInteresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GrupoInteres::insert([
            ['GIT_Nombre' => 'ESTUDIANTES', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'estudiantes'],
            ['GIT_Nombre' => 'DOCENTES', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'docentes'],
            ['GIT_Nombre' => 'DIRECTIVOS ACADEMICOS', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'directivos_academicos'],
            ['GIT_Nombre' => 'GRADUADOS', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'graduados'],
            ['GIT_Nombre' => 'ADMINISTRATIVOS', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'administrativos'],
            ['GIT_Nombre' => 'EMPLEADORES', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'empleadores'],
            ['GIT_Nombre' => 'EQUIPO DEL PROGRAMA', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'equipo_del_programa'],
            ['GIT_Nombre' => 'EQUIPO INSTITUCIONAL', 'FK_GIT_Estado' => '1', 'GIT_Slug' => 'equipo_institucional'],
        ]);
    }
}
