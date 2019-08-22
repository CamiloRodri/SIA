<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblPlanDeMejoramiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Plan_De_Mejoramiento', function (Blueprint $table) {
            $table->increments('PK_PDM_Id');
            $table->string("PDM_Nombre");
            $table->mediumText("PDM_Descripcion")->nullable();
            $table->integer("FK_PDM_Proceso")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PDM_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Plan_De_Mejoramiento');
    }
}

