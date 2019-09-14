<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Institucion;
use App\Models\Autoevaluacion\Metodologia;
use App\Models\Autoevaluacion\Estado;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$metodologia = Metodologia::where('MTD_Nombre' , 'Presencial')->value('PK_MTD_Id');
    	$estado = ESTADO::where('ESD_Nombre' , 'HABILITADO')->value('PK_ESD_Id');
        Institucion::create([
        	'ITN_Nombre' => 'Universidad de Cundinamarca',
        	'ITN_Domicilio' => 'Fusagasugá y la extensión Facatativá',
        	'ITN_Caracter' => 'Universidad',
        	'ITN_CodigoSNIES' => '1214 Fusagasugá
								  1215 Girardot
							      1216 Ubaté',
        	'ITN_Norma_Creacion' => 'Ordenanza número 045 del 19 de diciembre de 1969',
        	'ITN_Estudiantes' => '12902',
        	'FK_ITN_Metodologia' => $metodologia,
        	'ITN_Profesor_Planta' => '33',
        	'ITN_Profesor_TCompleto' => '485',
        	'ITN_Profesor_TMedio' => '77',
        	'ITN_Profesor_Catedra' => '401',
        	'ITN_Graduados' => '18366',
        	'ITN_Mision' => '“La Universidad de Cundinamarca es una institución pública local y translocal del Siglo XXI, caracterizada por ser una organización social de conocimiento, democrática, autónoma, formadora, agente de la transmodernidad que incorpora los consensos mundiales de la humanidad y las buenas prácticas de gobernanza universitaria, cuya calidad se genera desde los procesos de enseñanza-aprendizaje, investigación e innovación, interacción universitaria, internacionalización y bienestar universitario”.',
        	'ITN_Vision' => '“La Universidad de Cundinamarca será reconocida por la sociedad, en el ámbito local, regional, nacional e internacional, como generadora de conocimiento relevante y pertinente, centrada en el cuidado de la vida, la naturaleza, el ambiente, la humanidad y la convivencia”.',
        	'ITN_Descripcion' => 'Extension Facatativá',
        	'FK_ITN_Estado' => $estado
        ]);
    }
}
