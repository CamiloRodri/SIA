<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar datos repetitivos de una encuesta
     * se relaciona con la tabla grupos de interes
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Datos_Encuestas', function (Blueprint $table) {
            $table->increments('PK_DAE_Id');
            $table->string("DAE_Titulo");
            $table->mediumText("DAE_Descripcion")->nullable();
            $table->integer("FK_DAE_GruposInteres")->unsigned();
            $table->timestamps();

            $table->foreign("FK_DAE_GruposInteres")->references("PK_GIT_Id")->on("TBL_Grupos_Interes")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Datos_Encuestas');
    }
}
