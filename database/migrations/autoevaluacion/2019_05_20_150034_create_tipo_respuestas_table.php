<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar los posibles tipo de respuestas para las preguntas de las encuestas
     * Se tiene un control de la suma total de ponderaciones por seguridad y tener una posible mayor confiabilidad en los datos
     * se relaciona con la tabla estado.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Tipo_Respuestas', function (Blueprint $table) {
            $table->increments('PK_TRP_Id');
            $table->integer("TRP_TotalPonderacion");
            $table->integer("TRP_CantidadRespuestas");
            $table->string("TRP_Descripcion", 350);
            $table->integer("FK_TRP_Estado")->unsigned();
            $table->timestamps();

            $table->foreign("FK_TRP_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Tipo_Respuestas');
    }
}
