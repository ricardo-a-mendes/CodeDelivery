<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository
 * @package namespace CodeDelivery\Repositories;
 */
interface OrderRepository extends RepositoryInterface
{
    /**
     * Try to find the model. If it fails, throw a ModelNotFoundException
     *
     * @param $id
     * @return mixed
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail($id);

    /**
     * @return Options to populate Status Combo for Orders
     */
    public function getOrderStatusOptions();
}
