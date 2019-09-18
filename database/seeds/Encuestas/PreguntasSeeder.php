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
    	$pregunta2 = Pregunta::create([
			    		'PGT_Texto' => 'Según su opinión, ¿existen en la UDEC espacios institucionales para la discusión y actualización permanente del proyecto educativo del Programa (PEP)?',
			    		'FK_PGT_Estado' => $estado,
			    		'FK_PGT_TipoRespuesta' => $tipoRespuesta4,
			    		'FK_PGT_Caracteristica' => Caracteristica::where('CRT_Nombre' , 'PROYECTO EDUCATIVO DEL PROGRAMA')->value('PK_CRT_Id') 
			     	]);
    	$pregunta2 = Pregunta::where('PGT_Texto','Según su opinión, ¿existen en la UDEC espacios institucionales para la discusión y actualización permanente del proyecto educativo del Programa (PEP)?')->value('PK_PGT_Id');
    	//dd($pregunta2);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'Existe y se usa',
    		'FK_RPG_Pregunta' => $pregunta2,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p35
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'Existe y no se usa',
    		'FK_RPG_Pregunta' => $pregunta2,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p30
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'No existen',
    		'FK_RPG_Pregunta' => $pregunta2,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p20
    	]);
    	RespuestaPregunta::create([
    		'RPG_Texto' => 'No sabe no conoce',
    		'FK_RPG_Pregunta' => $pregunta2,
    		'FK_RPG_PonderacionRespuesta' => $ponderaciont4p15
    	]);
    }
}
