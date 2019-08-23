<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestadosTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla creada para almacenar los datos mas relevantes del encuestado
     * como la fecha de solucion y si este tiene un cargo administrativo.
     * se relaciona con la tabla encuesta, grupo de interes y cargo administrativo.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Encuestados', function (Blueprint $table) {
            $table->increments('PK_ECD_Id');
            $table->date("ECD_FechaSolucion");
            $table->integer("FK_ECD_Encuesta")->unsigned();
            $table->integer("FK_ECD_GrupoInteres")->unsigned();
            $table->integer("FK_ECD_CargoAdministrativo")->unsigned()->nullable();

            $table->timestamps();

            $table->foreign("FK_ECD_Encuesta")->references("PK_ECT_Id")->on("TBL_Encuestas")->onDelete("cascade");
            $table->foreign("FK_ECD_GrupoInteres")->references("PK_GIT_Id")->on("TBL_Grupos_Interes")->onDelete("cascade");
            $table->foreign("FK_ECD_CargoAdministrativo")->references("PK_CAA_Id")->on("TBL_Cargos_Administrativos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Encuestados');
    }
}
