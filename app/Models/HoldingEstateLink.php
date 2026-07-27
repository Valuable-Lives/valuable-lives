<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoldingEstateLink extends Model
{
    protected $fillable = [
        'holding_id',
        'estate_id',
        'match_rating',
        'gap_rating',
        'match_type',
        'match_notes',
        'public_match_notes',
        'match_user',
        'match_date',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'date',
        ];
    }

    public function holding(): BelongsTo
    {
        return $this->belongsTo(Holding::class);
    }
}
