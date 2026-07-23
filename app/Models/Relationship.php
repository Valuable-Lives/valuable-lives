<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relationship extends Model
{
    protected $fillable = [
        'person1_id',
        'person2_id',
        'relationship_type_id',
        'source',
        'confidence',
    ];

    public function person1(): BelongsTo
    {
        return $this->belongsTo(Individual::class, 'person1_id');
    }

    public function person2(): BelongsTo
    {
        return $this->belongsTo(Individual::class, 'person2_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(RelationshipType::class, 'relationship_type_id');
    }
}
