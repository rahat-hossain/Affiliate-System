<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    function relationToUser()
    {
        return $this->hasOne('App\User', 'id', 'for');
    }

}
