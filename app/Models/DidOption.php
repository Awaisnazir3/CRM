<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DidOption extends Model
{
    protected $table = 'didOption';
    protected $primaryKey = 'didid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function did()
    {
        return $this->belongsTo(Did::class, 'didid', 'DIDNumber');
    }
}
