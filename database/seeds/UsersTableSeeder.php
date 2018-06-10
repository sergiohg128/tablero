<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		App\User::create([
			'nombres' => 'Admin',
			'paterno' => 'P.Admin',
			'materno' => 'M.Admin',
			'cuenta' => 'admin',
			'password' => Hash::make('admin'),
			'remember_token' => str_random(60),
			'jefe' => true,
			'imagen' => 'default.jpg',
			'tipo' => 'admin',
			'oficina_id' => 1,
    	]);

		factory(App\User::class, 25)->create();

		App\User::create([
			'nombres' => 'Romel Hammerlin',
			'paterno' => 'Diaz',
			'materno' => 'Ramos',
			'cuenta' => 'rodira',
			'password' => Hash::make('123'),
			'remember_token' => str_random(10),
			'jefe' => true,
			'imagen' => 'default.jpg',
			'oficina_id' => 1,
		]);

		App\User::create([
			'nombres' 			=> 'Jerfferson',
			'paterno' 			=> 'Tejada',
			'materno' 			=> 'Senmache',
			'cuenta' 			=> 'jefryts',
			'password' 			=> Hash::make('12345'),
			'remember_token' 	=> str_random(10),
			'jefe' 				=> true,
			'imagen' 			=> 'default.jpg',
			'oficina_id' 		=> 1,
		]);
	}
}
