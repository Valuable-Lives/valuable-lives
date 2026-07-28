<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class Individual extends Model
{
    use Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'given_name' => $this->given_name,
            'surname' => $this->surname,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'sex' => $this->sex,
            'colour' => $this->colour,
            'birthplace' => $this->birthplace,
            'country_nation' => $this->country_nation,
            'estimated_birth_year' => $this->estimated_birth_year,
            'death_year' => $this->death_year,
        ];
    }

    public function enslavedMatches(): HasMany
    {
        return $this->hasMany(EnslavedMatch::class);
    }

    public function enslaverMatches(): HasMany
    {
        return $this->hasMany(EnslaverMatch::class);
    }

    public function enslavedRecords(): HasManyThrough
    {
        return $this->hasManyThrough(EnslavedRecord::class, EnslavedMatch::class, 'individual_id', 'id', 'id', 'enslaved_record_id');
    }

    public function enslaverRecords(): HasManyThrough
    {
        return $this->hasManyThrough(EnslaverRecord::class, EnslaverMatch::class, 'individual_id', 'id', 'id', 'enslaver_record_id');
    }

    public function relationshipsAsSubject(): HasMany
    {
        return $this->hasMany(Relationship::class, 'person1_id');
    }

    public function relationshipsAsRelated(): HasMany
    {
        return $this->hasMany(Relationship::class, 'person2_id');
    }

    public function annotations(): MorphMany
    {
        return $this->morphMany(RecordAnnotation::class, 'annotatable');
    }

    public function isEnslaved(): bool
    {
        return $this->enslavedMatches()->exists();
    }

    public function isEnslaver(): bool
    {
        return $this->enslaverMatches()->exists();
    }
}
