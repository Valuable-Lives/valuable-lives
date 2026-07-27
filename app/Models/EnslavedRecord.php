<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EnslavedRecord extends Model
{
    protected $fillable = [
        'unique_identifier',
        'original_order',
        'source_piece_number',
        'image_file_name',
        'image_folder',
        'tna_ref',
        'registers_page_number',
        'register_year',
        'parish_id',
        'entry_id',
        'enslaved_name_full',
        'enslaved_name_prefix',
        'enslaved_name_number',
        'enslaved_given_name',
        'enslaved_surname',
        'enslaved_given_name_alias',
        'enslaved_surname_alias',
        'enslaved_name_suffix',
        'birthplace',
        'gender',
        'colour',
        'height',
        'physical_description',
        'occupation',
        'age_years',
        'age_months',
        'age_days',
        'remarks',
        'record_notes',
        'public_notes',
    ];

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }

    public function increaseDecreases(): HasMany
    {
        return $this->hasMany(IncreaseDecrease::class);
    }

    public function enslavedMatch(): HasOne
    {
        return $this->hasOne(EnslavedMatch::class);
    }
}
