<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cdr extends Model
{
    protected $table = 'cdrs_new';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'OID', 'CustomerID');
    }

    public function getDurationFormattedAttribute()
    {
        $secs = (int)$this->billseconds;
        $mins = floor($secs / 60);
        $remSecs = $secs % 60;
        return sprintf('%02d:%02d', $mins, $remSecs);
    }

    public function getDispositionBadgeAttribute()
    {
        $disp = strtoupper($this->disposition ?? '');
        return match ($disp) {
            'ANSWERED' => 'badge-emerald',
            'NO ANSWER', 'NOANSWER' => 'badge-amber',
            'BUSY' => 'badge-orange',
            'FAILED' => 'badge-rose',
            default => 'badge-slate',
        };
    }
}
