<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryZone extends Model
{
    /** @inheritdoc */
    protected $table = 'country_zone';

    /** @inheritdoc */
    protected $fillable = [
        'name',
    ];
}
