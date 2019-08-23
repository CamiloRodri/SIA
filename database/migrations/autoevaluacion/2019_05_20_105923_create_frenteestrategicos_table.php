<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrenteestrategicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Frentes_Estrategicos', function (Blueprint $table) {
            $table->increments('PK_FES_id');
            $table->integer("FK_FES_Institucion")->unsigned();
            $table->mediumText('FES_Descripcion');
            $table->timestamps();

            $table->foreign("FK_FES_Institucion")->references("PK_ITN_Id")->on("TBL_Instituciones")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frenteestrategicos');
    }
}
