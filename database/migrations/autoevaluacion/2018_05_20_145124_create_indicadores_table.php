<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadoresTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar indicadores
     * proporcionados por el CNA del sistema
     * de autoevaluacion
     * Se relaciona con la tabla aspectos
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Indicadores', function (Blueprint $table) {
            $table->increments('PK_EDC_Id');
            $table->string("IND_Nombre");
            $table->integer("IND_Identificador");
            $table->integer("FK_IND_Aspecto")->unsigned();
            $table->integer("FK_IND_estado")->unsigned();
            $table->timestamps();

            $table->foreign("FK_IND_Aspecto")->references("PK_ASP_Id")->on("TBL_Aspectos")->onDelete("cascade");
            $table->foreign("FK_IND_estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Indicadores');
    }
}
