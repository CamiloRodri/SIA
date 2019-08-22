<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Lineamientos', function (Blueprint $table) {
            $table->increments('PK_LNM_Id');
            $table->string("LNM_Nombre");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Lineamientos');
    }
}
