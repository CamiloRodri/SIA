<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\AmbitoResponsabilidad;

class CaracteristicasTableSeeder extends Seeder
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
        $ambito = AmbitoResponsabilidad::where('AMB_Nombre' , 'Programa')->value('PK_AMB_Id');

    	$factormision = Factor::where('FCT_Nombre', 'FACTOR MISIÓN, PROYECTO INSTITUCIONAL Y DE PROGRAMA')->value('PK_FCT_Id');
        $factorestudiantes = Factor::where('FCT_Nombre', 'FACTOR ESTUDIANTES')->value('PK_FCT_Id');
        $factorprofesores = Factor::where('FCT_Nombre', 'FACTOR PROFESORES')->value('PK_FCT_Id');
        $factorprocesos = Factor::where('FCT_Nombre', 'FACTOR PROCESOS ACADÉMICOS')->value('PK_FCT_Id');
        $factorvisibilidad = Factor::where('FCT_Nombre', 'FACTOR VISIBILIDAD NACIONAL E INTERNACIONAL')->value('PK_FCT_Id');
        $factorinvestigacion = Factor::where('FCT_Nombre', 'FACTOR INVESTIGACIÓN, INNOVACIÓN Y CREACIÓN ARTÍSTICA Y CULTURAL')->value('PK_FCT_Id');
        $factorbienestar = Factor::where('FCT_Nombre', 'FACTOR BIENESTAR INSTITUCIONAL')->value('PK_FCT_Id');
        $factororganizacion = Factor::where('FCT_Nombre', 'FACTOR ORGANIZACIÓN, ADMINISTRACIÓN Y GESTIÓN')->value('PK_FCT_Id');
        $factorimpacto = Factor::where('FCT_Nombre', 'FACTOR IMPACTO DE LOS EGRESADOS EN EL MEDIO')->value('PK_FCT_Id');
        $factorrecursos = Factor::where('FCT_Nombre', 'FACTOR RECURSOS FÍSICOS Y FINANCIEROS')->value('PK_FCT_Id');

        //FACTOR MISIÓN, PROYECTO INSTITUCIONAL Y DE PROGRAMA
        Caracteristica::create([
        	'CRT_Nombre' => 'MISIÓN, VISIÓN Y PROYECTO INSTITUCIONAL',
        	'CRT_Descripcion' => 'MISIÓN, VISIÓN Y PROYECTO INSTITUCIONAL',
        	'CRT_Identificador' => '1',
        	'FK_CRT_Factor' => $factormision,
        	'FK_CRT_Estado' => $estado,
        	'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'PROYECTO EDUCATIVO DEL PROGRAMA',
            'CRT_Descripcion' => 'PROYECTO EDUCATIVO DEL PROGRAMA',
            'CRT_Identificador' => '2',
            'FK_CRT_Factor' => $factormision,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'RELEVANCIA ACADÉMICA Y PERTINENCIA SOCIAL DEL PROGRAMA',
            'CRT_Descripcion' => 'RELEVANCIA ACADÉMICA Y PERTINENCIA SOCIAL DEL PROGRAMA',
            'CRT_Identificador' => '3',
            'FK_CRT_Factor' => $factormision,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR ESTUDIANTES
        Caracteristica::create([
            'CRT_Nombre' => 'MECANISMOS DE SELECCIÓN DE INGRESOS',
            'CRT_Descripcion' => 'MECANISMOS DE SELECCIÓN DE INGRESOS',
            'CRT_Identificador' => '4',
            'FK_CRT_Factor' => $factorestudiantes,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'ESTUDIANTES ADMITIDOS Y CAPACIDAD INSTITUCIONAL',
            'CRT_Descripcion' => 'ESTUDIANTES ADMITIDOS Y CAPACIDAD INSTITUCIONAL',
            'CRT_Identificador' => '5',
            'FK_CRT_Factor' => $factorestudiantes,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'PARTICIPACIÓN DE ACTIVIDADES DE FORMACIÓN INTEGRAL',
            'CRT_Descripcion' => 'PARTICIPACIÓN DE ACTIVIDADES DE FORMACIÓN INTEGRAL',
            'CRT_Identificador' => '6',
            'FK_CRT_Factor' => $factorestudiantes,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'RAGLAMENTOS ESTUDIANTIL Y ACADÉMICO',
            'CRT_Descripcion' => 'RAGLAMENTOS ESTUDIANTIL Y ACADÉMICO',
            'CRT_Identificador' => '7',
            'FK_CRT_Factor' => $factorestudiantes,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR PROFESORES
        Caracteristica::create([
            'CRT_Nombre' => 'SELECCIÓN, VINCULACIÓN Y PERMANENCIA DE PROFESORES',
            'CRT_Descripcion' => 'SELECCIÓN, VINCULACIÓN Y PERMANENCIA DE PROFESORES',
            'CRT_Identificador' => '8',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'ESTATUTO PROFESIONAL',
            'CRT_Descripcion' => 'ESTATUTO PROFESIONAL',
            'CRT_Identificador' => '9',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'NUMERO, DEDICACIÓN, NIVEL DE FORMACIÓN Y EXPERIENCIA DE PROFESORES',
            'CRT_Descripcion' => 'NUMERO, DEDICACIÓN, NIVEL DE FORMACIÓN Y EXPERIENCIA DE PROFESORES',
            'CRT_Identificador' => '10',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'DESARROLLO PROFESIONAL',
            'CRT_Descripcion' => 'DESARROLLO PROFESIONAL',
            'CRT_Identificador' => '11',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'ESTIMULOS A LA DOCENCIA, INVESTIGACIÓN, CREACIÓN ARTISTICA Y CULTURAL, EXTENSIÓN O PROYECCIÓN SOCIAL Y A LA COOPERACIÓN INTERNACIONAL',
            'CRT_Descripcion' => 'ESTIMULOS A LA DOCENCIA, INVESTIGACIÓN, CREACIÓN ARTISTICA Y CULTURAL, EXTENSIÓN O PROYECCIÓN SOCIAL Y A LA COOPERACIÓN INTERNACIONAL',
            'CRT_Identificador' => '12',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'PRODUCCIÓN, PERTINENCIA, UTILIZACIÓN E IMPACTO MATERIAL DOCENTE',
            'CRT_Descripcion' => 'PRODUCCIÓN, PERTINENCIA, UTILIZACIÓN E IMPACTO MATERIAL DOCENTE',
            'CRT_Identificador' => '13',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'REMUNERACIÓN POR MERITOS',
            'CRT_Descripcion' => 'REMUNERACIÓN POR MERITOS',
            'CRT_Identificador' => '14',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'EVALUACIÓN DE PROFESORES',
            'CRT_Descripcion' => 'EVALUACIÓN DE PROFESORES',
            'CRT_Identificador' => '15',
            'FK_CRT_Factor' => $factorprofesores,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR PROCESOS ACADÉMICOS
        Caracteristica::create([
            'CRT_Nombre' => 'INTEGRIDAD DEL CURRÍCULO',
            'CRT_Descripcion' => 'INTEGRIDAD DEL CURRÍCULO',
            'CRT_Identificador' => '16',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'FLEXIBILIDAD DEL CURRÍCULO',
            'CRT_Descripcion' => 'FLEXIBILIDAD DEL CURRÍCULO',
            'CRT_Identificador' => '17',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'INTERDISCIPLINARIEDAD',
            'CRT_Descripcion' => 'INTERDISCIPLINARIEDAD',
            'CRT_Identificador' => '18',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'ESTRATEGIAS DE ENSEÑANZA Y APRENDIZAJE',
            'CRT_Descripcion' => 'ESTRATEGIAS DE ENSEÑANZA Y APRENDIZAJE',
            'CRT_Identificador' => '19',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'SISTEMA DE EVALUACIÓN DE ESTUDIANTES',
            'CRT_Descripcion' => 'SISTEMA DE EVALUACIÓN DE ESTUDIANTES',
            'CRT_Identificador' => '20',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'TRABAJOS DE LOS ESTUDIANTES',
            'CRT_Descripcion' => 'TRABAJOS DE LOS ESTUDIANTES',
            'CRT_Identificador' => '21',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'EVALUACIÓN Y AUTORREGULACIÓN DEL PROGRAMA',
            'CRT_Descripcion' => 'EVALUACIÓN Y AUTORREGULACIÓN DEL PROGRAMA',
            'CRT_Identificador' => '22',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'EXTENSIÓN O PROYECTO SOCIAL',
            'CRT_Descripcion' => 'EXTENSIÓN O PROYECTO SOCIAL',
            'CRT_Identificador' => '23',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'RECURSOS BIBLIOGRÁFICOS',
            'CRT_Descripcion' => 'RECURSOS BIBLIOGRÁFICOS',
            'CRT_Identificador' => '24',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'RECURSOS INFORMÁTICOS Y DE COMUNICACIÓN',
            'CRT_Descripcion' => 'RECURSOS INFORMATICOS Y DE COMUNICACIÓN',
            'CRT_Identificador' => '25',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'RECURSOS DE APOYO DOCENTE',
            'CRT_Descripcion' => 'RECURSOS DE APOYO DOCENTE',
            'CRT_Identificador' => '26',
            'FK_CRT_Factor' => $factorprocesos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR VISIBILIDAD NACIONAL E INTERNACIONAL
        Caracteristica::create([
            'CRT_Nombre' => 'INSERCIÓN DEL PROGRAMA EN CONTEXTOS ACADÉMICOS NACIOANALES E INTERNACIONALES',
            'CRT_Descripcion' => 'INSERCIÓN DEL PROGRAMA EN CONTEXTOS ACADÉMICOS NACIOANALES E INTERNACIONALES',
            'CRT_Identificador' => '27',
            'FK_CRT_Factor' => $factorvisibilidad,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'RELACIONES EXTERNAS DE PROFESORES Y ESTUDIANTES',
            'CRT_Descripcion' => 'RELACIONES EXTERNAS DE PROFESORES Y ESTUDIANTES',
            'CRT_Identificador' => '28',
            'FK_CRT_Factor' => $factorvisibilidad,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR INVESTIGACIÓN, INNOVACIÓN Y CREACIÓN ARTÍSTICA Y CULTURAL
        Caracteristica::create([
            'CRT_Nombre' => 'FORMACIÓN PARA LA INVESTIGACIÓN , LA INNOVACIÓN Y LA CREACIÓN ARTISTICA Y CULTURAL',
            'CRT_Descripcion' => 'FORMACIÓN PARA LA INVESTIGACIÓN , LA INNOVACIÓN Y LA CREACIÓN ARTISTICA Y CULTURAL',
            'CRT_Identificador' => '29',
            'FK_CRT_Factor' => $factorinvestigacion,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'COMPROMISO CON LA INVESTIGACIÓN Y LA CREACIÓN ARTISTICA Y CULTURAL',
            'CRT_Descripcion' => 'COMPROMISO CON LA INVESTIGACIÓN Y LA CREACIÓN ARTISTICA Y CULTURAL',
            'CRT_Identificador' => '30',
            'FK_CRT_Factor' => $factorinvestigacion,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR BIENESTAR INSTITUCIONAL
        Caracteristica::create([
            'CRT_Nombre' => 'POLÍTICAS, PROGRAMAS Y SERVICIOS DE BIENESTAR UNIVERSITARIO',
            'CRT_Descripcion' => 'POLÍTICAS, PROGRAMAS Y SERVICIOS DE BIENESTAR UNIVERSITARIO',
            'CRT_Identificador' => '31',
            'FK_CRT_Factor' => $factorbienestar,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'PERMANENCIA Y RETENCIÓN ESTUDIANTIL',
            'CRT_Descripcion' => 'PERMANENCIA Y RETENCIÓN ESTUDIANTIL',
            'CRT_Identificador' => '32',
            'FK_CRT_Factor' => $factorbienestar,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //// FACTOR ORGNIZACIÓN, ADMINISTRACIÓN Y GESTIÓN
        Caracteristica::create([
            'CRT_Nombre' => 'ORGANIZACIÓN, ADMINISTRACIÓN Y GESTIÓN DEL PROGRAMA',
            'CRT_Descripcion' => 'ORGANIZACIÓN, ADMINISTRACIÓN Y GESTIÓN DEL PROGRAMA',
            'CRT_Identificador' => '33',
            'FK_CRT_Factor' => $factororganizacion,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'SISTEMAS DE COMUNICACIÓN E INFORMACIÓN',
            'CRT_Descripcion' => 'SISTEMAS DE COMUNICACIÓN E INFORMACIÓN',
            'CRT_Identificador' => '34',
            'FK_CRT_Factor' => $factororganizacion,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'DIRECCIÓN DEL PROGRAMA',
            'CRT_Descripcion' => 'DIRECCIÓN DEL PROGRAMA',
            'CRT_Identificador' => '35',
            'FK_CRT_Factor' => $factororganizacion,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR IMPACTO DE LOS EGRESADOS EN EL MEDIO
        Caracteristica::create([
            'CRT_Nombre' => 'SEGUIMIENTO DE LOS EGRESADOS',
            'CRT_Descripcion' => 'SEGUIMIENTO DE LOS EGRESADOS',
            'CRT_Identificador' => '36',
            'FK_CRT_Factor' => $factorimpacto,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'IMPACTO DE LOS EGRESADOS EN EL MEDIO SOCIAL Y ACADÉMICO',
            'CRT_Descripcion' => 'IMPACTO DE LOS EGRESADOS EN EL MEDIO SOCIAL Y ACADÉMICO',
            'CRT_Identificador' => '37',
            'FK_CRT_Factor' => $factorimpacto,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
        //FACTOR RECURSOS FISICOS Y FINANCIEROS 
        Caracteristica::create([
            'CRT_Nombre' => 'RECURSOS FÍSICOS',
            'CRT_Descripcion' => 'RECURSOS FÍSICOS',
            'CRT_Identificador' => '38',
            'FK_CRT_Factor' => $factorrecursos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'PRESUPUESTO DEL PROGRAMA',
            'CRT_Descripcion' => 'PRESUPUESTO DEL PROGRAMA',
            'CRT_Identificador' => '39',
            'FK_CRT_Factor' => $factorrecursos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);

        Caracteristica::create([
            'CRT_Nombre' => 'ADMINISTRACIÓN DE RECURSOS',
            'CRT_Descripcion' => 'ADMINISTRACIÓN DE RECURSOS',
            'CRT_Identificador' => '40',
            'FK_CRT_Factor' => $factorrecursos,
            'FK_CRT_Estado' => $estado,
            'FK_CRT_Ambito' => $ambito
        ]);
    }
}
