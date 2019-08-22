<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaracteristicasTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar las caracteristicas
     *propuestas por el CNA del sistema de autoevaluacion
     *Se relaciona con la tabla factores
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Caracteristicas', function (Blueprint $table) {
            $table->increments('PK_CRT_Id');
            $table->string("CRT_Nombre");
            $table->mediumText("CRT_Descripcion")->nullable();
            $table->integer("CRT_Identificador");
            $table->integer("FK_CRT_Factor")->unsigned();
            $table->integer("FK_CRT_Estado")->unsigned();
            $table->integer("FK_CRT_Ambito")->unsigned()->nullable();
            $table->timestamps();

            $table->foreign("FK_CRT_Factor")->references("PK_FCT_Id")->on("TBL_Factores")->onDelete("cascade");
            $table->foreign("FK_CRT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
            $table->foreign("FK_CRT_Ambito")->references("PK_AMB_Id")->on("TBL_Ambitos_Responsabilidad")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Caracteristicas');
    }
}
