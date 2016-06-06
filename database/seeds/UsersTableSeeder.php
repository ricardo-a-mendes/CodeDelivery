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
        factory(User::class, 20)->create()->each(function (User $createdUser){
            if ($createdUser->role == 'client') {
                $clientModel = factory(Client::class)->make();
                $createdUser->client()->save($clientModel);
            }
        });
    }
}