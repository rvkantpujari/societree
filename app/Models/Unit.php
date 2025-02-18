<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Unit extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'unit_name',
        'block_id',
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
}
