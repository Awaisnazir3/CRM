<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'adminuser';
    protected $primaryKey = 'AUID';
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

    public function getFullNameAttribute()
    {
        return trim("{$this->AUFName} {$this->AULName}");
    }
}
