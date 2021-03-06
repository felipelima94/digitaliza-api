<?php

use Faker\Generator as Faker;

$factory->define(App\Documento::class, function (Faker $faker) {
    return [
        'empresa_id' => $faker->numberBetween($min = 1, $max = 45),
        'usuario_id' => $faker->numberBetween($min = 1, $max = 4000),
        'nome_arquivo' => $faker->text(50),
        'local_armazenado' => $faker->numberBetween($min = 1, $max = 600),
        'tamanho' => $faker->numberBetween($min = 3, $max = 24000)
    ];
});
