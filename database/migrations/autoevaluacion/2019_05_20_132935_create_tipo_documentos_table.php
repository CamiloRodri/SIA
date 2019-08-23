<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada con el fin de establecer a que tipo de documento, pertenece un archivo
     * en especifico, por ejemplo una resolución o una circular.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Tipo_Documentos', function (Blueprint $table) {
            $table->increments('PK_TDO_Id');
            $table->string("TDO_Nombre");
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
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Tipo_Documentos');
    }
}
