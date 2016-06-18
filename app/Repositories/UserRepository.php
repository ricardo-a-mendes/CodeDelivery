<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository
 * @package namespace CodeDelivery\Repositories;
 */
interface UserRepository extends RepositoryInterface
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
     * Get a list of Delivery Man to populate a combo
     *
     * @return array
     */
    public function getDeliveryMen($orderBy);
}
