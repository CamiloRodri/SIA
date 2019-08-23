<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para tener un banco de preguntas que pueden ser establecidas en una encuesta
     * y que indiquen a que caracteristica esta afectando.
     * se relaciona con la tabla estado,  tipo respuesta y caracteristica.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Preguntas', function (Blueprint $table) {
            $table->increments('PK_PGT_Id')->index();
            $table->string("PGT_Texto", 10000);
            $table->integer("FK_PGT_Estado")->unsigned();
            $table->integer("FK_PGT_TipoRespuesta")->unsigned();
            $table->integer("FK_PGT_Caracteristica")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PGT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
            $table->foreign("FK_PGT_TipoRespuesta")->references("PK_TRP_Id")->on("TBL_Tipo_Respuestas")->onDelete("cascade");
            $table->foreign("FK_PGT_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Preguntas');
    }
}
