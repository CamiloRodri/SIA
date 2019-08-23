<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar encuestas que puedan ser aplicadas a proceso de autoevaluacion
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Banco_Encuestas', function (Blueprint $table) {
            $table->increments('PK_BEC_Id');
            $table->string("BEC_Nombre", 500);
            $table->string("BEC_Descripcion", 5000);
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
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Banco_Encuestas');
    }
}
