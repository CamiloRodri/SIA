<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultadesTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar la
     * facultades de la universidad de Cundinamarca
     * del sistema de autoevaluacion
     * Se relaciona con la tabla estado
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Facultades', function (Blueprint $table) {
            $table->increments('PK_FCD_Id');
            $table->string("FCD_Nombre");
            $table->mediumText("FCD_Descripcion")->nullable();
            $table->integer("FK_FCD_Estado")->unsigned();
            $table->timestamps();

            $table->foreign("FK_FCD_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Facultades');
    }
}
