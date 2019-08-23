<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla par almacenar los usuarios que manejar
     * el sistema de autoevaluacion
     * Esta relaciona con la tabla estados
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Usuarios', function (Blueprint $table) {
            $table->increments('PK_USU_id');
            $table->string("USU_Nombre");
            $table->string("USU_Apellido");
            $table->string("USU_Correo")->unique();
            $table->string("USU_Clave");
            $table->integer("FK_USU_Estado")->unsigned()->nullable();
            $table->integer("FK_USU_rol")->unsigned()->nullable();
            $table->timestamps();
            $table->rememberToken();

            $table->foreign("FK_USU_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Usuarios');
    }
}
