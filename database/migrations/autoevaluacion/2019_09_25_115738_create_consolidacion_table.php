<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Consolidaciones', function (Blueprint $table) {
            $table->increments('PK_CNS_Id');
            $table->string('CNS_Debilidad');
            $table->string('CNS_Fortaleza');
            $table->integer('FK_CNS_Caracteristica')->unsigned();
            $table->integer('FK_CNS_Proceso')->unsigned();
            $table->timestamps();

            $table->foreign("FK_CNS_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete('cascade');
            $table->foreign("FK_CNS_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consolidacion');
    }
}
