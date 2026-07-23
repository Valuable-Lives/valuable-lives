<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parish extends Model
{
    protected $fillable = [
        'name',
        'boundary_geojson',
        'context_html',
    ];

    protected function casts(): array
    {
        return [
            'boundary_geojson' => 'array',
        ];
    }

    public function holdings(): HasMany
    {
        return $this->hasMany(Holding::class);
    }
}
