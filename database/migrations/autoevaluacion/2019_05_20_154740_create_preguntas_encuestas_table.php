<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla intermedia creada para identificar las preguntas que pertenecen a una encuesta y a que grupo
     * de interes estan destinadas
     * se relaciona con la tabla pregunta, banco_encuestas y grupos de interes.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Preguntas_Encuestas', function (Blueprint $table) {
            $table->increments('PK_PEN_Id');
            $table->integer("FK_PEN_Pregunta")->unsigned()->index();
            $table->integer("FK_PEN_Banco_Encuestas")->unsigned();
            $table->integer("FK_PEN_GrupoInteres")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PEN_Pregunta")->references("PK_PGT_Id")->on("TBL_Preguntas")->onDelete("cascade");
            $table->foreign("FK_PEN_Banco_Encuestas")->references("PK_BEC_Id")->on("TBL_Banco_Encuestas")->onDelete("cascade");
            $table->foreign("FK_PEN_GrupoInteres")->references("PK_GIT_Id")->on("TBL_Grupos_Interes")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Preguntas_Encuestas');
    }
}
