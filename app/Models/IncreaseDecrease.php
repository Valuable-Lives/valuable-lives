<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncreaseDecrease extends Model
{
    protected $table = 'increase_decreases';

    protected $fillable = [
        'enslaved_record_id',
        'increase_or_decrease',
        'full_text',
        'type',
        'day',
        'month',
        'year',
        'inc_dec_parish_id',
        'inc_dec_estate_name',
        'inc_dec_town',
        'record_notes',
        'public_notes',
    ];

    public function enslavedRecord(): BelongsTo
    {
        return $this->belongsTo(EnslavedRecord::class);
    }

    public function incDecParish(): BelongsTo
    {
        return $this->belongsTo(Parish::class, 'inc_dec_parish_id');
    }

    public function incDecEnslavers(): HasMany
    {
        return $this->hasMany(IncDecEnslaver::class);
    }
}
