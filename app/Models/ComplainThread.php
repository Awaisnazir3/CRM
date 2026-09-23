<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplainThread extends Model
{
    protected $table = 'ComplainThread';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Complain::class, 'ComplainID', 'ComplainID');
    }
}
