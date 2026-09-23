<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'complain';
    protected $primaryKey = 'ComplainID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'UID', 'UID');
    }

    public function threads()
    {
        return $this->hasMany(ComplainThread::class, 'ComplainID', 'ComplainID')->orderBy('date', 'asc');
    }

    public function getStatusLabelAttribute()
    {
        if ($this->IsResolved == 1) {
            return 'Resolved';
        }
        return 'Open';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->IsResolved == 1 ? 'badge-emerald' : 'badge-amber';
    }
}
