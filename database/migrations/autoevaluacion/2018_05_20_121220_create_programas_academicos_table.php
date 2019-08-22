<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramasAcademicosTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar los programas
     *academicos de la universidad de Cundinamarca
     * del sistema de autoevaluacion
     * Se relacion a con la tabla usuarios
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Programas_Academicos', function (Blueprint $table) {
            $table->increments('PK_PAC_Id');
            $table->string("PAC_Nombre");
            $table->mediumText("PAC_Descripcion")->nullable();
            $table->integer("FK_PAC_Estado")->unsigned();
            $table->integer("FK_PAC_Facultad")->unsigned();
            $table->integer("FK_PAC_Sede")->unsigned();
            $table->timestamps();


            $table->foreign("FK_PAC_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete('cascade');
            $table->foreign("FK_PAC_Facultad")->references("PK_FCD_Id")->on("TBL_Facultades")->onDelete('cascade');
            $table->foreign("FK_PAC_Sede")->references("PK_SDS_Id")->on("TBL_Sedes")->onDelete("cascade");
        });
        Schema::connection('autoevaluacion')->table('users', function (Blueprint $table) {
            $table->unsignedInteger('id_programa')->nullable();
            $table->foreign('id_programa')->references('PK_PAC_Id')->on("TBL_Programas_Academicos")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->table('users', function (Blueprint $table) {
            $table->dropForeign('users_id_programa_foreign');
            $table->dropColumn('id_programa');
        });
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Programas_Academicos');
    }
}
