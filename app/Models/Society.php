<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Society extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'random_slug_key',
        'number_of_units',
        'street',
        'landmark',
        'area',
        'city',
        'state_id',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        // When creating a society
        static::creating(function ($society) {
            // Generate a random slug key only on creation
            $society->random_slug_key = Str::random(20); // Change the length as needed

            // Generate the slug by appending the random key to the name
            $society->slug = Str::slug($society->name) . '-' . $society->random_slug_key;
        });

        // When updating a society (specifically the name)
        static::updating(function ($society) {
            // When the name is updated, only update the name part of the slug
            if ($society->isDirty('name')) {
                $society->slug = Str::slug($society->name) . '-' . $society->random_slug_key;
            }
        });
    }

    public static function generateSlug($name)
    {
        $slug = Str::slug($name);
        $uniqueCode = Str::random(16);
        return "{$slug}-{$uniqueCode}";
    }

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

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->state->country();
    }

    // 1-N relationship (Society has one or many Blocks)
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
