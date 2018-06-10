<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonitoreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoreos', function (Blueprint $table) {
			$table->increments('id');
			$table->text('descripcion');
			$table->date('fecha');
			$table->text('observacion');

			// SoftDelete
			$table->softDeletes();

			// Relation
			$table->unsignedInteger('meta_id');

			// Relation
			$table->foreign('meta_id')->references('id')->on('metas')
				->onDelete('cascade')
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
        Schema::dropIfExists('monitoreo');
    }
}
