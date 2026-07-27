<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entry extends Model
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
        'previous_total_males',
        'previous_total_females',
        'total_last_return',
        'this_return_total_males',
        'this_return_total_females',
        'total_this_return',
        'number_increase',
        'number_decrease',
        'entry_text',
        'estate_name',
        'record_notes',
        'public_notes',
    ];

    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }

    public function enslavedRecords(): HasMany
    {
        return $this->hasMany(EnslavedRecord::class);
    }

    public function enslaverRecords(): HasMany
    {
        return $this->hasMany(EnslaverRecord::class);
    }

    public function holdingMatches(): HasMany
    {
        return $this->hasMany(HoldingMatch::class);
    }

    public function entryEvolutions(): HasMany
    {
        return $this->hasMany(EntryEvolution::class);
    }
}
