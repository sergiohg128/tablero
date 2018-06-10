<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaResponsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_responsable', function (Blueprint $table) {
			$table->increments('id');
			
            $table->unsignedInteger('meta_id');
			$table->unsignedInteger('responsable_id');

			// Relation
			$table->foreign('meta_id')->references('id')->on('metas')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->foreign('responsable_id')->references('id')->on('responsables')
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
        Schema::dropIfExists('meta_responsable');
    }
}
