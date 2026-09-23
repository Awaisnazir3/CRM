<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LnpRequest extends Model
{
    protected $table = 'LNPRequest';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'OID', 'CustomerID');
    }

    public function getStatusLabelAttribute()
    {
        return match ((int)$this->Status) {
            0 => 'Submitted / Pending',
            1 => 'Processing',
            2 => 'Completed',
            3 => 'Rejected / Cancelled',
            default => 'Status ' . $this->Status,
        };
    }
}
