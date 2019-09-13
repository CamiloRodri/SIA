<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechascorteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechascorte', function (Blueprint $table) {
            $table->increments('PK_FCO_Id');
            $table->date('FCO_Fecha');
            $table->integer('FK_FCO_Proceso')->unsigned();
            $table->timestamps();
            $table->foreign("FK_FCO_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fechascorte');
    }
}
