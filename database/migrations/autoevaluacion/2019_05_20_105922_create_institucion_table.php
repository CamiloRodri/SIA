<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Instituciones', function (Blueprint $table) {
            $table->increments('PK_ITN_Id');
            $table->string("ITN_Nombre");
            $table->string("ITN_Domicilio");
            $table->string("ITN_Caracter");
            $table->mediumText("ITN_CodigoSNIES");
            $table->string("ITN_Norma_Creacion");
            $table->integer("ITN_Estudiantes");
            $table->integer("FK_ITN_Metodologia")->unsigned();
            $table->string("ITN_Profesor_Planta");
            $table->string("ITN_Profesor_TCompleto");
            $table->string("ITN_Profesor_TMedio");
            $table->string("ITN_Profesor_Catedra");
            $table->string("ITN_Graduados");
            $table->mediumText("ITN_Mision");
            $table->mediumText("ITN_Vision");
            $table->mediumText("ITN_Descripcion")->nullable();
            $table->integer("FK_ITN_Estado")->unsigned();
            $table->string("ITN_FuenteBoletinMes");
            $table->string("ITN_FuenteBoletinAnio");
            $table->timestamps();
            $table->foreign("FK_ITN_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete('cascade');
            $table->foreign("FK_ITN_Metodologia")->references("PK_MTD_Id")->on("TBL_Metodologias")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institucion');
    }
}
