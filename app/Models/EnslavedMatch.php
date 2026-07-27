<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnslavedMatch extends Model
{
    protected $fillable = [
        'enslaved_record_id',
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

    public function enslavedRecord(): BelongsTo
    {
        return $this->belongsTo(EnslavedRecord::class);
    }

    public function individual(): BelongsTo
    {
        return $this->belongsTo(Individual::class);
    }
}
