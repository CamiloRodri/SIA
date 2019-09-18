<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\Estado;

class FactoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $estado = ESTADO::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
        $Lineamiento = Lineamiento::where('LNM_Nombre' , 'PREGADO')->value('PK_LNM_Id');
        Factor::create([
        	'FCT_Nombre' => 'FACTOR MISIÓN, PROYECTO INSTITUCIONAL Y DE PROGRAMA',
        	'FCT_Descripcion' => 'FACTOR MISIÓN, PROYECTO INSTITUCIONAL Y DE PROGRAMA',
        	'FCT_Identificador' => '1',
        	'FCT_Ponderacion_factor' => '1',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);

        Factor::create([
        	'FCT_Nombre' => 'FACTOR ESTUDIANTES',
        	'FCT_Descripcion' => 'FACTOR ESTUDIANTES',
        	'FCT_Identificador' => '2',
        	'FCT_Ponderacion_factor' => '1',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);

        Factor::create([
        	'FCT_Nombre' => 'FACTOR PROFESORES',
        	'FCT_Descripcion' => 'FACTOR PROFESORES',
        	'FCT_Identificador' => '3',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);

        Factor::create([
        	
        	'FCT_Nombre' => 'FACTOR PROCESOS ACADÉMICOS',
        	'FCT_Descripcion' => 'FACTOR PROCESOS ACADÉMICOS',
        	'FCT_Identificador' => '4',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);

        Factor::create([
        	'FCT_Nombre' => 'FACTOR VISIBILIDAD NACIONAL E INTERNACIONAL',
        	'FCT_Descripcion' => 'FACTOR VISIBILIDAD NACIONAL E INTERNACIONAL',
        	'FCT_Identificador' => '5',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);

        Factor::create([
        	'FCT_Nombre' => 'FACTOR INVESTIGACIÓN, INNOVACIÓN Y CREACIÓN ARTÍSTICA Y CULTURAL',
        	'FCT_Descripcion' => 'FACTOR INVESTIGACIÓN, INNOVACIÓN Y CREACIÓN ARTÍSTICA Y CULTURAL',
        	'FCT_Identificador' => '6',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);

        Factor::create([
        	'FCT_Nombre' => 'FACTOR BIENESTAR INSTITUCIONAL',
        	'FCT_Descripcion' => 'FACTOR BIENESTAR INSTITUCIONAL',
        	'FCT_Identificador' => '7',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);

       Factor::create([
        	'FCT_Nombre' => 'FACTOR ORGANIZACIÓN, ADMINISTRACIÓN Y GESTIÓN',
        	'FCT_Descripcion' => 'FACTOR ORGANIZACIÓN, ADMINISTRACIÓN Y GESTIÓN',
        	'FCT_Identificador' => '8',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);
       Factor::create([
        	'FCT_Nombre' => 'FACTOR IMPACTO DE LOS EGRESADOS EN EL MEDIO',
        	'FCT_Descripcion' => 'FACTOR IMPACTO DE LOS EGRESADOS EN EL MEDIO',
        	'FCT_Identificador' => '9',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);
       Factor::create([
        	'FCT_Nombre' => 'FACTOR RECURSOS FÍSICOS Y FINANCIEROS',
        	'FCT_Descripcion' => 'FACTOR RECURSOS FÍSICOS Y FINANCIEROS',
        	'FCT_Identificador' => '10',
        	'FCT_Ponderacion_factor' => '3',
        	'FK_FCT_Estado' => $estado,
        	'FK_FCT_Lineamiento' => $Lineamiento
        ]);
    }
}
