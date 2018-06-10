<?php

use Illuminate\Database\Seeder;

class NotificacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Notificacion::class, 25)->create();
    }
}
