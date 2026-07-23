<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Individual extends Model
{
    protected $fillable = [
        'given_name',
        'surname',
        'sex',
        'colour',
        'birthplace',
        'country_nation',
        'estimated_birth_year',
        'death_year',
        'appearance',
    ];

    public function registerEntries(): HasMany
    {
        return $this->hasMany(IndividualRegister::class);
    }

    public function lifeEvents(): HasMany
    {
        return $this->hasMany(LifeEvent::class);
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
