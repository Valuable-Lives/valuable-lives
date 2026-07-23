<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoldingRegister extends Model
{
    protected $fillable = [
        'holding_id',
        'register_year',
        'enslaved_total',
        'enslaved_male',
        'enslaved_female',
        'enslaved_african',
        'enslaved_creole',
        'tna_reference',
        'tna_page',
    ];

    public function holding(): BelongsTo
    {
        return $this->belongsTo(Holding::class);
    }
}
