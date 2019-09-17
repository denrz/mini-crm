<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;
use App\Company;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'company_id' => rand(1,5),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'phone' => $faker->phoneNumber
    ];
});
