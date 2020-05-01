<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    function relationToProductTable()
    {
        return $this->hasOne('App\Product', 'id','product_id');
    }

    function relationToDiscountRulesTable()
    {
        return $this->hasOne('App\DiscountRules', 'id', 'discount_rule_id');
    }
}
