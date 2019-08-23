<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadoresDocumentalesTable extends Migration
{
    /**
     * Run the migrations.
     * Taba creada para crear indicadores que indiquen al usuarios que archivos
     * debe subir para cumplir con los requisitos de la autoevaluación,
     * se relaciona con la tabla características.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Indicadores_Documentales', function (Blueprint $table) {
            $table->increments('PK_IDO_Id');
            $table->string("IDO_Nombre");
            $table->mediumText("IDO_Descripcion")->nullable();
            $table->integer("IDO_Identificador");
            $table->integer("FK_IDO_Caracteristica")->unsigned();
            $table->integer("FK_IDO_Estado")->unsigned();
            $table->timestamps();

            $table->foreign("FK_IDO_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");
            $table->foreign("FK_IDO_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Indicadores_Documentales');
    }
}
