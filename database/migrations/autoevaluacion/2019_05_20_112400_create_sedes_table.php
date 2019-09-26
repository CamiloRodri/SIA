<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar las sedes de la universidades
     *del sistema de autoevaluacion
     *Se relaciona con la tabla estados
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Sedes', function (Blueprint $table) {
            $table->increments('PK_SDS_Id');
            $table->string("SDS_Nombre");
            $table->integer("FK_SDS_Institucion")->unsigned();
            $table->mediumText("SDS_Descripcion")->nullable();
            $table->integer("FK_SDS_Estado")->unsigned();
            $table->timestamps();
            $table->foreign("FK_SDS_Institucion")->references("PK_ITN_Id")->on("TBL_Instituciones")->onDelete('cascade');
            $table->foreign("FK_SDS_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Sedes');
    }
}
