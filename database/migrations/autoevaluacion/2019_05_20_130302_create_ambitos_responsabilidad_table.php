<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbitosResponsabilidadTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar el ambito de responsabilidad
     *del sistema de autoevaluacion
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Ambitos_Responsabilidad', function (Blueprint $table) {
            $table->increments('PK_AMB_Id');
            $table->string("AMB_Nombre");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Ambitos_Responsabilidad');
    }
}
