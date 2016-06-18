<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $fillable = [
        'code',
        'value',
    ];
}
