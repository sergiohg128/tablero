<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->increments('id');
			$table->text('descripcion');
			$table->decimal('monto', 10, 2);
			$table->text('numero')->nullable();
			$table->date('fecha');
			$table->enum('tipo', ['B', 'S']);
			
			// SoftDelete
			$table->softDeletes();

			$table->unsignedInteger('meta_id');
			$table->unsignedInteger('tipo_documento_id');


			// Relation
			$table->foreign('meta_id')->references('id')->on('metas')
				->onUpdate('cascade');
			
			$table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos')
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
        Schema::dropIfExists('gastos');
    }
}
