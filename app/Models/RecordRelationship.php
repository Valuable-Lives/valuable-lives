<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordRelationship extends Model
{
    protected $fillable = [
        'enslaved_record_id',
        'enslaver_record_id',
        'relation_record_id',
        'relationship_full_text',
        'relation_to',
        'relation_from',
        'relation_full_name',
        'relation_name_prefix',
        'relation_surname',
        'relation_given_name',
        'relation_given_name_alias',
        'relation_surname_alias',
        'relation_name_suffix',
        'record_notes',
        'public_notes',
    ];

    public function enslavedRecord(): BelongsTo
    {
        return $this->belongsTo(EnslavedRecord::class);
    }

    public function enslaverRecord(): BelongsTo
    {
        return $this->belongsTo(EnslaverRecord::class);
    }
}
