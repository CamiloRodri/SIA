<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla para almacenar los grupos pertenecientes
     * a un modulo del sistema de autoevaluacion
     *Se relaciona con la tabla estados
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Grupos', function (Blueprint $table) {
            $table->increments('PK_GRP_Id');
            $table->string("GRP_Nombre");
            $table->mediumText("GRP_Descripcion")->nullable();
            $table->string("GRP_Ruta");
            $table->integer("FK_GRP_Estados")->unsigned();
            $table->integer("FK_GRP_Modulos")->unsigned();

            $table->timestamps();

            $table->foreign("FK_GRP_Estados")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
            $table->foreign("FK_GRP_Modulos")->references("PK_MDL_Id")->on("TBL_Modulos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Grupos');
    }
}
