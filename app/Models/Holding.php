<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Holding extends Model
{
    protected $fillable = [
        'name',
        'parish_id',
        'town_address',
        'type',
        'size_category',
        'latitude',
        'longitude',
        'lbs_estate_id',
        'quality_flag',
        'description',
        'notes',
        'public_notes',
    ];

    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }

    public function holdingMatches(): HasMany
    {
        return $this->hasMany(HoldingMatch::class);
    }

    public function holdingEstateLinks(): HasMany
    {
        return $this->hasMany(HoldingEstateLink::class);
    }
}
