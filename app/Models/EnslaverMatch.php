<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnslaverMatch extends Model
{
    protected $fillable = [
        'enslaver_record_id',
        'individual_id',
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

    public function enslaverRecord(): BelongsTo
    {
        return $this->belongsTo(EnslaverRecord::class);
    }

    public function individual(): BelongsTo
    {
        return $this->belongsTo(Individual::class);
    }
}
