<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsables', function (Blueprint $table) {
			$table->increments('id');
			
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('actividad_id');

			// SoftDelete
			$table->softDeletes();

			// Relation
			$table->foreign('user_id')->references('id')->on('users')
				->onUpdate('cascade');
			// Relation
			$table->foreign('actividad_id')->references('id')->on('actividades')
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
        Schema::dropIfExists('responsables');
    }
}
