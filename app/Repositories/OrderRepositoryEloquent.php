<?php

namespace CodeDelivery\Repositories;

use DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Models\Order;
use CodeDelivery\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Try to find the model. If it fails, throw a ModelNotFoundException
     *
     * @param $id
     * @return mixed
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @return Options to populate Status Combo for Orders
     */
    public function getOrderStatusOptions()
    {
        return [0 => 'Canceled', 1 => 'In Progress', 2 => 'Shipping', 3 => 'Finalized'];
    }

    public function getByUserID($userID)
    {
        $orderTable = DB::table('orders');
        $collection = $orderTable
            ->join('clients', 'clients.id', '=', 'orders.client_id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->where('users.id', '=', $userID)->get(['orders.*']);

        return$collection;
    }
}
