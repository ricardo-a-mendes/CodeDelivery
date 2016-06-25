<?php

use CodeDelivery\Events\OrderItemsWereSavedEvent;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItem;
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
                $orderItemModel = factory(OrderItem::class)->make();
                $createdOrder->items()->save($orderItemModel);
            }
            
            //Updating Total
            Event::fire(new OrderItemsWereSavedEvent($createdOrder));
        });
    }
}
