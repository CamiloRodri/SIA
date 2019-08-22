<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePonderacionRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar las ponderaciones de cada respuesta para cada pregunta
     * se relaciona con la tabla tipo de respuesta.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Ponderacion_Respuestas', function (Blueprint $table) {
            $table->increments('PK_PRT_Id');
            $table->float("PRT_Ponderacion");
            $table->integer("PRT_Rango");
            $table->integer("FK_PRT_TipoRespuestas")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PRT_TipoRespuestas")->references("PK_TRP_Id")->on("TBL_Tipo_Respuestas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Ponderacion_Respuestas');
    }
}
