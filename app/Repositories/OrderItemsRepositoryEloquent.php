<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\OrderItemsRepository;
use CodeDelivery\Models\OrderItems;
use CodeDelivery\Validators\OrderItemsValidator;

/**
 * Class OrderItemsRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderItemsRepositoryEloquent extends BaseRepository implements OrderItemsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderItems::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
