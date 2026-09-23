<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    protected $table = 'BulkOrder';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'OID', 'CustomerID');
    }
}
