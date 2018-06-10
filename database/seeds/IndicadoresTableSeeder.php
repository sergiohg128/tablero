<?php

use Illuminate\Database\Seeder;

class IndicadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Indicador::class, 10)->create();
    }
}
