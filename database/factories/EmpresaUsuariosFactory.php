<?php

use Faker\Generator as Faker;

$factory->define(App\EmpresaUsuarios::class, function (Faker $faker) {
    return [
        'empresa_id' => $faker->numberBetween($min = 1, $max = 45),
        'usuario_id' => $faker->unique()->numberBetween($min = 1, $max = 4000),
    ];
});
