<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncDecEnslaver extends Model
{
    protected $fillable = [
        'increase_decrease_id',
        'enslaver_full_name',
        'enslaver_name_prefix',
        'enslaver_given_name',
        'enslaver_surname',
        'enslaver_given_name_alias',
        'enslaver_surname_alias',
        'enslaver_name_suffix',
        'record_notes',
        'public_notes',
    ];

    public function increaseDecrease(): BelongsTo
    {
        return $this->belongsTo(IncreaseDecrease::class);
    }
}
