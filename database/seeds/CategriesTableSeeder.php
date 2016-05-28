<?php

use CodeDelivery\Models\Category;
use Illuminate\Database\Seeder;

class CategriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 30)->create();
    }
}
