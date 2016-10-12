<?php

use CodeDelivery\Models\Client;
use CodeDelivery\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@codedelivery.com',
            'role' => 'admin',
            'password' => bcrypt('123456'),
            'remember_token' => '1 a 6',
        ]);

        $firstUser = factory(User::class)->create([
            'name' => 'User',
            'email' => 'user@codedelivery.com',
            'password' => bcrypt('123456'),
            'remember_token' => '1 a 6',
            'role' => 'client'
        ]);

        $clientModel = factory(Client::class)->make();
        $firstUser->client()->save($clientModel);

        $secondUser = factory(User::class)->create([
            'name' => 'Deliveryman',
            'email' => 'deliveryman@codedelivery.com',
            'password' => bcrypt('123456'),
            'remember_token' => '1 a 6',
            'role' => 'deliveryman'
        ]);

        $deliverymanModel = factory(Client::class)->make();
        $secondUser->client()->save($deliverymanModel);

        factory(User::class, 20)->create()->each(function (User $createdUser){
            if ($createdUser->role == 'client') {
                $clientModel = factory(Client::class)->make();
                $createdUser->client()->save($clientModel);
            }
        });
    }
}