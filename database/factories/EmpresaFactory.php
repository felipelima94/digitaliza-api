<?php

use Faker\Generator as Faker;

$factory->define(App\Empresa::class, function (Faker $faker) {
    return [
        'razao_social'          => $faker->bs,
        'nome_fantasia'         => $faker->company." ".$faker->companySuffix,
        'cnpj'                  => $faker->numberBetween($min = 100000000, $max = 900000000),
        'inscricao_estadual' 	=> $faker->numberBetween($min = 100000000, $max = 900000000),
        'email' 	            => $faker->companyEmail,
        'telefone1' 	        => $faker->tollFreePhoneNumber,
        'telefone2' 	        => $faker->tollFreePhoneNumber,
        'endereco' 	            => $faker->streetName,
        'numero'                => $faker->buildingNumber,
        'cidade' 	            => $faker->city,
        'uf' 	                => $faker->stateAbbr,
        'cep' 	                => $faker->postcode,
        'status' 	            => $faker->boolean,
        'validade'              => $faker->date
    ];
});
