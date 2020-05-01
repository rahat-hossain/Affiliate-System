<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    protected $guarded = [];



    public function referrer()
    {
        return $this->belongsTo(User::class, 'new_user_id');
    }

    public function relForReferedBy()
    {
        return $this->hasOne(User::class, 'id', 'refered_user_id');
    }
}
