<?php

namespace CodeDelivery\Repositories;

use CodeDelivery\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderItemsRepository
 * @package namespace CodeDelivery\Repositories;
 */
interface OrderItemRepository extends RepositoryInterface
{
    /**
     * @param $orderID
     * 
     * @return Order
     *
     * @throws ModelNotFoundException
     */
    public function getOrder($orderID);

    /**
     * Try to find the model. If it fails, throw a ModelNotFoundException
     *
     * @param $id
     * @return mixed
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail($id);
}
