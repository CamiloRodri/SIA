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
            $table->string("PAC_Nivel_Formacion");
            $table->string("PAC_Titutlo_Otorga");
            $table->string("PAC_Situacion_Programa");
            $table->string("PAC_Anio_Inicio_Actividades");
            $table->mediumText("PAC_Descripcion")->nullable();
            $table->integer("PAC_Anio_Inicio_Programa");
            $table->string("PAC_Lugar_Funcionamiento");
            $table->string("PAC_Norma_Interna");
            $table->string("PAC_Resolucion_Registro");
            $table->string("PAC_Codigo_SNIES");
            $table->integer("PAC_Numero_Creditos");
            $table->string("PAC_Duracion");
            $table->string("PAC_Jornada");
            $table->string("PAC_Duracion_Semestre");
            $table->string("PAC_Periodicidad");
            $table->string("PAC_Adscrito");
            $table->string("PAC_Area_Conocimiento");
            $table->string("PAC_Nucleo");
            $table->string("PAC_Area_Formacion");
            $table->integer("PAC_Estudiantes");
            $table->integer("PAC_Egresados");
            $table->integer("PAC_Valor_Matricula");
            $table->integer("PAC_Docentes_Actual");
            $table->integer("PAC_Directivos_Academicos");
            $table->integer("PAC_Administrativos");
            $table->integer("PAC_Egresados_Cinco");
            $table->integer("PAC_Empresarios");

            $table->integer("FK_PAC_Estado")->unsigned();
            $table->integer("FK_PAC_Facultad")->unsigned();
            $table->integer("FK_PAC_Sede")->unsigned();
            $table->integer("FK_PAC_Metodologia")->unsigned();

            $table->timestamps();

            $table->foreign("FK_PAC_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete('cascade');
            $table->foreign("FK_PAC_Facultad")->references("PK_FCD_Id")->on("TBL_Facultades")->onDelete('cascade');
            $table->foreign("FK_PAC_Sede")->references("PK_SDS_Id")->on("TBL_Sedes")->onDelete("cascade");
            $table->foreign("FK_PAC_Metodologia")->references("PK_MTD_Id")->on("TBL_Metodologias")->onDelete("cascade");
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
