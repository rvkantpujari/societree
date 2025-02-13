<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Society extends Model
{
    use SoftDeletes;

    protected $fillables = [
        'name',
        'number_of_units',
        'street',
        'landmark',
        'city',
        'state_id',
        'description',
    ];
}
