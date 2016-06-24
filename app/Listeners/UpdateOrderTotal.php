<?php

namespace CodeDelivery\Listeners;

use CodeDelivery\Events\OrderItemWasSavedEvent;
use DB;

class UpdateOrderTotal
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderItemSaved  $event
     * @return void
     */
    public function handle(OrderItemWasSavedEvent $event)
    {
        $total = DB::table('order_items')
            ->selectRaw('sum(order_items.quantity*products.price) as total')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_id', '=', $event->order->id)
            ->first()
            ->total;
        $event->order->update(['total' => $total]);

    }
}
