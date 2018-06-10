<?php

use Faker\Generator as Faker;

$factory->define(App\Indicador::class, function (Faker $faker) {
    return [
        'nombre' => $faker->sentence(3),
        'descripcion' => $faker->sentence(3),
        'tipo' => $faker->randomElement(['1','2']),
        'valor' => rand(2,20),
        'creador_id'=> rand(1,28),
        'oficina_id'=> rand(1,10),
        'anio' => $faker->randomElement([2017,2018,2019]),
    ];
});
