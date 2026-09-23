<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'UID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'UID', 'UID');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'AddressID', 'AddressID');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'UID', 'UID');
    }

    public function dids()
    {
        return $this->hasMany(Did::class, 'OID', 'CustomerID');
    }

    public function tickets()
    {
        return $this->hasMany(Complain::class, 'UID', 'UID');
    }

    public function documents()
    {
        return $this->hasMany(CusDoc::class, 'OID', 'CustomerID');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'OID', 'CustomerID');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->CFName} {$this->CMName} {$this->CLName}");
    }
}
