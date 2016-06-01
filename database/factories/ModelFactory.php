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
use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItems;
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

$factory->define(Order::class, function (Generator $faker) {
    return [
        'client_id' => $faker->numberBetween(1,10),
        'user_deleveryman_id' => $faker->numberBetween(1,10),
        'total' => $faker->randomFloat(2, 30, 1000),
        'status' => 1,
    ];
});

$factory->define(OrderItems::class, function (Generator $faker) {
    return [
        'product_id' => $faker->numberBetween(1,150),
        'quantity' => $faker->numberBetween(1, 7),
        'price' => $faker->randomFloat(2, 30, 1000),
    ];
});