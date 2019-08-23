<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolucionEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla intermedia creada para identificar las respuestas digitadas por un encuestado
     * se relaciona con la tabla respuestas y encuestados.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Solucion_Encuestas', function (Blueprint $table) {
            $table->increments('PK_SEC_Id');
            $table->integer("FK_SEC_Respuesta")->unsigned();
            $table->integer("FK_SEC_Encuestado")->unsigned();
            $table->timestamps();

            $table->foreign("FK_SEC_Respuesta")->references("PK_RPG_Id")->on("TBL_Respuestas_Preguntas")->onDelete("cascade");
            $table->foreign("FK_SEC_Encuestado")->references("PK_ECD_Id")->on("TBL_Encuestados")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Solucion_Encuestas');
    }
}
