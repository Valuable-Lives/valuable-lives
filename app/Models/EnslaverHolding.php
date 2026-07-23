<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnslaverHolding extends Model
{
    protected $fillable = [
        'enslaver_id',
        'holding_id',
        'capacity',
        'register_year',
    ];

    public function enslaver(): BelongsTo
    {
        return $this->belongsTo(Enslaver::class);
    }

    public function holding(): BelongsTo
    {
        return $this->belongsTo(Holding::class);
    }
}
