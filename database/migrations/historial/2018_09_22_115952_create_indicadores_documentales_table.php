<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadoresDocumentalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Indicadores_Documentales', function (Blueprint $table) {
            $table->increments('PK_IDO_Id');
            $table->string("IDO_Nombre");
            $table->integer("FK_IDO_Caracteristica")->unsigned();
            $table->timestamps();

            $table->foreign("FK_IDO_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Indicadores_Documentales');
    }
}
