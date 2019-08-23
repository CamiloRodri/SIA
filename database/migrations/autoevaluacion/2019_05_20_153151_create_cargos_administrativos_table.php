<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosAdministrativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Cargos_Administrativos', function (Blueprint $table) {
            $table->increments('PK_CAA_Id');
            $table->string("CAA_Cargo", 150)->unique();
            $table->integer("FK_CAA_AlcanceCargo")->unsigned();
            $table->string('CAA_Slug')->unique();
            $table->timestamps();
            $table->foreign("FK_CAA_AlcanceCargo")->references("PK_AAD_Id")->on("TBL_Alcances_Administrativos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Cargos_Administrativos');
    }
}
