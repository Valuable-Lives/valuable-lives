<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enslaver extends Model
{
    protected $fillable = [
        'prefix',
        'given_name',
        'surname',
        'suffix',
        'sex',
        'colour',
        'status',
        'lbs_individual_id',
    ];

    public function holdings(): HasMany
    {
        return $this->hasMany(EnslaverHolding::class);
    }
}
