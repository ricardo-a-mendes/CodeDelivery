<?php

namespace CodeDelivery\Repositories;

use CodeDelivery\Models\Client;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ClientRepository
 * @package namespace CodeDelivery\Repositories;
 */
interface ClientRepository extends RepositoryInterface
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
     * @param $userID
     * @return Client
     */
    public function getByUserID($userID);
}
