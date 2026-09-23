<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'CountriesAvail';
    protected $primaryKey = 'CountryID';
    public $timestamps = false;

    protected $guarded = [];
}
