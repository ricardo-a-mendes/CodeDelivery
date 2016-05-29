<?php

use CodeDelivery\Models\Category;
use CodeDelivery\Models\Product;
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
        factory(Category::class, 30)->create()->each(function ($createdCategory) {
            for ($i = 0; $i < 5; $i++) {
                $productModel = factory(Product::class)->make();
                $createdCategory->getProducts()->save($productModel);
            }
        });
    }
}
