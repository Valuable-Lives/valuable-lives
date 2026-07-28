<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class Holding extends Model
{
    use Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parish_name' => $this->parish?->name,
            'town_address' => $this->town_address,
            'type' => $this->type,
            'size_category' => $this->size_category,
            'quality_flag' => $this->quality_flag,
        ];
    }

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

    public function annotations(): MorphMany
    {
        return $this->morphMany(RecordAnnotation::class, 'annotatable');
    }
}
