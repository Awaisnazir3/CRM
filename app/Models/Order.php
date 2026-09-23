<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'OID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID', 'CustomerID');
    }

    public function dids()
    {
        return $this->hasMany(Did::class, 'OID', 'OID');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'OID', 'OID');
    }
}
