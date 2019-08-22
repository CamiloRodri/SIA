<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *Tabla creada para almacenar usuarios que manejaran el sistema de autoevaluacion
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('cedula');
            $table->string('email');
            $table->string('password');
            $table->string('estado_pass');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('users');
    }
}
