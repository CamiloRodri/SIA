<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Aspecto;
use App\Models\Autoevaluacion\Caracteristica;

class AspectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Caracteristica 1
        $caracteristica = Caracteristica::where('CRT_Nombre','MISIÓN, VISIÓN Y PROYECTO INSTITUCIONAL')->value('PK_CRT_Id');
        Aspecto::create([
        	'ASP_Nombre' => 'Apropiación de la visión y la misión institucional por parte de la comunidad académica.',
        	'ASP_Descripcion' => 'Apropiación de la visión y la misión institucional por parte de la comunidad académica.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
        ]);

        Aspecto::create([
        	'ASP_Nombre' => 'Correspondencia entre la visión y la misión institucional y los objetivos del programa académico',
        	'ASP_Descripcion' => 'Correspondencia entre la visión y la misión institucional y los objetivos del programa académico',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
        ]);

        Aspecto::create([
        	'ASP_Nombre' => 'El proyecto institucional orienta las acciones y decisiones del programa académico, en la gestión del currículo, la docencia, la investigación científica, la creación artística, la internacionalización, la proyección social, el bienestar de la comunidad institucional y demás áreas estratégicas de la institución.',
        	'ASP_Descripcion' => 'El proyecto institucional orienta las acciones y decisiones del programa académico, en la gestión del currículo, la docencia, la investigación científica, la creación artística, la internacionalización, la proyección social, el bienestar de la comunidad institucional y demás áreas estratégicas de la institución.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
        ]);
        Aspecto::create([
        	'ASP_Nombre' => 'La institución cuenta con una política eficaz y tiene evidencias sobre alternativas de financiación para facilitar el ingreso y permanencia de los estudiantes que evidencian dificultades económicas.',
        	'ASP_Descripcion' => 'La institución cuenta con una política eficaz y tiene evidencias sobre alternativas de financiación para facilitar el ingreso y permanencia de los estudiantes que evidencian dificultades económicas.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
        ]);
        Aspecto::create([
        	'ASP_Nombre' => 'La institución aplica una política eficaz que permite el acceso a la educación superior sin discriminación. Promueve estrategias eficaces orientadas a identificar, eliminar o disminuir barreras comunicativas para poblaciones diversas.',
        	'ASP_Descripcion' => 'La institución aplica una política eficaz que permite el acceso a la educación superior sin discriminación. Promueve estrategias eficaces orientadas a identificar, eliminar o disminuir barreras comunicativas para poblaciones diversas.',
        	'ASP_Identificador' => 'e',
        	'FK_ASP_Caracteristica' => $caracteristica,
        ]);
        Aspecto::create([
        	'ASP_Nombre' => 'La institución cuenta con una política eficaz orientada a identificar, eliminar o disminuir barreras en infraestructura física. La institución tiene evidencias sobre la ',
        	'ASP_Descripcion' => 'La institución cuenta con una política eficaz orientada a identificar, eliminar o disminuir barreras en infraestructura física. La institución tiene evidencias sobre la',
        	'ASP_Identificador' => 'f',
        	'FK_ASP_Caracteristica' => $caracteristica,
        ]);
        //Caracteristica 2
        $caracteristica = Caracteristica::where('CRT_Nombre','PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id');
        Aspecto::create([
        	'ASP_Nombre' => 'Estrategias y mecanismos establecidos para la discusión, actualización y difusión del Proyecto Educativo del Programa académico.',
        	'ASP_Descripcion' => 'Estrategias y mecanismos establecidos para la discusión, actualización y difusión del Proyecto Educativo del Programa académico.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
        ]);
        Aspecto::create([
        	'ASP_Nombre' => 'Apropiación del Proyecto Educativo del Programa por parte de la comunidad académica del programa.',
        	'ASP_Descripcion' => 'Apropiación del Proyecto Educativo del Programa por parte de la comunidad académica del programa.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Modelo pedagógico o concepción de aprendizaje que sustentan la metodología de enseñanza en que se ofrece el programa evaluado.',
        	'ASP_Descripcion' => 'Modelo pedagógico o concepción de aprendizaje que sustentan la metodología de enseñanza en que se ofrece el programa evaluado.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,		
        ]);
		Aspecto::create([
        	'ASP_Nombre' => 'Coherencia entre el Proyecto Educativo del Programa y las actividades académicas desarrolladas.',
        	'ASP_Descripcion' => 'Coherencia entre el Proyecto Educativo del Programa y las actividades académicas desarrolladas.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 3
		$caracteristica = Caracteristica::where('CRT_Nombre','RELEVANCIA ACADÉMICA Y PERTINENCIA SOCIAL DEL PROGRAMA')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Análisis realizados sobre las tendencias y líneas de desarrollo de la disciplina o profesión en el ámbito local, regional, nacional e internacional, y su incidencia en el programa.',
        	'ASP_Descripcion' => 'Análisis realizados sobre las tendencias y líneas de desarrollo de la disciplina o profesión en el ámbito local, regional, nacional e internacional, y su incidencia en el programa.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Estudios orientados a identificar las necesidades y requerimientos del entorno laboral (local, regional y nacional) en términos productivos y de competitividad, tecnológicos y de talento humano. Acciones del programa para atenderlos. ',
        	'ASP_Descripcion' => 'Estudios orientados a identificar las necesidades y requerimientos del entorno laboral (local, regional y nacional) en términos productivos y de competitividad, tecnológicos y de talento humano. Acciones del programa para atenderlos. ',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Estudios que demuestren la necesidad social del programa en la metodología que se ofrece',
        	'ASP_Descripcion' => 'Estudios que demuestren la necesidad social del programa en la metodología que se ofrece',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Correspondencia entre el perfil laboral y ocupacional del sector y el perfil profesional ',
        	'ASP_Descripcion' => 'Correspondencia entre el perfil laboral y ocupacional del sector y el perfil profesional ',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 4
		$caracteristica = Caracteristica::where('CRT_Nombre','MECANISMOS DE SELECCIÓN DE INGRESOS')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Mecanismos de ingreso que garanticen transparencia en la selección de los estudiantes.',
        	'ASP_Descripcion' => 'Mecanismos de ingreso que garanticen transparencia en la selección de los estudiantes.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Estudiantes que ingresaron mediante la aplicación de reglas generales y mecanismos de admisión excepcionales, en los últimos cinco años.',
        	'ASP_Descripcion' => 'Estudiantes que ingresaron mediante la aplicación de reglas generales y mecanismos de admisión excepcionales, en los últimos cinco años.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Existencia y utilización de sistemas y mecanismos de evaluación de los procesos de selección y admisión, y aplicación de los resultados de dicha evaluación.',
        	'ASP_Descripcion' => 'Existencia y utilización de sistemas y mecanismos de evaluación de los procesos de selección y admisión, y aplicación de los resultados de dicha evaluación.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Requerimientos para el ingreso de estudiantes en condición de transferencia, homologación u otro proceso que amerite criterios específicos para el tránsito entre ciclos, niveles y/o instituciones. Beneficios de estos requerimientos en la formación integral de ',
        	'ASP_Descripcion' => 'Requerimientos para el ingreso de estudiantes en condición de transferencia, homologación u otro proceso que amerite criterios específicos para el tránsito entre ciclos, niveles y/o instituciones. Beneficios de estos requerimientos en la formación integral de ',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//carecteristica 5
		$caracteristica = Caracteristica::where('CRT_Nombre','ESTUDIANTES ADMITIDOS Y CAPACIDAD INSTITUCIONAL')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Políticas institucionales para la definición del número de estudiantes que se admiten al programa, acorde con el cuerpo docente, los recursos físicos y de apoyo académico disponibles. ',
        	'ASP_Descripcion' => 'Políticas institucionales para la definición del número de estudiantes que se admiten al programa, acorde con el cuerpo docente, los recursos físicos y de apoyo académico disponibles. ',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de profesores y estudiantes del programa con respecto a la relación entre el número de admitidos, el cuerpo docente y los recursos académicos y físicos disponibles.',
        	'ASP_Descripcion' => 'Apreciación de profesores y estudiantes del programa con respecto a la relación entre el número de admitidos, el cuerpo docente y los recursos académicos y físicos disponibles.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Población de estudiantes que ingreso al programa en los últimos cinco años, el puntaje promedio obtenido por los admitidos en las Pruebas de Estado, el puntaje promedio estandarizado en pruebas de admisión cuando éstas se realicen, el puntaje mínimo aceptable para ingresar y la capacidad de selección y absorción de estudiantes por parte del programa (relación entre inscritos y admitidos, relación entre inscritos y matriculados).',
        	'ASP_Descripcion' => 'Población de estudiantes que ingreso al programa en los últimos cinco años, el puntaje promedio obtenido por los admitidos en las Pruebas de Estado, el puntaje promedio estandarizado en pruebas de admisión cuando éstas se realicen, el puntaje mínimo aceptable para ingresar y la capacidad de selección y absorción de estudiantes por parte del programa (relación entre inscritos y admitidos, relación entre inscritos y matriculados).',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'En los programas de salud, donde sea pertinente, evidenciar la utilización de escenarios de práctica requeridos para cumplir con los objetivos del programa.',
        	'ASP_Descripcion' => 'En los programas de salud, donde sea pertinente, evidenciar la utilización de escenarios de práctica requeridos para cumplir con los objetivos del programa.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Evidenciar que los convenios de docencia – servicio se realizan a largo plazo y con IPS acreditadas o con Hospitales Universitarios y en ellos la dinámica interinstitucional denota equilibrio y reciprocidad.',
        	'ASP_Descripcion' => 'Evidenciar que los convenios de docencia – servicio se realizan a largo plazo y con IPS acreditadas o con Hospitales Universitarios y en ellos la dinámica interinstitucional denota equilibrio y reciprocidad.',
        	'ASP_Identificador' => 'e',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'En los programas de salud, donde sea pertinente, evidenciar que la relación entre el número de estudiantes y la capacidad instalada de los escenarios de práctica (camas, docentes, tutores, investigadores, entre otros) es adecuada y suficiente.',
        	'ASP_Descripcion' => 'En los programas de salud, donde sea pertinente, evidenciar que la relación entre el número de estudiantes y la capacidad instalada de los escenarios de práctica (camas, docentes, tutores, investigadores, entre otros) es adecuada y suficiente.',
        	'ASP_Identificador' => 'f',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'En los programas de salud, donde sea pertinente, evidenciar adecuadas rotaciones y entrenamiento médico. Los profesores-médicos que tienen a cargo los programas de docencia de servicio cuentan con el nivel de formación adecuado y la experiencia requerida.',
        	'ASP_Descripcion' => 'En los programas de salud, donde sea pertinente, evidenciar adecuadas rotaciones y entrenamiento médico. Los profesores-médicos que tienen a cargo los programas de docencia de servicio cuentan con el nivel de formación adecuado y la experiencia requerida.',
        	'ASP_Identificador' => 'g',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 6
		$caracteristica = Caracteristica::where('CRT_Nombre','PARTICIPACIÓN DE ACTIVIDADES DE FORMACIÓN INTEGRAL')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Políticas y estrategias definidas por el programa en materia de formación integral de los estudiantes.',
        	'ASP_Descripcion' => 'Políticas y estrategias definidas por el programa en materia de formación integral de los estudiantes.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de los estudiantes sobre la calidad de los espacios y estrategias que ofrece el programa, de acuerdo con la naturaleza y orientación de éste, para la participación en grupos o centros de estudio, proyectos de experimentación o de desarrollo empresarial y demás actividades académicas y culturales distintas de la docencia que contribuyan a su formación integral.',
        	'ASP_Descripcion' => 'Apreciación de los estudiantes sobre la calidad de los espacios y estrategias que ofrece el programa, de acuerdo con la naturaleza y orientación de éste, para la participación en grupos o centros de estudio, proyectos de experimentación o de desarrollo empresarial y demás actividades académicas y culturales distintas de la docencia que contribuyan a su formación integral.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		;Aspecto::create([
        	'ASP_Nombre' => 'Estudiantes que participan efectivamente en grupos o centros de estudio, proyectos de experimentación o de desarrollo empresarial o en las demás actividades académicas y culturales distintas de la docencia que brinda la institución o el programa para contribuir a la formación integral.',
        	'ASP_Descripcion' => 'Estudiantes que participan efectivamente en grupos o centros de estudio, proyectos de experimentación o de desarrollo empresarial o en las demás actividades académicas y culturales distintas de la docencia que brinda la institución o el programa para contribuir a la formación integral.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteritica 7
		$caracteristica = Caracteristica::where('CRT_Nombre','REGLAMENTOS ESTUDIANTIL Y ACADÉMICO')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Mecanismos utilizados para la divulgación del reglamento estudiantil y académico.',
        	'ASP_Descripcion' => 'Mecanismos utilizados para la divulgación del reglamento estudiantil y académico.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de estudiantes y profesores del programa sobre la pertinencia, vigencia y aplicación del reglamento estudiantil y académico.',
        	'ASP_Descripcion' => 'Apreciación de estudiantes y profesores del programa sobre la pertinencia, vigencia y aplicación del reglamento estudiantil y académico.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Evidencias sobre la aplicación de las normas establecidas en los reglamentos estudiantil y académico para atender las situaciones presentadas con los estudiantes.',
        	'ASP_Descripcion' => 'Evidencias sobre la aplicación de las normas establecidas en los reglamentos estudiantil y académico para atender las situaciones presentadas con los estudiantes.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de directivos, profesores y estudiantes sobre la participación del estudiantado en los órganos de dirección del programa.',
        	'ASP_Descripcion' => 'Apreciación de directivos, profesores y estudiantes sobre la participación del estudiantado en los órganos de dirección del programa.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Políticas y estrategias sobre estímulos académicos para los estudiantes. El programa tiene evidencias sobre la aplicación de estas políticas y estrategias.',
        	'ASP_Descripcion' => 'Políticas y estrategias sobre estímulos académicos para los estudiantes. El programa tiene evidencias sobre la aplicación de estas políticas y estrategias.',
        	'ASP_Identificador' => 'e',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 8
		$caracteristica = Caracteristica::where('CRT_Nombre','SELECCIÓN, VINCULACIÓN Y PERMANENCIA DE PROFESORES')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Aplicación de las políticas, las normas y los criterios académicos establecidos por la institución para la selección y la vinculación de los profesores',
        	'ASP_Descripcion' => 'Aplicación de las políticas, las normas y los criterios académicos establecidos por la institución para la selección y la vinculación de los profesores',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Estrategias de la Institución para propiciar la permanencia de los profesores en el programa y el relevo generacional.',
        	'ASP_Descripcion' => 'Estrategias de la Institución para propiciar la permanencia de los profesores en el programa y el relevo generacional.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de directivos, profesores y estudiantes sobre la aplicación, pertinencia y vigencia de las políticas, las normas y los criterios académicos establecidos por la institución para la selección, vinculación y permanencia de sus profesores.',
        	'ASP_Descripcion' => 'Apreciación de directivos, profesores y estudiantes sobre la aplicación, pertinencia y vigencia de las políticas, las normas y los criterios académicos establecidos por la institución para la selección, vinculación y permanencia de sus profesores.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caacteristica 9
		$caracteristica = Caracteristica::where('CRT_Nombre','ESTATUTO PROFESIONAL')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Mecanismos de divulgación del estatuto profesoral',
        	'ASP_Descripcion' => 'Mecanismos de divulgación del estatuto profesoral',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de directivos y profesores del programa sobre la pertinencia, vigencia y aplicación del estatuto profesoral.',
        	'ASP_Descripcion' => 'Apreciación de directivos y profesores del programa sobre la pertinencia, vigencia y aplicación del estatuto profesoral.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Información actualizada sobre el número de profesores adscritos a la facultad, al programa o departamento que sirva al mismo, por categorías académicas establecidas en el escalafón.',
        	'ASP_Descripcion' => 'Información actualizada sobre el número de profesores adscritos a la facultad, al programa o departamento que sirva al mismo, por categorías académicas establecidas en el escalafón.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteritica 10
		$caracteristica = Caracteristica::where('CRT_Nombre','NUMERO, DEDICACIÓN, NIVEL DE FORMACIÓN Y EXPERIENCIA DE PROFESORES')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Profesores de planta con título de especialización, maestría y doctorado en relación con el objeto de conocimiento del programa adscritos directamente o a través de la facultad o departamento respectivo, e información demostrada acerca de las instituciones en las cuales fueron formados.',
        	'ASP_Descripcion' => 'Profesores de planta con título de especialización, maestría y doctorado en relación con el objeto de conocimiento del programa adscritos directamente o a través de la facultad o departamento respectivo, e información demostrada acerca de las instituciones en las cuales fueron formados.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Profesores del programa adscritos en forma directa o a través de la facultad o departamento respectivo con dedicación de tiempo completo, medio tiempo y cátedra, según nivel de formación.',
        	'ASP_Descripcion' => 'Profesores del programa adscritos en forma directa o a través de la facultad o departamento respectivo con dedicación de tiempo completo, medio tiempo y cátedra, según nivel de formación. ',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Tiempos de cada profesor del programa adscritos directamente o a través de la facultad o departamento respectivo, dedicados a la docencia (incluyendo el desarrollo de productos, artefactos, materiales y prototipos, entre otros), a la investigación, a la creación artística, a la extensión o proyección social, a la atención de funciones de gestión académica o administrativa, a la tutoría individual de los estudiantes, de acuerdo con la naturaleza del programa.',
        	'ASP_Descripcion' => 'Tiempos de cada profesor del programa adscritos directamente o a través de la facultad o departamento respectivo, dedicados a la docencia (incluyendo el desarrollo de productos, artefactos, materiales y prototipos, entre otros), a la investigación, a la creación artística, a la extensión o proyección social, a la atención de funciones de gestión académica o administrativa, a la tutoría individual de los estudiantes, de acuerdo con la naturaleza del programa.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Tiempos de los profesores de cátedra dedicados a las tutorías, el acompañamiento de estudiante y el desarrollo de competencias, especialmente actitudes, conocimientos, capacidades y habilidades.',
        	'ASP_Descripcion' => 'Tiempos de los profesores de cátedra dedicados a las tutorías, el acompañamiento de estudiante y el desarrollo de competencias, especialmente actitudes, conocimientos, capacidades y habilidades.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Experiencia profesional y/o académica de los profesores, según necesidades y exigencias del programa para el desarrollo óptimo de sus funciones sustantivas.',
        	'ASP_Descripcion' => 'Experiencia profesional y/o académica de los profesores, según necesidades y exigencias del programa para el desarrollo óptimo de sus funciones sustantivas.',
        	'ASP_Identificador' => 'e',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Suficiencia del número de profesores con relación a la cantidad de estudiantes del programa y sus necesidades de formación de acuerdo con el proyecto educativo. ',
        	'ASP_Descripcion' => 'Suficiencia del número de profesores con relación a la cantidad de estudiantes del programa y sus necesidades de formación de acuerdo con el proyecto educativo. ',
        	'ASP_Identificador' => 'f',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de directivos, profesores y estudiantes del programa adscritos directamente o a través de la facultad o departamento respectivo, sobre la calidad y la suficiencia del número y de la dedicación de los profesores al servicio de éste.',
        	'ASP_Descripcion' => 'Apreciación de directivos, profesores y estudiantes del programa adscritos directamente o a través de la facultad o departamento respectivo, sobre la calidad y la suficiencia del número y de la dedicación de los profesores al servicio de éste.',
        	'ASP_Identificador' => 'g',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de directivos, profesores y estudiantes del programa adscritos directamente o a través de la facultad o departamento respectivo, sobre la calidad y la suficiencia del número y de la dedicación de los profesores al servicio de éste.',
        	'ASP_Descripcion' => 'Apreciación de directivos, profesores y estudiantes del programa adscritos directamente o a través de la facultad o departamento respectivo, sobre la calidad y la suficiencia del número y de la dedicación de los profesores al servicio de éste.',
        	'ASP_Identificador' => 'h',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//carectistica 11
		$caracteristica = Caracteristica::where('CRT_Nombre','DESARROLLO PROFESIONAL')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Políticas institucionales y evidencias de aplicación, en materia de desarrollo integral del profesorado, que incluyan la capacitación y actualización en los aspectos académicos, profesionales y pedagógicos relacionados con la metodología del programa.',
        	'ASP_Descripcion' => 'Políticas institucionales y evidencias de aplicación, en materia de desarrollo integral del profesorado, que incluyan la capacitación y actualización en los aspectos académicos, profesionales y pedagógicos relacionados con la metodología del programa.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Número de profesores del programa adscritos directamente o a través de la facultad o departamento respectivo, que han participado en los últimos cinco años en programas de desarrollo profesoral o que han recibido apoyo a la capacitación y actualización permanente, como resultado de las políticas institucionales orientadas para tal fin.',
        	'ASP_Descripcion' => 'Número de profesores del programa adscritos directamente o a través de la facultad o departamento respectivo, que han participado en los últimos cinco años en programas de desarrollo profesoral o que han recibido apoyo a la capacitación y actualización permanente, como resultado de las políticas institucionales orientadas para tal fin.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de directivos y profesores del programa adscritos directamente o a través de la facultad o departamento respectivo, sobre el impacto que han tenido las acciones orientadas al desarrollo integral de los profesores, en el enriquecimiento de la calidad del programa.',
        	'ASP_Descripcion' => 'Apreciación de directivos y profesores del programa adscritos directamente o a través de la facultad o departamento respectivo, sobre el impacto que han tenido las acciones orientadas al desarrollo integral de los profesores, en el enriquecimiento de la calidad del programa.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Acompañamiento por expertos, para la cualificación de la labor pedagógica de los profesores, de acuerdo con el tipo y metodología del programa.',
        	'ASP_Descripcion' => 'Acompañamiento por expertos, para la cualificación de la labor pedagógica de los profesores, de acuerdo con el tipo y metodología del programa.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Reconocimiento a los profesores que participan en procesos de creación artística y cultural.',
        	'ASP_Descripcion' => 'Reconocimiento a los profesores que participan en procesos de creación artística y cultural.',
        	'ASP_Identificador' => 'e',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Estrategias orientadas a la actualización docente en temas relacionados con la atención a la diversidad poblacional.',
        	'ASP_Descripcion' => 'Estrategias orientadas a la actualización docente en temas relacionados con la atención a la diversidad poblacional.',
        	'ASP_Identificador' => 'f',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 12
		$caracteristica = Caracteristica::where('CRT_Nombre','ESTIMULOS A LA DOCENCIA, INVESTIGACIÓN, CREACIÓN ARTISTICA Y CULTURAL, EXTENSIÓN O PROYECCIÓN SOCIAL Y A LA COOPERACIÓN INTERNACIONAL')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Políticas de estímulo y reconocimiento a los profesores por el ejercicio calificado de la docencia, de la investigación, de la innovación, de la creación artística, de la técnica y tecnología, de la extensión o proyección social y de la cooperación internacional. Evidencias de la aplicación de estas políticas.',
        	'ASP_Descripcion' => 'Políticas de estímulo y reconocimiento a los profesores por el ejercicio calificado de la docencia, de la investigación, de la innovación, de la creación artística, de la técnica y tecnología, de la extensión o proyección social y de la cooperación internacional. Evidencias de la aplicación de estas políticas.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Estrategias que promueven la creación artística y cultural, la innovación, la adaptación, la transferencia técnica y tecnológica, la creación de tecnofactos y prototipos, y la obtención de patentes, de acuerdo con la naturaleza del programa.',
        	'ASP_Descripcion' => 'Estrategias que promueven la creación artística y cultural, la innovación, la adaptación, la transferencia técnica y tecnológica, la creación de tecnofactos y prototipos, y la obtención de patentes, de acuerdo con la naturaleza del programa.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de directivos y profesores del programa, adscritos directamente o a través de la facultad o departamento respectivo, sobre el impacto que, para el enriquecimiento de la calidad del programa ha tenido el régimen de estímulos al profesorado por el ejercicio calificado de la docencia, la investigación, la innovación, la creación artística y cultural, la extensión o proyección social, los aportes al desarrollo técnico y tecnológico y la cooperación internacional.',
        	'ASP_Descripcion' => 'Apreciación de directivos y profesores del programa, adscritos directamente o a través de la facultad o departamento respectivo, sobre el impacto que, para el enriquecimiento de la calidad del programa ha tenido el régimen de estímulos al profesorado por el ejercicio calificado de la docencia, la investigación, la innovación, la creación artística y cultural, la extensión o proyección social, los aportes al desarrollo técnico y tecnológico y la cooperación internacional.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 13
		$caracteristica = Caracteristica::where('CRT_Nombre','PRODUCCIÓN, PERTINENCIA, UTILIZACIÓN E IMPACTO MATERIAL DOCENTE')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Producción, utilización y evaluación de materiales de apoyo docente, en los últimos cinco años, pertinentes a la naturaleza y metodología del programa y su función pedagógica.',
        	'ASP_Descripcion' => 'Producción, utilización y evaluación de materiales de apoyo docente, en los últimos cinco años, pertinentes a la naturaleza y metodología del programa y su función pedagógica.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de los estudiantes del programa sobre la calidad de los materiales de apoyo producidos o utilizados por los profesores adscritos al programa y su pertinencia de acuerdo con la metodología del programa.',
        	'ASP_Descripcion' => 'Apreciación de los estudiantes del programa sobre la calidad de los materiales de apoyo producidos o utilizados por los profesores adscritos al programa y su pertinencia de acuerdo con la metodología del programa.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Premios u otros reconocimientos a los materiales de apoyo a la labor docente, en el ámbito nacional o internacional, que hayan producido los profesores adscritos al programa.',
        	'ASP_Descripcion' => 'Premios u otros reconocimientos a los materiales de apoyo a la labor docente, en el ámbito nacional o internacional, que hayan producido los profesores adscritos al programa.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Existencia y aplicación de un régimen de propiedad intelectual en la institución aplicado a los materiales de apoyo a la docencia.',
        	'ASP_Descripcion' => 'Existencia y aplicación de un régimen de propiedad intelectual en la institución aplicado a los materiales de apoyo a la docencia.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 14
		$caracteristica = Caracteristica::where('CRT_Nombre','REMUNERACIÓN POR MERITOS')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Políticas y reglamentaciones institucionales en materia de remuneración de los profesores en las que se tengan en cuenta los méritos profesionales y académicos, así como los estímulos a la producción académica y de innovación debidamente evaluada.',
        	'ASP_Descripcion' => 'Políticas y reglamentaciones institucionales en materia de remuneración de los profesores en las que se tengan en cuenta los méritos profesionales y académicos, así como los estímulos a la producción académica y de innovación debidamente evaluada.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Evidencias sobre la aplicación de estas políticas y reglamentaciones.',
        	'ASP_Descripcion' => 'Evidencias sobre la aplicación de estas políticas y reglamentaciones.',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de los profesores con respecto a la correspondencia entre la remuneración y los méritos académicos y profesionales',
        	'ASP_Descripcion' => 'Apreciación de los profesores con respecto a la correspondencia entre la remuneración y los méritos académicos y profesionales',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 15
		$caracteristica = Caracteristica::where('CRT_Nombre','EVALUACIÓN DE PROFESORES')->value('PK_CRT_Id');
		Aspecto::create([
        	'ASP_Nombre' => 'Existencia y aplicación de políticas institucionales en materia de evaluación integral al desempeño de los profesores. La institución presente evidencias sobre el desarrollo de estas políticas.',
        	'ASP_Descripcion' => 'Existencia y aplicación de políticas institucionales en materia de evaluación integral al desempeño de los profesores. La institución presente evidencias sobre el desarrollo de estas políticas.',
        	'ASP_Identificador' => 'a',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Criterios y mecanismos de evaluación de los profesores adscritos al programa, en correspondencia con la naturaleza del cargo, las funciones y los compromisos contraídos en relación con las metas institucionales y del programa',
        	'ASP_Descripcion' => 'Criterios y mecanismos de evaluación de los profesores adscritos al programa, en correspondencia con la naturaleza del cargo, las funciones y los compromisos contraídos en relación con las metas institucionales y del programa',
        	'ASP_Identificador' => 'b',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Evaluaciones realizadas a los profesores adscritos al programa durante los últimos cinco años y las acciones adelantadas por la institución y por el programa a partir de dichos resultados.',
        	'ASP_Descripcion' => 'Evaluaciones realizadas a los profesores adscritos al programa durante los últimos cinco años y las acciones adelantadas por la institución y por el programa a partir de dichos resultados.',
        	'ASP_Identificador' => 'c',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => ' Información verificable sobre la participación de los distintos actores en la evaluación.',
        	'ASP_Descripcion' => ' Información verificable sobre la participación de los distintos actores en la evaluación.',
        	'ASP_Identificador' => 'd',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		Aspecto::create([
        	'ASP_Nombre' => 'Apreciación de los profesores adscritos al programa, sobre los criterios y mecanismos para la evaluación de docentes, su transparencia, equidad y eficacia.',
        	'ASP_Descripcion' => 'Apreciación de los profesores adscritos al programa, sobre los criterios y mecanismos para la evaluación de docentes, su transparencia, equidad y eficacia.',
        	'ASP_Identificador' => 'e',
        	'FK_ASP_Caracteristica' => $caracteristica,
		]);
		//caracteristica 16
		$caracteristica = Caracteristica::where('CRT_Nombre','INTEGRIDAD DEL CURRÍCULO')->value('PK_CRT_Id');
		// Aspecto::create([
  //       	'ASP_Nombre' => '',
  //       	'ASP_Descripcion' => '',
  //       	'ASP_Identificador' => '',
  //       	'FK_ASP_Caracteristica' => $caracteristica,
		// ]);
   }
}





























































































