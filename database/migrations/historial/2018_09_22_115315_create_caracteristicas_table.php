<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaracteristicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Caracteristicas', function (Blueprint $table) {
            $table->increments('PK_CRT_Id');
            $table->string("CRT_Nombre");
            $table->integer("FK_CRT_Factor")->unsigned();
            $table->timestamps();

            $table->foreign("FK_CRT_Factor")->references("PK_FCT_Id")->on("TBL_Factores")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Caracteristicas');
    }
}
