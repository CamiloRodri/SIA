<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosProcesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Documentos_Proceso', function (Blueprint $table) {
            $table->increments('PK_DPC_Id');
            $table->date("DPC_Fecha_Subida");
            $table->integer("FK_DPC_Proceso")->unsigned();
            $table->integer("FK_DPC_Indicador")->unsigned();
            $table->timestamps();

            $table->foreign("FK_DPC_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");
            $table->foreign("FK_DPC_Indicador")->references("PK_IDO_Id")->on("TBL_Indicadores_Documentales")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Documentos_Proceso');
    }
}
