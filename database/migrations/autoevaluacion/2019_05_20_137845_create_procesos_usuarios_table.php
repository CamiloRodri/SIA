<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada almacenar la asignacion
     *de algun usuario a un proceso
     * se relaciona con usuarios
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Procesos_Usuarios', function (Blueprint $table) {
            $table->increments('PK_PCU_Id');
            $table->integer("FK_PCU_Proceso")->unsigned();
            $table->integer("FK_PCU_Usuario")->unsigned();

            $table->foreign("FK_PCU_Usuario")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("FK_PCU_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Procesos_Usuarios');
    }
}
