<?php

use Faker\Generator as Faker;

$factory->define(App\Gasto::class, function (Faker $faker) {
    return [
		'descripcion' => $faker->sentence(3),
		'monto' => $faker->randomFloat(2, 10, 1000),
		'numero' => $faker->numerify('######'),
		'fecha' => $faker->date('Y-m-d', 'now + 30 days'),
		'tipo' => $faker->randomElement(['B', 'S']),
		'tipo_documento_id' => rand(1,4),
		'meta_id' => rand(1,90),
    ];
});
