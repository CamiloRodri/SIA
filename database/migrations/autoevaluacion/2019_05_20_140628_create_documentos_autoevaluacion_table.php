<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosAutoevaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * tabla creada con el fin de subir los archivos necesarios en la autoevaluación,
     * esto se hace por medio de la relación con la tabla archivos para guardar el
     * documento o si no es un documento se especifica el campo url, ademas esta relacionada
     * con la tabla indicador porque cada documento pertenece a un indicador
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Documentos_Autoevaluacion', function (Blueprint $table) {
            $table->increments('PK_DOA_Id');
            $table->string("DOA_Numero")->nullable();
            $table->year("DOA_Anio")->nullable();
            $table->string("DOA_Link")->nullable();
            $table->mediumText("DOA_DescripcionGeneral")->nullable();
            $table->mediumText("DOA_ContenidoEspecifico")->nullable();
            $table->mediumText("DOA_ContenidoAdicional")->nullable();
            $table->mediumText("DOA_Observaciones")->nullable();
            $table->double("DOA_Calificacion")->nullable();
            $table->mediumText("DOA_Observaciones_Calificacion")->nullable();
            $table->integer("FK_DOA_Archivo")->unsigned()->nullable();
            $table->integer("FK_DOA_IndicadorDocumental")->unsigned();
            $table->integer("FK_DOA_TipoDocumento")->unsigned();
            $table->integer("FK_DOA_Dependencia")->unsigned();
            $table->integer("FK_DOA_Proceso")->unsigned();


            $table->timestamps();

            $table->foreign("FK_DOA_Archivo")->references("PK_ACV_Id")->on("TBL_Archivos")->onDelete("cascade");
            $table->foreign("FK_DOA_IndicadorDocumental")->references("PK_IDO_Id")->on("TBL_Indicadores_Documentales")->onDelete("cascade");
            $table->foreign("FK_DOA_TipoDocumento")->references("PK_TDO_Id")->on("TBL_Tipo_Documentos")->onDelete("cascade");
            $table->foreign("FK_DOA_Dependencia")->references("PK_DPC_Id")->on("TBL_Dependencias")->onDelete("cascade");
            $table->foreign("FK_DOA_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Documentos_Autoevaluacion');
    }
}
