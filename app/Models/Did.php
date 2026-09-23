<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Did extends Model
{
    protected $table = 'DIDS';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'OID', 'UID');
    }

    public function option()
    {
        return $this->hasOne(DidOption::class, 'didid', 'DIDNumber');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'AreaID', 'CountryID');
    }

    public function getStatusLabelAttribute()
    {
        return match ((int)$this->Status) {
            0 => 'Available',
            1 => 'Active / Sold',
            2 => 'Reserved',
            3 => 'Under Check',
            4 => 'Released',
            default => 'Status ' . $this->Status,
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ((int)$this->Status) {
            0 => 'badge-emerald',
            1 => 'badge-blue',
            2 => 'badge-amber',
            3 => 'badge-purple',
            4 => 'badge-rose',
            default => 'badge-slate',
        };
    }
}
