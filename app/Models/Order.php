<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
    use TransformableTrait;

    public $id = 0;

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

}
