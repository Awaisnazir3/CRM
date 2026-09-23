<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'UID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'Pass',
        'password',
        'hash_pass',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'UID', 'UID');
    }

    public function adminUser()
    {
        return $this->hasOne(AdminUser::class, 'UID', 'UID');
    }

    public function getAuthPassword()
    {
        return $this->hash_pass ?: $this->password ?: $this->Pass;
    }
}
