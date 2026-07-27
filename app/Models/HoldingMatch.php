<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoldingMatch extends Model
{
    protected $fillable = [
        'entry_id',
        'holding_id',
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

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function holding(): BelongsTo
    {
        return $this->belongsTo(Holding::class);
    }
}
