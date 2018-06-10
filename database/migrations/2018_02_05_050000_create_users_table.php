<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
			$table->text('nombres');
			$table->text('paterno');
			$table->text('materno');
			$table->text('cuenta');
			$table->text('password');
			$table->rememberToken();
			$table->boolean('jefe')->nullable();
			$table->text('imagen')->default('default.jpg');
      $table->text('correo')->nullable();
      $table->text('correo2')->nullable();
      $table->text('telefono')->nullable();
      $table->text('tipo')->nullable();
      $table->text('cargo')->nullable();
			$table->unsignedInteger('oficina_id');

			// SoftDelete
			$table->softDeletes();

			// Relation
			$table->foreign('oficina_id')->references('id')->on('oficinas')
				->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificaciones');
        Schema::dropIfExists('users');
    }
}
