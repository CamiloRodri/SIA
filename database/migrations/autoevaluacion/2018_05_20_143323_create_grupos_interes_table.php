<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposInteresTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar los grupos
     * que van a formar parte de la autoevalluacion
     * en el sistema de autoevaluacion
     * Se relaciona con estado
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Grupos_Interes', function (Blueprint $table) {
            $table->increments('PK_GIT_Id');
            $table->string("GIT_Nombre")->unique();
            $table->integer("FK_GIT_Estado")->unsigned();
            $table->string('GIT_Slug')->unique();
            $table->timestamps();

            $table->foreign("FK_GIT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Grupos_Interes');
    }
}
