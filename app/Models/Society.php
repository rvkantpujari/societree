<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->state->country();
    }
}
