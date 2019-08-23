<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasesTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada par almacenar las fases de los procesos
     *para el sistema de autoevaluacion
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Fases', function (Blueprint $table) {
            $table->increments('PK_FSS_Id');
            $table->string("FSS_Nombre");
            $table->mediumText("FSS_Descripcion")->nullable();
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
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Fases');
    }
}
