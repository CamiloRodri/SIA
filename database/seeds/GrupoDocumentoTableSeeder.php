<?php

use App\Models\Autoevaluacion\GrupoDocumento;
use Illuminate\Database\Seeder;

class GrupoDocumentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GrupoDocumento::insert([
            ['GRD_Nombre' => 'INSTITUCIONAL', 'GRD_Descripcion' => 'Documentos institucionales'],
            ['GRD_Nombre' => 'FACULTAD DE CIENCIAS ADMINISTRATIVAS, ECONOMICAS Y CONTABLES', 'GRD_Descripcion' => 'Descripcion'],
            ['GRD_Nombre' => 'FACULTAD DE CIENCIAS AGROPECUARIAS', 'GRD_Descripcion' => 'Descripcion'],
            ['GRD_Nombre' => 'FACULTAD DE CIENCIAS DEL DEPORTE Y LA EDUCACION FISICA', 'GRD_Descripcion' => 'Descripcion'],
            ['GRD_Nombre' => 'FACULTAD DE CIENCIAS DE LA SALUD', 'GRD_Descripcion' => 'Descripcion'],
            ['GRD_Nombre' => 'FACULTAD DE CIENCIAS SOCIALES, HUMANIDADES Y CIENCIAS POLITICAS', 'GRD_Descripcion' => 'Descripcion'],
            ['GRD_Nombre' => 'FACULTAD DE EDUCACION', 'GRD_Descripcion' => 'Descripcion'],
            ['GRD_Nombre' => 'FACULTAD DE INGENIERIA', 'GRD_Descripcion' => 'Descripcion'],
        ]);
    }
}
