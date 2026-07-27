<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Individual extends Model
{
    protected $fillable = [
        'prefix',
        'given_name',
        'surname',
        'suffix',
        'sex',
        'colour',
        'birthplace',
        'country_nation',
        'estimated_birth_year',
        'death_year',
        'appearance',
        'lbs_individual_id',
        'notes',
        'public_notes',
    ];

    public function enslavedMatches(): HasMany
    {
        return $this->hasMany(EnslavedMatch::class);
    }

    public function enslaverMatches(): HasMany
    {
        return $this->hasMany(EnslaverMatch::class);
    }

    public function relationshipsAsSubject(): HasMany
    {
        return $this->hasMany(Relationship::class, 'person1_id');
    }

    public function relationshipsAsRelated(): HasMany
    {
        return $this->hasMany(Relationship::class, 'person2_id');
    }
}
