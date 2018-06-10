<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('actividades', function (Blueprint $table) {
  			$table->increments('id');
  			$table->text('nombre');
  			$table->text('estado')->nullable();
    		$table->date('fecha_creacion')->nullable();
  			$table->decimal('presupuesto', 10, 2)->nullable();
  			$table->date('fecha_inicio')->nullable();
  			$table->date('fecha_fin_esperada')->nullable();
  			$table->date('fecha_fin')->nullable();
  			$table->text('numero_resolucion')->nullable();
  			$table->date('fecha_resolucion')->nullable();
  			$table->date('fecha_acta')->nullable();
  			$table->text('descripcion_acta')->nullable();
  			$table->unsignedInteger('creador_id')->unsigned();
  			$table->unsignedInteger('monitor_id')->unsigned();
        $table->unsignedInteger('indicador_id')->unsigned()->nullable();
        $table->integer('indicador_valor')->nullable();

  			// SoftDelete
  			$table->softDeletes();

  			//Relation
  			$table->foreign('creador_id')->references('id')->on('users')
  				->onUpdate('cascade');

        $table->foreign('monitor_id')->references('id')->on('users')
  				->onUpdate('cascade');

          $table->foreign('indicador_id')->references('id')->on('users')
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
        Schema::dropIfExists('actividades');
    }
}
