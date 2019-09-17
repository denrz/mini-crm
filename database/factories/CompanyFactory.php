<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->safeEmail,
        'logo' => '',
        'website' => 'www.' . Str::random(10) . '.com'
    ];
});
