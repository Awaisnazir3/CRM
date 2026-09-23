<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SipBuddy extends Model
{
    protected $table = 'sip_buddies';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];
}
