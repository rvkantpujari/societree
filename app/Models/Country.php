<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['country_name', 'country_code', 'country_phone_code'])]
class Country extends Model
{
    use SoftDeletes;
}
