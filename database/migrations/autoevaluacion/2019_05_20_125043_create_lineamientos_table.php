<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineamientosTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar los lineamientos
     *propuestos por el CNA del sistema de autoevaluacion
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Lineamientos', function (Blueprint $table) {
            $table->increments('PK_LNM_Id');
            $table->string("LNM_Nombre");
            $table->mediumText("LNM_Descripcion")->nullable();
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
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Lineamientos');
    }
}
