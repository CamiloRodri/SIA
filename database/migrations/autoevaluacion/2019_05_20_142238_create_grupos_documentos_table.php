<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para establecer a que grupo de documentos pertenece cada documento, por
     * ejemplo documentos institucionales, facultad, programa etc.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Grupos_Documentos', function (Blueprint $table) {
            $table->increments('PK_GRD_Id');
            $table->string("GRD_Nombre");
            $table->mediumText("GRD_Descripcion");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Grupos_Documentos');
    }
}
