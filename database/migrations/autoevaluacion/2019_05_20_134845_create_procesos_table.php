<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar los procesos
     * de algun programa
     * para el sistema de autoevaluacion
     * Se relaciona con los programas academicos
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Procesos', function (Blueprint $table) {
            $table->increments('PK_PCS_Id');
            $table->string("PCS_Nombre");
            $table->date("PCS_FechaInicio");
            $table->date("PCS_FechaFin");
            $table->boolean('PCS_Institucional')->default(false);
            $table->integer("FK_PCS_Programa")->unsigned()->nullable();
            $table->integer("FK_PCS_Fase")->unsigned();
            $table->integer('FK_PCS_Lineamiento')->unsigned();
            $table->string('PCS_Slug_Procesos')->unique();
            $table->timestamps();

            $table->foreign("FK_PCS_Programa")->references("PK_PAC_Id")->on("TBL_Programas_Academicos")->onDelete("cascade");
            $table->foreign("FK_PCS_Fase")->references("PK_FSS_Id")->on("TBL_Fases")->onDelete("cascade");
            $table->foreign("FK_PCS_Lineamiento")->references("PK_LNM_Id")->on("TBL_Lineamientos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Procesos');

    }
}
