<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class USArea extends Model
{
    protected $table = 'USAreas';
    protected $primaryKey = 'CodeID';
    public $timestamps = false;

    protected $guarded = [];
}
