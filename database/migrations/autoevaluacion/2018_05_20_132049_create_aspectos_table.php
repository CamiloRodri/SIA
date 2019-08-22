<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspectosTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar los aspectos
     *propuestos por el CNA en el sistema autoevaluacion
     *Se relacion con la tabla caracteristicas
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Aspectos', function (Blueprint $table) {
            $table->increments('PK_ASP_Id');
            $table->mediumText("ASP_Nombre");
            $table->mediumText("ASP_Descripcion")->nullable();
            $table->string("ASP_Identificador");
            $table->integer("FK_ASP_Caracteristica")->unsigned();
            $table->timestamps();

            $table->foreign("FK_ASP_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Aspectos');
    }
}
