<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayPalAuthorize extends Model
{
    protected $table = 'PayPalAuthorize';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'OID', 'CustomerID');
    }
}
