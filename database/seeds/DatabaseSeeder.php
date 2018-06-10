<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OficinasTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(TipoDocumentosTableSeeder::class);
        $this->call(ActividadesTableSeeder::class);
        $this->call(MetasTableSeeder::class);
        $this->call(GastosTableSeeder::class);

        $this->call(NotificacionesTableSeeder::class);

        //$this->call(IndicadoresTableSeeder::class);

    }
}
