<?php

namespace CodeDelivery\Services;

use CodeDelivery\Models\Order;
use CodeDelivery\Models\Product;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * OrderService constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository, ClientRepository $clientRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param $orderID
     * @param $clientID
     * @return Order
     */
    public function getOrNew($orderID, $clientID)
    {
        try {
            return $this->orderRepository->findOrFail($orderID);
        } catch (ModelNotFoundException $e) {
            $order = $this->orderRepository->create(['client_id' => $clientID]);
            $order->save();

            return $order;
        }
    }

    /**
     * Create an order item. It checks if the order already has the item.
     * @param Order $order
     * @param Product $product
     */
    public function createOrUpdateItem(Order $order, Product $product, $quantity = 0)
    {
        //Check if order already has the selected product
        $checkProductExistence = $order->orderItems()->where('product_id', $product->id);

        //If so, just update the quantity
        if ($checkProductExistence->count() > 0) {
            $orderItem = $checkProductExistence->get()->first();

            if ($quantity > 0)
                $orderItem->quantity = $quantity;
            else
                $orderItem->quantity++;

        } //otherwise, create a new Item
        else {
            $data = [
                'product_id' => $product->id,
                'order_id' => $order->id,
                'quantity' => ($quantity > 0) ? $quantity : 1,
                'price' => $product->price
            ];
            $orderItem = $order->orderItems()->create($data);
        }

        $order->orderItems()->save($orderItem);
    }
}