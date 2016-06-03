<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
        return $this->belongsTo(User::class);
    }
}
