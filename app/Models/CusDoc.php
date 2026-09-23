<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CusDoc extends Model
{
    protected $table = 'CusDocs';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'OID', 'CustomerID');
    }
}
