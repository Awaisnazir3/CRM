<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateCenter extends Model
{
    protected $table = 'RateCenters';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];
}
