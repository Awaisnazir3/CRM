<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'AddressID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function getFormattedAddressAttribute()
    {
        return implode(', ', array_filter([$this->Street1, $this->Street2, $this->City, $this->State, $this->ZipCode, $this->Country]));
    }
}
