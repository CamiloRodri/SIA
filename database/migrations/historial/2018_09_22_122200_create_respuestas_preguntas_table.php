<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Respuestas_Preguntas', function (Blueprint $table) {
            $table->increments('PK_RPG_Id');
            $table->string("RPG_Texto", 10000);
            $table->integer("FK_RPG_Pregunta")->unsigned();
            $table->timestamps();

            $table->foreign("FK_RPG_Pregunta")->references("PK_PGT_Id")->on("TBL_Preguntas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Respuestas_Preguntas');
    }
}
