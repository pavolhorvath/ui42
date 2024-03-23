<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @inheritDoc */
    protected $table = 'city';

    /** @inheritdoc */
    protected $fillable = [
        'country_district_id',
        'name',
        'mayor_name',
        'address',
        'phone',
        'fax',
        'email',
        'web',
    ];
}
