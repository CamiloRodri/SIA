<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolucionEncuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Solucion_Encuesta', function (Blueprint $table) {
            $table->increments('PK_SEC_Id');
            $table->integer("SEC_Total_Encuestados");
            $table->float("SEC_Total_Ponderacion");
            $table->string("SEC_Grupo_Interes");
            $table->integer("FK_SEC_Respuesta")->unsigned();
            $table->timestamps();

            $table->foreign("FK_SEC_Respuesta")->references("PK_RPG_Id")->on("TBL_Respuestas_Preguntas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solucion_encuesta');
    }
}
