<?php

use App\Models\Autoevaluacion\CargoAdministrativo;
use Illuminate\Database\Seeder;

class CargosAdministrativosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoAdministrativo::insert([
            ['CAA_Cargo' => 'RECTOR', 'FK_CAA_AlcanceCargo' => '1', 'CAA_Slug' => 'rector'],
            ['CAA_Cargo' => 'VICERRECTOR ACADEMICO', 'FK_CAA_AlcanceCargo' => '1', 'CAA_Slug' => 'vicerrector_academico'],
            ['CAA_Cargo' => 'DECANO', 'FK_CAA_AlcanceCargo' => '2', 'CAA_Slug' => 'decano'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE PROGRAMA', 'FK_CAA_AlcanceCargo' => '3', 'CAA_Slug' => 'director_coordinador_de_programa'],
            ['CAA_Cargo' => 'DIRECTOR POSGRADOS', 'FK_CAA_AlcanceCargo' => '1', 'CAA_Slug' => 'director_postgrados'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE INVESTIGACION', 'FK_CAA_AlcanceCargo' => '1', 'CAA_Slug' => 'director_coordinador_de_investigacion'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE EXTENSION', 'FK_CAA_AlcanceCargo' => '4', 'CAA_Slug' => 'director_coordinador_de_extension'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE INTERNACIONALIZACION', 'FK_CAA_AlcanceCargo' => '1', 'CAA_Slug' => 'director_coordinador_de_internacionalizacion'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE BIENESTAR', 'FK_CAA_AlcanceCargo' => '1', 'CAA_Slug' => 'director_coordinador_de_bienestar'],
            ['CAA_Cargo' => 'Docente', 'FK_CAA_AlcanceCargo' => '3', 'CAA_Slug' => 'Docente'],
        ]);
    }
}
