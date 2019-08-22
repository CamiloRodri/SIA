<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoresTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar los factores
     *propuestos por el CNA del sistema de autoevaluacion
     *Se relaciona con la tabla estados
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Factores', function (Blueprint $table) {
            $table->increments('PK_FCT_Id');
            $table->string("FCT_Nombre");
            $table->mediumText("FCT_Descripcion")->nullable();
            $table->integer("FCT_Identificador");
            $table->integer("FCT_Ponderacion_factor")->unsigned();
            $table->integer("FK_FCT_Estado")->unsigned();
            $table->integer("FK_FCT_Lineamiento")->unsigned();
            $table->timestamps();

            $table->foreign("FK_FCT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
            $table->foreign("FK_FCT_Lineamiento")->references("PK_LNM_Id")->on("TBL_Lineamientos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Factores');
    }
}
