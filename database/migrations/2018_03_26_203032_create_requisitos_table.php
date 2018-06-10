<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nombre');
            $table->text('estado');
            $table->text('observacion')->nullable();
            $table->date('fecha_completado')->nullable();
            //$table->timestamps();

            $table->softDeletes();
      			$table->unsignedInteger('meta_id');

            $table->foreign('meta_id')->references('id')->on('metas')
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
        Schema::dropIfExists('requisitos');
    }
}
