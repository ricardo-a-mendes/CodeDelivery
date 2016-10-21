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

    const STATUS_CANCELED = 0;
    const STATUS_CREATING = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_SHIPPING = 3;
    const STATUS_DELIVERED = 4;

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
    public function getOrNew($orderID, $clientID = null)
    {
        try {
            return $this->orderRepository->findOrFail($orderID);
        } catch (ModelNotFoundException $e) {
            $order = $this->orderRepository->create(['client_id' => $clientID]);
            $order->save();

            return $order;
        }
    }

    public function store($data)
    {
        \DB::beginTransaction();
        try {
            //TODO:Implemnt (Refactory)
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Create an order item. It checks if the order already has the item.
     *
     * @param Order $order
     * @param Product $product
     * @param int $quantity
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

    /**
     * Update Order status
     *
     * @param $id
     * @param $status
     * @return mixed
     * @throws \Exception
     */
    public function updateStatus($id, $status)
    {
        $existentStatuses = [
            self::STATUS_CANCELED,
            self::STATUS_CREATING,
            self::STATUS_PROCESSING,
            self::STATUS_SHIPPING,
            self::STATUS_DELIVERED,
        ];

        if (!in_array($status, $existentStatuses))
            throw new \Exception('Invalid Status.');

        try {
            $order = $this->orderRepository->findOrFail($id);

            $order->status = $status;
            $order->save();
            return $order;

        } catch (ModelNotFoundException $e) {
            throw new \Exception('Order not found.');
        }
    }
}