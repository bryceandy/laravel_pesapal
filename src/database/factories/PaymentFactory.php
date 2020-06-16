<?php

/** @var Factory $factory */
use Bryceandy\Laravel_Pesapal\Payment;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Payment::class, fn (Generator $faker) => [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'phone_number' => $faker->numberBetween(254000000000, 256000000000),
    'email' => $faker->safeEmail,
    'amount' => $faker->randomNumber(null, true),
    'currency' => $faker->randomElement(['TZS', 'KES', 'UGX', 'USD']),
    'reference' => Str::random(7),
    'description' => $faker->sentence,
]);
