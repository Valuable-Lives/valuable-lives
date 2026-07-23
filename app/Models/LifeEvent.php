<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LifeEvent extends Model
{
    protected $fillable = [
        'individual_id',
        'holding_id',
        'event_type',
        'register_year',
        'event_date',
        'cause_notes',
        'origin_destination_holding_id',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function individual(): BelongsTo
    {
        return $this->belongsTo(Individual::class);
    }

    public function holding(): BelongsTo
    {
        return $this->belongsTo(Holding::class);
    }

    public function originDestinationHolding(): BelongsTo
    {
        return $this->belongsTo(Holding::class, 'origin_destination_holding_id');
    }
}
