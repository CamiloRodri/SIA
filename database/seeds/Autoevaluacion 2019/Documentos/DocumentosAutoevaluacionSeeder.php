<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\TipoDocumento;
use App\Models\Autoevaluacion\Dependencia;

class DocumentosAutoevaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$indicador = IndicadorDocumental::where('IDO_Nombre', 'Estudio de mercado del programa')->value('PK_IDO_Id');
    	$tipodoc = TipoDocumento::where('TDO_Nombre', 'ACUERDO')->value('PK_TDO_Id');
    	$dependencia = Dependencia::where('DPC_Nombre', 'CONSEJO SUPERIOR UNIVERSITARIO')->value('PK_DPC_Id');
    	$proceso = Proceso::where('PCS_Nombre', 'Autoevaluación 2019')->value('PK_PCS_Id');
        DocumentoAutoevaluacion::create([
        	'DOA_Numero' => '024',
        	'DOA_Anio' => '2007',
        	'DOA_Link' => 'https://www.ucundinamarca.edu.co/documents/normatividad/acuerdos_superior/2007/acuerdo-024-2007.pdf',
        	'DOA_DescripcionGeneral' => 'POR EL CUAL SE EXPIDE EL ESTATUTO DEL PROFESOR DE LA UNIVERSIDAD\r\nDE CUNDINAMARCA',
        	'DOA_ContenidoEspecifico' => null,
        	'DOA_ContenidoAdicional' => null,
            // 'DOA_Calificacion' => '5.0',
        	// 'DOA_Observaciones' => 'Excelente documento, bien',
        	'FK_DOA_Archivo' => null,
        	'FK_DOA_IndicadorDocumental' => $indicador,
        	'FK_DOA_TipoDocumento' => $tipodoc,
        	'FK_DOA_Dependencia' => $dependencia,
        	'FK_DOA_Proceso' => $proceso,
        ]);

    }
}
