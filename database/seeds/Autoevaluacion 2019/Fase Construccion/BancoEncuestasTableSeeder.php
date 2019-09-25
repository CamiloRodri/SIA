<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\BancoEncuestas;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\GrupoInteres;

class BancoEncuestasTableSeeder extends Seeder
{ 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BancoEncuestas::create([
        	'BEC_Nombre' => 'Encuesta General',
        	'BEC_Descripcion' => 'Encuesta Aplicada a la Autoevaluación del Programa de Ingenieria de Sistemas - Facatativá en el año 2019'
        ]);
        $bancoencuesta= BancoEncuestas::where('BEC_Nombre', 'Encuesta General')->value('PK_BEC_Id');
        $estudiantes = GrupoInteres::where('GIT_Nombre', 'ESTUDIANTES')->value('PK_GIT_Id');
        $docentes = GrupoInteres::where('GIT_Nombre', 'DOCENTES')->value('PK_GIT_Id');
        $directivos = GrupoInteres::where('GIT_Nombre', 'DIRECTIVOS ACADEMICOS')->value('PK_GIT_Id');
        $graduados = GrupoInteres::where('GIT_Nombre', 'GRADUADOS')->value('PK_GIT_Id');
        $administradores = GrupoInteres::where('GIT_Nombre', 'ADMINISTRATIVOS')->value('PK_GIT_Id');
        $empleadores = GrupoInteres::where('GIT_Nombre', 'EMPLEADORES')->value('PK_GIT_Id');
        $eprograma = GrupoInteres::where('GIT_Nombre', 'EQUIPO DEL PROGRAMA')->value('PK_GIT_Id');
        $einstitucional = GrupoInteres::where('GIT_Nombre', 'EQUIPO INSTITUCIONAL')->value('PK_GIT_Id');

        $estudiantes1 = GrupoInteres::where('GIT_Nombre', 'ESTUDIANTES_1')->value('PK_GIT_Id');
        $estudiantes2 = GrupoInteres::where('GIT_Nombre', 'ESTUDIANTES_2')->value('PK_GIT_Id');
       
        $pregunta1 = Pregunta::where('PGT_Texto','Según lo señala el Proyecto Educativo Institucional (PEI), los elementos centrales del enfoque de la Misión de la Universidad de Cundinamarca son: (marque una sola alternativa)')->value('PK_PGT_Id');
        $pregunta2 = Pregunta::where('PGT_Texto','Según su opinión, ¿existen en la UDEC espacios institucionales para la discusión y actualización permanente del proyecto educativo del Programa (PEP)?')->value('PK_PGT_Id');
        $pregunta3 = Pregunta::where('PGT_Texto','¿Considera que el Programa de formación y sus profesores desarrollan actividades para atender las necesidades locales, regionales, nacionales e internacionales, en términos productivos, competitividad, tecnológicos y de talento humano?')->value('PK_PGT_Id');
        $pregunta4 = Pregunta::where('PGT_Texto','¿Conoce los mecanismos de ingreso de estudiantes a la institución y del programa de formación en que usted estudia? (procedimientos y requisitos de ingreso)')->value('PK_PGT_Id');
        $pregunta5 = Pregunta::where('PGT_Texto','¿El número de docentes del programa es suficiente para atender el número de estudiantes que ingresan al mismo?')->value('PK_PGT_Id');
        PreguntaEncuesta::create([
                'FK_PEN_Pregunta' => $pregunta1,
                'FK_PEN_Banco_Encuestas' => $bancoencuesta,
                'FK_PEN_GrupoInteres' => $estudiantes1

        ]);
        PreguntaEncuesta::create([
                'FK_PEN_Pregunta' => $pregunta2,
                'FK_PEN_Banco_Encuestas' => $bancoencuesta,
                'FK_PEN_GrupoInteres' => $estudiantes1

        ]);
        PreguntaEncuesta::create([
                'FK_PEN_Pregunta' => $pregunta3,
                'FK_PEN_Banco_Encuestas' => $bancoencuesta,
                'FK_PEN_GrupoInteres' => $estudiantes1

        ]);
        PreguntaEncuesta::create([
                'FK_PEN_Pregunta' => $pregunta4,
                'FK_PEN_Banco_Encuestas' => $bancoencuesta,
                'FK_PEN_GrupoInteres' => $estudiantes1

        ]);
        PreguntaEncuesta::create([
                'FK_PEN_Pregunta' => $pregunta5,
                'FK_PEN_Banco_Encuestas' => $bancoencuesta,
                'FK_PEN_GrupoInteres' => $estudiantes1

        ]);
        ////////////




// `FK_PEN_Pregunta`, `FK_PEN_GrupoInteres`
// 9=$estudiantes1   10=$estudiantes2   2=$docentes    3=$directivos    4=$graduados   6=$empleados   
//                 ( 1, 9),
//                 ( 2, 9),
//                 ( 3, 9),
//                 ( 4, 9),
//                 ( 5, 9),
// ( 6, 9),
// ( 7, 9),
// ( 8, 9),
// ( 9, 9),
// (10, 9),
// (11, 9),
// (12, 9),
// (13, 9),
// (14, 9),
// (15, 9),

// (16, 10),
// (17, 10),
// (18, 10),
// (19, 10),
// (20, 10),
// (21, 10),
// (22, 10),
// (23, 10),
// (24, 10),
// (25, 10),
// (26, 10),
// (27, 10),
// (28, 10),
// (29, 10),
// (30, 10),

// (27, 2),
// (28, 2),
// (29, 2),
// (30, 2),
// (31, 2),
// (32, 2),
// (33, 2),
// (34, 2),
// (35, 2),
// (36, 2),
// (37, 2),
// (38, 2),
// (39, 2),
// (40, 2),
// (41, 2),

// (43, 3),
// (44, 3),
// (45, 3),
// (46, 3),
// (13, 3),
// (48, 3),
// (37, 3),
// (50, 3),
// (51, 3),
// (52, 3),
// (53, 3),
// (54, 3),
// (55, 3),
// (56, 3),
// (57, 3),

// (63, 4),
// (60, 4),
// (65, 4),
// (66, 4),
// (41, 4),
// (68, 4),

// (58, 6),
// (59, 6),
// (60, 6),
// (61, 6),
// (62, 6),
    }
}
