<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $guarded = [];

    function ProductTable()
    {
        return $this->hasOne('App\Product', 'id','product_id');
    }
    function PackageTable()
    {
        return $this->hasOne('App\Package', 'id','package_id');
    }
    function InvoiceTable()
    {
        return $this->hasOne('App\Invoice', 'id','invoice_id');
    }
}
