<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Evidencias', function (Blueprint $table) {
            $table->increments('PK_EVD_Id');
            $table->string('EVD_Nombre');
            $table->string('EVD_Link')->nullable();
            $table->integer("FK_EVD_Archivo")->unsigned()->nullable();
            $table->date('EVD_Fecha_Subido');
            $table->mediumText('EVD_Descripcion_General');
            $table->integer('FK_EVD_Actividad_Mejoramiento')->unsigned();
            $table->timestamps();
            
            $table->foreign("FK_EVD_Archivo")->references("PK_ACV_Id")->on("TBL_Archivos")->onDelete("cascade");
            $table->foreign("FK_EVD_Actividad_Mejoramiento")->references("PK_ACM_Id")->on("TBL_Actividades_Mejoramiento")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencias');
    }
}
