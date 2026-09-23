<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VCareTicket extends Model
{
    protected $table = 'vcareticket';
    protected $primaryKey = 'VCTID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];
}
