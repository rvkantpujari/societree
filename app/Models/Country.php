<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'phone_code',
    ];

    public function getCreatedAtAttribute($value)
    {
        return $this->convertToUserTimezone($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->convertToUserTimezone($value);
    }

    // Do NOT override getDeletedAtAttribute()
    public function getDeletedAttribute($value)
    {
        return $this->deleted_at
            ? $this->convertToUserTimezone($this->deleted_at)
            : null;
    }

    private function convertToUserTimezone($value)
    {
        $timezone = Auth::check() ? Auth::user()->timezone : config('app.timezone');
        return Carbon::parse($value)->tz($timezone)->toDateTimeString();
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
