<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


use CodeDelivery\Models\Category;
use CodeDelivery\Models\Client;
use CodeDelivery\Models\Product;
use CodeDelivery\Models\User;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Category::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(Product::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'price' => $faker->numberBetween(10, 200)
    ];
});

$factory->define(Client::class, function (Generator $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => $faker->postcode,
    ];
});