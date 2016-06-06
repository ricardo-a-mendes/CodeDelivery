<?php

use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItems;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->delete();
        factory(Order::class, 10)->create()->each(function (Order $createdOrder){

            foreach (range(1,rand(1,7)) as $qtde) {
                $orderItemModel = factory(OrderItems::class)->make();
                $createdOrder->items()->save($orderItemModel);
            }
            
            //Updating Total
            $q = DB::table('order_items')
                ->selectRaw('sum(quantity*price) as total')
                ->where('order_id', '=', $createdOrder->id)
                ->first();
            $createdOrder->update(['total' => $q->total]);
        });
    }
}
