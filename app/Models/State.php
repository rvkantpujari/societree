<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'country_id'
    ];

    // State belongs to a Country
    // A state belongs to one country, as every state must be part of a country.
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
