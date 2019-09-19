<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\TipoRespuesta;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Autoevaluacion\PonderacionRespuesta;

class PreguntasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tipoRespuesta2 = TipoRespuesta::where('TRP_Descripcion' , 'Dos opciones de respuesta')->value('PK_TRP_Id');  
    	$tipoRespuesta3 = TipoRespuesta::where('TRP_Descripcion' , 'Opciones de respuesta distribuidas (3 opciones)')->value('PK_TRP_Id');
    	$tipoRespuesta4 = TipoRespuesta::where('TRP_Descripcion' , 'Opciones de respuesta distribuidas (4 opciones)')->value('PK_TRP_Id');  
        $tipoRespuesta5 = TipoRespuesta::where('TRP_Descripcion' , 'Opciones de respuesta distribuidas (5 opciones)')->value('PK_TRP_Id');  
        //Dos respuestas //7.0  //3.0
        $ponderaciont2p70 = PonderacionRespuesta::where('PRT_Ponderacion' , '7.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta2)
        					->value('PK_PRT_Id');
        $ponderaciont2p30 = PonderacionRespuesta::where('PRT_Ponderacion' , '7.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta2)
        					->value('PK_PRT_Id');
        //Tres respuestas //5.0  //3.0  //2.0
        $ponderaciont3p50 = PonderacionRespuesta::where('PRT_Ponderacion' , '5.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta3)
        					->value('PK_PRT_Id');
        $ponderaciont3p30 = PonderacionRespuesta::where('PRT_Ponderacion' , '3.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta3)
        					->value('PK_PRT_Id');
        $ponderaciont3p20 = PonderacionRespuesta::where('PRT_Ponderacion' , '2.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta3)
        					->value('PK_PRT_Id');
        //Cuatro respuestas //3.5  //3.0  //2.0 //1.5
        $ponderaciont4p35 = PonderacionRespuesta::where('PRT_Ponderacion' , '3.5')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta4)
        					->value('PK_PRT_Id');
        $ponderaciont4p30 = PonderacionRespuesta::where('PRT_Ponderacion' , '3.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta4)
        					->value('PK_PRT_Id');
        $ponderaciont4p20 = PonderacionRespuesta::where('PRT_Ponderacion' , '2.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta4)
        					->value('PK_PRT_Id');
        $ponderaciont4p15 = PonderacionRespuesta::where('PRT_Ponderacion' , '1.5')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta4)
        					->value('PK_PRT_Id');
        //Cinco respuestas //3.0  //2.5  //2.0 //1.5 //1.0
        $ponderaciont5p30 = PonderacionRespuesta::where('PRT_Ponderacion' , '3.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta5)
        					->value('PK_PRT_Id');
        $ponderaciont5p25 = PonderacionRespuesta::where('PRT_Ponderacion' , '2.5')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta5)
        					->value('PK_PRT_Id');
        $ponderaciont5p20 = PonderacionRespuesta::where('PRT_Ponderacion' , '2.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta5)
        					->value('PK_PRT_Id');
        $ponderaciont5p15 = PonderacionRespuesta::where('PRT_Ponderacion' , '1.5')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta5)
        					->value('PK_PRT_Id');
        $ponderaciont5p10 = PonderacionRespuesta::where('PRT_Ponderacion' , '1.0')
        					->where('FK_PRT_TipoRespuestas' , $tipoRespuesta5)
        					->value('PK_PRT_Id');

    	$estado = ESTADO::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
    	//Pregunta 1
    	$pregunta = Pregunta::create([
			    		'PGT_Texto' => 'Según lo señala el Proyecto Educativo Institucional (PEI), los elementos centrales del enfoque de la Misión de la Universidad de Cundinamarca son: (marque una sola alternativa)',
			    		'FK_PGT_Estado' => $estado,
			    		'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
			    		'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'MISIÓN, VISIÓN Y PROYECTO INSTITUCIONAL')->value('PK_CRT_Id') 
			     	]);
        //$pregunta = Pregunta::where('PGT_Texto','Según lo señala el Proyecto Educativo Institucional (PEI), los elementos centrales del enfoque de la Misión de la Universidad de Cundinamarca son: (marque una sola alternativa)')->value('PK_PGT_Id');
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'Impulsar prioritariamente la investigación y la formación integral centrada en los currículos; fortalecer su condición de universidad interdisciplinaria; y vigorizar su presencia en el país, contribuyendo especialmente a la solución de las problemáticas del entorno nacional.',
    		'FK_RPG_Pregunta' => $pregunta->value('PK_PGT_Id'),
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont5p30
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'La formacion de profesionales lideres con altas calidades academicas, laborales y humnas; la formacion integral de un hombre en el cual se desarrollen optimamente las diferentes dimensiones de su ser, que actue con base en el conocimiento de las condiciones culturales, sociales y ambientales',
    		'FK_RPG_Pregunta' => $pregunta->value('PK_PGT_Id'),
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont5p25
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'La formación de personas emprendedoras que contribuyan con el desarrollo de la sociedad, mediante procesos de docencia, investigación y extensión, ajustados a las necesidades de  la sociedad.',
    		'FK_RPG_Pregunta' => $pregunta->value('PK_PGT_Id'),
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont5p20
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'Realizar formación de profesionales, proyección social e investigación, para impulsar el desarrollo integral de las personas y de la sociedad colombiana.',
    		'FK_RPG_Pregunta' => $pregunta->value('PK_PGT_Id'),
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont5p15
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'No la conoce/La institución no la socializa',
    		'FK_RPG_Pregunta' => $pregunta->value('PK_PGT_Id'),
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont5p10
    	]);
    	//Pregunta 2
    	$pregunta = Pregunta::create([
			    		'PGT_Texto' => 'Según su opinión, ¿existen en la UDEC espacios institucionales para la discusión y actualización permanente del proyecto educativo del Programa (PEP)?',
			    		'FK_PGT_Estado' => $estado,
			    		'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
			    		'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
			     	]);
    	$pregunta = Pregunta::where('PGT_Texto','Según su opinión, ¿existen en la UDEC espacios institucionales para la discusión y actualización permanente del proyecto educativo del Programa (PEP)?')->value('PK_PGT_Id');
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'Existe y se usa',
    		'FK_RPG_Pregunta' => $pregunta,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p35
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'Existe y no se usa',
    		'FK_RPG_Pregunta' => $pregunta,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p30
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'No existen',
    		'FK_RPG_Pregunta' => $pregunta,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p20
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'No sabe no conoce',
    		'FK_RPG_Pregunta' => $pregunta,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p15
    	]);
        //Pregunta 3
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿Considera que el Programa de formación y sus profesores desarrollan actividades para atender las necesidades locales, regionales, nacionales e internacionales, en términos productivos, competitividad, tecnológicos y de talento humano?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿Considera que el Programa de formación y sus profesores desarrollan actividades para atender las necesidades locales, regionales, nacionales e internacionales, en términos productivos, competitividad, tecnológicos y de talento humano?')->value('PK_PGT_Id');
        RespuestaPregunta::create([
            'RPG_Texto' => 'Siempre',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont5p30
        ]);
        RespuestaPregunta::create([
            'RPG_Texto' => 'Con frecuencia',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont5p25
        ]);
        RespuestaPregunta::create([
            'RPG_Texto' => 'Algunas veces',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont5p20
        ]);
        RespuestaPregunta::create([
            'RPG_Texto' => 'Nunca',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont5p15
        ]);
        RespuestaPregunta::create([
            'RPG_Texto' => 'No sabe / no conoce',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont5p10
        ]);
        //Pregunta 4
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿Conoce los mecanismos de ingreso de estudiantes a la institución y del programa de formación en que usted estudia? (procedimientos y requisitos de ingreso)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta3,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿Conoce los mecanismos de ingreso de estudiantes a la institución y del programa de formación en que usted estudia? (procedimientos y requisitos de ingreso)')->value('PK_PGT_Id');
        RespuestaPregunta::create([
            'RPG_Texto' => 'Totalmente',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont3p50
        ]);
        RespuestaPregunta::create([
            'RPG_Texto' => 'Parcialmente',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont3p30
        ]);
        RespuestaPregunta::create([
            'RPG_Texto' => 'No los conoce',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont3p20
        ]);
        //Pregunta 5
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿El número de docentes del programa es suficiente para atender el número de estudiantes que ingresan al mismo?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta3,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿El número de docentes del programa es suficiente para atender el número de estudiantes que ingresan al mismo?')->value('PK_PGT_Id');
        RespuestaPregunta::create([
            'RPG_Texto' => 'Siempre',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont3p50
        ]);

        RespuestaPregunta::create([
            'RPG_Texto' => 'Algunas veces',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont3p30
        ]);

        RespuestaPregunta::create([
            'RPG_Texto' => 'Nunca',
            'FK_RPG_Pregunta' => $pregunta,
            'FK_RPG_PonderacionRespuesta' => $ponderaciont3p20
        ]);
        //Pregunta 6
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿Cómo califica usted los espacios que la Universidad de Cundinamarca  le ofrece para participar en Grupos o centros de estudio?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿Cómo califica usted los espacios que la Universidad de Cundinamarca  le ofrece para participar en Grupos o centros de estudio?')->value('PK_PGT_Id');
        //Pregunta 7
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿Qué opinión tiene con respecto a la pertinencia del reglamento estudiantil de la UDEC? (entendida la pertinencia como oportuno, adecuado y conveniente)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿Qué opinión tiene con respecto a la pertinencia del reglamento estudiantil de la UDEC? (entendida la pertinencia como oportuno, adecuado y conveniente)')->value('PK_PGT_Id');
        //Pregunta 8
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'En relación con la  selección, vinculación y permanencia de los docentes en la UDEC, conoce Usted Las políticas y criterios establecidos por la institución para la selección, vinculación y permanencia de los docentes (continuidad en su contratación)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta3,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','En relación con la  selección, vinculación y permanencia de los docentes en la UDEC, conoce Usted Las políticas y criterios establecidos por la institución para la selección, vinculación y permanencia de los docentes (continuidad en su contratación)')->value('PK_PGT_Id');
        //Pregunta 9
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Según su concepto, la calidad de los materiales de apoyo (guías, talleres, libros, presentaciones, formatos, etc.) producidos por los docentes del programa es:',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Según su concepto, la calidad de los materiales de apoyo (guías, talleres, libros, presentaciones, formatos, etc.) producidos por los docentes del programa es:')->value('PK_PGT_Id');
        //pregunta 10
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Teniendo en cuenta que el currículo de un programa comprende, entre otras cosas: el plan de estudios, los docentes, los ambientes de aprendizaje, la formación integral, los materiales de apoyo; ¿Cuál es su opinión acerca de la calidad e integralidad del currículo del programa que estudia?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Teniendo en cuenta que el currículo de un programa comprende, entre otras cosas: el plan de estudios, los docentes, los ambientes de aprendizaje, la formación integral, los materiales de apoyo; ¿Cuál es su opinión acerca de la calidad e integralidad del currículo del programa que estudia?')->value('PK_PGT_Id');     
        //Pregunta 11   
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Teniendo en cuenta que un currículo flexible propone alternativas diferentes a la concepción lineal de los estudios, presentando diversas opciones para la formación profesional del estudiante: asignaturas electivas, homologación de estudios previos y conocimientos prácticos, formación según el ritmo de aprendizaje del estudiante, etc. La flexibilidad del currículo del programa que usted estudia es:',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Teniendo en cuenta que un currículo flexible propone alternativas diferentes a la concepción lineal de los estudios, presentando diversas opciones para la formación profesional del estudiante: asignaturas electivas, homologación de estudios previos y conocimientos prácticos, formación según el ritmo de aprendizaje del estudiante, etc. La flexibilidad del currículo del programa que usted estudia es:')->value('PK_PGT_Id');
        //Pregunta 12              
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'La interdisciplinariedad, es la articulación entre diferentes áreas de conocimiento para abordar problemas propios del programa. De acuerdo a esta definición, ¿Cómo considera que ha contribuido la interdisciplinariedad al enriquecimiento de la calidad del programa que usted estudia?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','La interdisciplinariedad, es la articulación entre diferentes áreas de conocimiento para abordar problemas propios del programa. De acuerdo a esta definición, ¿Cómo considera que ha contribuido la interdisciplinariedad al enriquecimiento de la calidad del programa que usted estudia?')->value('PK_PGT_Id');
        //Pregunta 13
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿Considera usted que las metodologías de enseñanza-aprendizaje empleadas por los docentes del programa responden a las necesidades de formación?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿Considera usted que las metodologías de enseñanza-aprendizaje empleadas por los docentes del programa responden a las necesidades de formación?')->value('PK_PGT_Id');
        //Pregunta 14    
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'En su opinión, ¿El sistema de evaluación que se aplica a los estudiantes contribuye a la adquisición de las actitudes, los conocimientos, capacidades y habilidades que requiere su profesión?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','En su opinión, ¿El sistema de evaluación que se aplica a los estudiantes contribuye a la adquisición de las actitudes, los conocimientos, capacidades y habilidades que requiere su profesión?')->value('PK_PGT_Id');
        //Preunta 15
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'La autoevaluación es el proceso por medio del cual los programas de formación identifican sus fortalezas y debilidades y realizan mejora continua, regulándose a si mismos para alcanzar altos niveles de calidad.  De acuerdo a esta definición y según su opinión, ¿los procesos de  autoevaluación y autorregulación del programa donde usted estudia, han contribuido a la mejora en la calidad del mismo?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','La autoevaluación es el proceso por medio del cual los programas de formación identifican sus fortalezas y debilidades y realizan mejora continua, regulándose a si mismos para alcanzar altos niveles de calidad.  De acuerdo a esta definición y según su opinión, ¿los procesos de  autoevaluación y autorregulación del programa donde usted estudia, han contribuido a la mejora en la calidad del mismo?')->value('PK_PGT_Id');
        //Pregunta 16      
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Según su apreciación, ¿cómo califica el impacto que el programa ejerce en el medio (la región de influencia) a través de los proyectos y actividades que desarrolla?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Según su apreciación, ¿cómo califica el impacto que el programa ejerce en el medio (la región de influencia) a través de los proyectos y actividades que desarrolla?')->value('PK_PGT_Id');
        //Pregunta 17
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'El material bibliográfico disponible  (Libros, revistas, bases de datos, etc) ¿es suficiente para las necesidades de los estudiantes y docentes?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','El material bibliográfico disponible  (Libros, revistas, bases de datos, etc) ¿es suficiente para las necesidades de los estudiantes y docentes?')->value('PK_PGT_Id');
        //Pregunta 18
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Los recursos informáticos disponibles  (computadores, software, redes, etc)¿responden a las necesidades del programa? (¿son pertinentes?)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Los recursos informáticos disponibles  (computadores, software, redes, etc)¿responden a las necesidades del programa? (¿son pertinentes?)')->value('PK_PGT_Id');
        //Pregunta 19
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿El programa ha recibido estudiantes extranjeros (pasantia, homologacion, cursos) en los ultimos cinco años ?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿El programa ha recibido estudiantes extranjeros (pasantia, homologacion, cursos) en los ultimos cinco años ?')->value('PK_PGT_Id');
        //Pregunta 20
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿Considera usted que el programa y los docentes utilizan mecanismos para incentivar en los estudiantes la generación de ideas, problemas de investigación y la identificación de problemas en el ámbito empresarial susceptibles de resolver?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿Considera usted que el programa y los docentes utilizan mecanismos para incentivar en los estudiantes la generación de ideas, problemas de investigación y la identificación de problemas en el ámbito empresarial susceptibles de resolver?')->value('PK_PGT_Id');
        //Pregunta 21
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿Cómo califica la forma en que la institución promueve la investigación, la innovación, la creación artística y cultural?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿Cómo califica la forma en que la institución promueve la investigación, la innovación, la creación artística y cultural?')->value('PK_PGT_Id');
        //Pregunta 22
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Durante su estancia en la institución ¿Ha utilizado o participado en actividades, programas o servicios ofrecidos por Bienestar Universitario?',
                        'FK_PGT_Estado' => $estado,
'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Durante su estancia en la institución ¿Ha utilizado o participado en actividades, programas o servicios ofrecidos por Bienestar Universitario?')->value('PK_PGT_Id');
        //Pregunta 23
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Considera usted que las condiciones y exigencias académicas de permanencia y graduación en el programa, ¿corresponden a lo esperado para este tipo de programas de formación?.',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta3,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Considera usted que las condiciones y exigencias académicas de permanencia y graduación en el programa, ¿corresponden a lo esperado para este tipo de programas de formación?.')->value('PK_PGT_Id');
        //Pregunta 24
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Califique las siguientes características de los procesos administrativos (inscripción, matrícula, reporte de horas, etc) del programa en el que usted estudia, con respecto a la: Eficiencia (uso adecuado de recursos físicos, humanos, tecnológicos, de información etc.)Califique las siguientes características de los procesos administrativos (inscripción, matrícula, reporte de horas, etc) del programa en el que usted estudia, con respecto a la: Eficiencia (uso adecuado de recursos físicos, humanos, tecnológicos, de información etc.)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Califique las siguientes características de los procesos administrativos (inscripción, matrícula, reporte de horas, etc) del programa en el que usted estudia, con respecto a la: Eficiencia (uso adecuado de recursos físicos, humanos, tecnológicos, de información etc.)')->value('PK_PGT_Id');
        //Pregunta 25
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Califique la eficacia de: Los sistemas de información académica de la institución y del programa (sistema de notas, registro académico, etc)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Califique la eficacia de: Los sistemas de información académica de la institución y del programa (sistema de notas, registro académico, etc)')->value('PK_PGT_Id');
        //Pregunta 26
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Califique la siguiente característica de la planta física de la institución y los espacios que usan los programas (así sean estos propios o en arriendo) según: Facilidad de acceso (accesibilidad)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Califique la siguiente característica de la planta física de la institución y los espacios que usan los programas (así sean estos propios o en arriendo) según: Facilidad de acceso (accesibilidad)')->value('PK_PGT_Id');
        //Preguntas 27
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Según su apreciación, ¿Cómo califica la suficiencia y ejecución de los recursos presupuestales de que se dispone el programa de formación para sus actividades misionales?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Según su apreciación, ¿Cómo califica la suficiencia y ejecución de los recursos presupuestales de que se dispone el programa de formación para sus actividades misionales?')->value('PK_PGT_Id');
        //Preguntas 28
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿En su programa se tienen en cuenta los resultados de la evaluación hecha por los estudiantes a los profesores?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿En su programa se tienen en cuenta los resultados de la evaluación hecha por los estudiantes a los profesores?')->value('PK_PGT_Id');
        //Preguntasn 29
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'En su concepto, ¿las políticas, los servicios y actividades de Bienestar Universitario responden a las necesidades de la comunidad universitaria y el desarrollo de usted como persona?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','En su concepto, ¿las políticas, los servicios y actividades de Bienestar Universitario responden a las necesidades de la comunidad universitaria y el desarrollo de usted como persona?')->value('PK_PGT_Id');
        //Preguntas 30
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Según su experiencia, ¿en la Universidad de Cundinamarca existe acceso con calidad a los sistemas de comunicación e información mediados por las Tecnologías de la Información y la Comunicación (TIC)?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Según su experiencia, ¿en la Universidad de Cundinamarca existe acceso con calidad a los sistemas de comunicación e información mediados por las Tecnologías de la Información y la Comunicación (TIC)?')->value('PK_PGT_Id');
        //Pregunta 31
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Considera que la institución aplica políticas que propicien la participación del profesorado en los órganos de dirección del programa y de la institución?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Considera que la institución aplica políticas que propicien la participación del profesorado en los órganos de dirección del programa y de la institución?')->value('PK_PGT_Id');
        //Pregunta 32
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Exprese su opinión acerca de la calidad, suficiencia y dedicación de profesores del programa que estudia: La calidad de los docentes del programa es:',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Exprese su opinión acerca de la calidad, suficiencia y dedicación de profesores del programa que estudia: La calidad de los docentes del programa es:')->value('PK_PGT_Id');
        //Pregunta 33
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Según su apreciación, ¿Qué impacto han tenido en la calidad del programa, las acciones orientadas al desarrollo integral de los profesores?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Según su apreciación, ¿Qué impacto han tenido en la calidad del programa, las acciones orientadas al desarrollo integral de los profesores?')->value('PK_PGT_Id');
        //Pregunta 34
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Según su apreciación, ¿Qué impacto han tenido en la calidad del programa, los estímulos que ofrece la institución a los docentes por el ejercicio calificado de sus labores (docencia, la investigación, la innovación, la creación artística y cultural la cooperación internacional, entre otros)',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Según su apreciación, ¿Qué impacto han tenido en la calidad del programa, los estímulos que ofrece la institución a los docentes por el ejercicio calificado de sus labores (docencia, la investigación, la innovación, la creación artística y cultural la cooperación internacional, entre otros)')->value('PK_PGT_Id');
        //Pregunta 35
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'De acuerdo a su experiencia ¿Cuál es el nivel de correspondencia entre la remuneración y los méritos académicos y profesionales de los docentes en la UDEC?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','De acuerdo a su experiencia ¿Cuál es el nivel de correspondencia entre la remuneración y los méritos académicos y profesionales de los docentes en la UDEC?')->value('PK_PGT_Id');
        //Pregunta 36
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Según su opinión, los criterios y mecanismos de transparencia, equidad y eficiencia que la UDEC utiliza para evaluar a sus docentes son:',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Según su opinión, los criterios y mecanismos de transparencia, equidad y eficiencia que la UDEC utiliza para evaluar a sus docentes son:')->value('PK_PGT_Id');
        //Pregunta 37
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Considera Usted que la calidad de los trabajos académicos realizados por los estudiantes, ¿Corresponden a los objetivos de logro definidos para el programa y la formación personal esperada?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Considera Usted que la calidad de los trabajos académicos realizados por los estudiantes, ¿Corresponden a los objetivos de logro definidos para el programa y la formación personal esperada?')->value('PK_PGT_Id');
        //Pregunta 38
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Manifieste su apreciación sobre la capacidad, dotación, disponibilidad y frecuencia de uso  de laboratorios o aulas especializadas que usa el programa en el cual usted es docente',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta5,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Manifieste su apreciación sobre la capacidad, dotación, disponibilidad y frecuencia de uso  de laboratorios o aulas especializadas que usa el programa en el cual usted es docente')->value('PK_PGT_Id');
        //Pregunta 39
        $pregunta = Pregunta::create([
                        'PGT_Texto' => '¿El programa ha realizado estudios de comparabilidad con otros programas de la misma naturaleza, durante los ultimos cinco años a nivel nacional ?',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta2,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','¿El programa ha realizado estudios de comparabilidad con otros programas de la misma naturaleza, durante los ultimos cinco años a nivel nacional ?')->value('PK_PGT_Id');
        //Pregunta 40
        $pregunta = Pregunta::create([
                        'PGT_Texto' => 'Califique los siguientes aspectos relacionados con los directivos del programa de formación (Decano, director/coordinador de programa)  que se está evaluando: el liderazgo que ejercen los directivos del programa.',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','Califique los siguientes aspectos relacionados con los directivos del programa de formación (Decano, director/coordinador de programa)  que se está evaluando: el liderazgo que ejercen los directivos del programa.')->value('PK_PGT_Id');

        $pregunta = Pregunta::create([
                        'PGT_Texto' => '',
                        'FK_PGT_Estado' => $estado,
                        'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
                        'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
                    ]);
        $pregunta = Pregunta::where('PGT_Texto','')->value('PK_PGT_Id');



    }
}
