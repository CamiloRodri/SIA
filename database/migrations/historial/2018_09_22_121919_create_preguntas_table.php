<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Preguntas', function (Blueprint $table) {
            $table->increments('PK_PGT_Id')->index();
            $table->string("PGT_Texto", 10000);
            $table->integer("FK_PGT_Caracteristica")->unsigned();
            $table->unsignedInteger('FK_PGT_Proceso');
            $table->timestamps();

            $table->foreign("FK_PGT_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");
            $table->foreign('FK_PGT_Proceso')->references('PK_PCS_Id')->on('TBL_Procesos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Preguntas');
    }
}
