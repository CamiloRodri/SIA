<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Responsables', function (Blueprint $table) {
            $table->increments('PK_RPS_Id');
            $table->integer("FK_RPS_Responsable")->unsigned();
            $table->integer("FK_RPS_Cargo")->unsigned();
            $table->integer("FK_RPS_Proceso")->unsigned();
            $table->timestamps();
            $table->foreign('FK_RPS_Responsable')->references('id')->on("users")->onDelete('cascade');
            $table->foreign('FK_RPS_Cargo')->references('PK_CAA_Id')->on("TBL_Cargos_Administrativos")->onDelete('cascade');
            $table->foreign('FK_RPS_Proceso')->references('PK_PCS_Id')->on("TBL_Procesos")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Responsables');
    }
}