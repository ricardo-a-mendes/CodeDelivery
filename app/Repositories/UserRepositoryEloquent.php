<?php

namespace CodeDelivery\Repositories;

use CodeDelivery\Models\User;
use CodeDelivery\Validators\UserValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
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
     * Get a list of Delivery Man to populate a combo
     * 
     * @return array
     */
    public function getDeliveryMen($orderBy = 'name')
    {
        return $this->model->where('role', '=', 'deliveryman')
            ->orderBy($orderBy)
            ->lists('name', 'id');
    }
}
