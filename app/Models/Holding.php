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
    ];

    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }

    public function registerEntries(): HasMany
    {
        return $this->hasMany(HoldingRegister::class);
    }

    public function individuals(): HasMany
    {
        return $this->hasMany(IndividualRegister::class);
    }

    public function enslaverHoldings(): HasMany
    {
        return $this->hasMany(EnslaverHolding::class);
    }

    public function lifeEvents(): HasMany
    {
        return $this->hasMany(LifeEvent::class);
    }
}
