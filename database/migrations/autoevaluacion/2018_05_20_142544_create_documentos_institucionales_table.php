<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosInstitucionalesTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para guardar los documentos que afectan a todos los programas o que son
     * necesarios en todos  o en una gran parte de los procesos de autoevaluacion.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Documentos_Institucionales', function (Blueprint $table) {
            $table->increments('PK_DOI_Id');
            $table->string("DOI_Nombre");
            $table->mediumText("DOI_Descripcion")->nullable();
            $table->string("link")->nullable();
            $table->integer("FK_DOI_Archivo")->unsigned()->nullable();
            $table->integer("FK_DOI_GrupoDocumento")->unsigned();
            $table->timestamps();

            $table->foreign("FK_DOI_Archivo")->references("PK_ACV_Id")->on("TBL_Archivos")->onDelete("cascade");
            $table->foreign("FK_DOI_GrupoDocumento")->references("PK_GRD_Id")->on("TBL_Grupos_Documentos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Documentos_Institucionales');
    }
}
