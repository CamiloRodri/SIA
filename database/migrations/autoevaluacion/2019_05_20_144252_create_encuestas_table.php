<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar las encuestas vinculadas a un proceso de autoevaluacion
     * y tener un mejor manejo en cuanto a la fase de captura de datos
     * se relaciona con la tabla proceso, estado y banco encuestas.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Encuestas', function (Blueprint $table) {
            $table->increments('PK_ECT_Id');
            $table->date("ECT_FechaPublicacion");
            $table->date("ECT_FechaFinalizacion");
            $table->integer("FK_ECT_Estado")->unsigned();
            $table->integer("FK_ECT_Banco_Encuestas")->unsigned();
            $table->integer("FK_ECT_Proceso")->unsigned();
            $table->timestamps();

            $table->foreign("FK_ECT_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");
            $table->foreign("FK_ECT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
            $table->foreign("FK_ECT_Banco_Encuestas")->references("PK_BEC_Id")->on("TBL_Banco_Encuestas")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Encuestas');
    }
}
