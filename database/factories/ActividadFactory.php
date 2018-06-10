<?php

use Faker\Generator as Faker;

$factory->define(App\Actividad::class, function (Faker $faker) {
	$rand_user = App\User::where('jefe', TRUE)->where('cuenta', '<>', 'admin')->get()->random();
	$user = App\Oficina::find($rand_user->oficina_id)->users()->where('cuenta', '<>', 'admin')->get()->random();
    return [
		'nombre' => $faker->sentence(2),
		'estado' => $faker->randomElement(['I', 'E', 'C', 'F']),
		'presupuesto' => $faker->randomFloat(2, 1000, 10000),
		'fecha_creacion'=>\Carbon\Carbon::now()->subDays(rand(30,40)), //+rand(0,45)
		'fecha_inicio' => \Carbon\Carbon::now()->subDays(rand(1,30)),
		'fecha_fin_esperada' => \Carbon\Carbon::now()->addDays(rand(0,45)),
		'fecha_fin' => \Carbon\Carbon::now()->addDays(rand(0,45)),
		'numero_resolucion' => $faker->numerify('###-2018-VRINV'),
		'fecha_resolucion' => \Carbon\Carbon::now()->subDays(rand(50, 60)),
		'fecha_acta' => \Carbon\Carbon::now()->subDays(rand(45, 50)),
		'descripcion_acta' => $faker->text(255),
		'creador_id' => $rand_user->id,
		'monitor_id' => $user->id,
		'indicador_id' => rand(1,2),
    ];
});
