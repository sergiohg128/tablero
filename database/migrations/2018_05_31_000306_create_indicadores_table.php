<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('valor');
            $table->text('tipo');
            $table->integer('anio');
            
            $table->softDeletes();

            $table->unsignedInteger('creador_id');
            $table->unsignedInteger('oficina_id');

            $table->foreign('creador_id')->references('id')->on('users')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('indicadores');
    }
}
