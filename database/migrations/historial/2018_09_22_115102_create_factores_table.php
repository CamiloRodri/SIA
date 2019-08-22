<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Factores', function (Blueprint $table) {
            $table->increments('PK_FCT_Id');
            $table->string("FCT_Nombre");
            $table->integer("FK_FCT_Lineamiento")->unsigned();
            $table->timestamps();

            $table->foreign("FK_FCT_Lineamiento")->references("PK_LNM_Id")->on("TBL_Lineamientos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Factores');
    }
}
