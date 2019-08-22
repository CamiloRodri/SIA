<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para guardar la información necesaria para acceder a los archivos
     * como la url generada y el nombre original del archivo.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Archivos', function (Blueprint $table) {
            $table->increments('PK_ACV_Id');
            $table->string("ACV_Nombre");
            $table->string("ACV_Extension")->nullable();
            $table->string("ruta");
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
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Archivos');
    }
}
