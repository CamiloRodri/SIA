<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar el cuerpo de las respuestas
     * pertenecientes a una pregunta
     * se relaciona con la tabla pregunta y ponderacion_respuesta.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Respuestas_Preguntas', function (Blueprint $table) {
            $table->increments('PK_RPG_Id');

            $table->string("RPG_Texto", 10000);
            $table->integer("FK_RPG_Pregunta")->unsigned();
            $table->integer("FK_RPG_PonderacionRespuesta")->unsigned();
            $table->timestamps();

            $table->foreign("FK_RPG_Pregunta")->references("PK_PGT_Id")->on("TBL_Preguntas")->onDelete("cascade");
            $table->foreign("FK_RPG_PonderacionRespuesta")->references("PK_PRT_Id")->on("TBL_Ponderacion_Respuestas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Respuestas_Preguntas');
    }
}
