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
use CodeDelivery\Models\Cupom;
use CodeDelivery\Models\OAuthClient;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItem;
use CodeDelivery\Models\Product;
use CodeDelivery\Models\User;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'role' => $faker->randomElement(['client', 'deliveryman']),
        'password' => bcrypt('123456'),
        'remember_token' => '1 a 6',
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
        'price' => $faker->randomFloat(2, 30, 500)
    ];
});

$factory->define(Client::class, function (Generator $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => $faker->postcode,
    ];
});

$factory->define(Order::class, function (Generator $faker) {

    $clients = DB::table('clients')->get(['id']);
    $clientID = rand(1, count($clients));

    $deliveryMen = DB::table('users')->where('role', '=', 'deliveryman')->get(['id']);
    $key = rand(0, count($deliveryMen)-1);
    $deliveryManID = $deliveryMen[$key]->id;

    return [
        'client_id' => $clientID,
        'user_deliveryman_id' => $deliveryManID,
        'total' => $faker->randomFloat(2, 30, 1000),
        'status' => 1,
    ];
});

$factory->define(OrderItem::class, function (Generator $faker) {

    $product_id = $faker->numberBetween(1,150);
    $price = DB::table('products')->where('id', '=', $product_id)->first(['price'])->price;

    return [
        'product_id' => $product_id,
        'quantity' => $faker->numberBetween(1, 7),
        'price' => $price,
    ];
});

$factory->define(Cupom::class, function (Generator $faker) {
    return [
        'code' => rand(100,10000),
        'value' => rand(50,100)
    ];
});

$factory->define(OAuthClient::class, function (Generator $faker) {
   return [
       'id' => 'appid01',
       'secret' => 'secret',
       'name' => 'Meu APP 01'
   ];
});