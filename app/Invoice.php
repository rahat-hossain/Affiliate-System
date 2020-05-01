<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    function UserTable()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }
}
