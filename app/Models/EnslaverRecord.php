<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EnslaverRecord extends Model
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
        'enslaver_name_full',
        'enslaver_name_prefix',
        'enslaver_given_name',
        'enslaver_surname',
        'enslaver_name_suffix',
        'enslaver_given_name_alias',
        'enslaver_surname_alias',
        'enslaver_gender',
        'enslaver_race',
        'enslaver_capacity',
        'enslaver_capacity_note',
        'enslaver_signed',
        'record_notes',
        'public_notes',
    ];

    protected function casts(): array
    {
        return [
            'enslaver_signed' => 'boolean',
        ];
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }

    public function enslaverMatch(): HasOne
    {
        return $this->hasOne(EnslaverMatch::class);
    }
}
