<?php

namespace CodeDelivery\Listeners;

use CodeDelivery\Events\OrderItemsWereSavedEvent;


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
    public function handle(OrderItemsWereSavedEvent $event)
    {
        $total = $event->order
            ->selectRaw('sum(order_items.quantity*products.price) as total')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_id', '=', $event->order->id)
            ->first()
            ->total;

        $event->order->update(['total' => $total]);
    }
}
