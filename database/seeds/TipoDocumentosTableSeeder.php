<?php

use Illuminate\Database\Seeder;

class TipoDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Tipo_documento::create([
			'nombre' => 'B/V',
		]);

		App\Tipo_documento::create([
			'nombre' => 'Factura',
		]);

		App\Tipo_documento::create([
			'nombre' => 'Ticket',
		]);

		App\Tipo_documento::create([
			'nombre' => 'Recibo',
		]);
    }
}
