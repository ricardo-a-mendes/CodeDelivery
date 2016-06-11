<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'client_id',
        'user_deleveryman_id',
        'total',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function deliveryman()
    {
        return $this->belongsTo(User::class, 'user_deleveryman_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function getOrderStatusOptions()
    {
        return [0 => 'Canceled', 1 => 'In Progress', 2 => 'Shipping', 3 => 'Finalized'];
    }

}
