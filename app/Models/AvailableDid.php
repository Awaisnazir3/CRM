<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableDid extends Model
{
    protected $table = 'AvailableDIDS';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $guarded = [];
}
