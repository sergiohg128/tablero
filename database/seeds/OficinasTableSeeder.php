<?php

use Illuminate\Database\Seeder;

class OficinasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Oficina::class, 10)->create();
    }
}
