<?php

use Faker\Generator as Faker;

$factory->define(App\Pastas::class, function (Faker $faker) {
    return [
        'nome' => $faker->text(35),
        'usuario_id' => $faker->numberBetween($min = 1, $max = 4000),
        'empresa_id' => $faker->numberBetween($min = 1, $max = 45),
        'raiz' => $faker->numberBetween($min = 0, $max = 200),
    ];
});
