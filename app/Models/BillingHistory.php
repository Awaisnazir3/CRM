<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingHistory extends Model
{
    protected $table = 'billinghistory';
    protected $primaryKey = 'TID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'AccountNo', 'CustomerID');
    }
}
