<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryDistrict extends Model
{
    /** @inheritDoc */
    protected $table = 'country_district';

    /** @inheritdoc */
    protected $fillable = [
        'country_zone_id',
        'name',
    ];

}
