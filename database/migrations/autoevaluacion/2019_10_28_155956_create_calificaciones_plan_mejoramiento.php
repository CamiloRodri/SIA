<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionesPlanMejoramiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Califica_Actividades', function (Blueprint $table) {
            $table->increments('PK_CLA_Id');
            $table->double('CLA_Calificacion');
            $table->string('CLA_Observacion');
            $table->integer('FK_CLA_Actividad_Mejoramiento')->unsigned();
            $table->integer('FK_CLA_Fecha_Corte')->unsigned();
            $table->timestamps();

            $table->foreign("FK_CLA_Actividad_Mejoramiento")->references("PK_ACM_Id")->on("TBL_Actividades_Mejoramiento")->onDelete("cascade");
            $table->foreign("FK_CLA_Fecha_Corte")->references("PK_FCO_Id")->on("TBL_Fechas_corte")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Calificaciones_Actividades');
    }
}
