<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlossaryTerm extends Model
{
    protected $fillable = [
        'term',
        'definition',
        'aliases',
        'category',
    ];

    protected function casts(): array
    {
        return [
            'aliases' => 'array',
        ];
    }
}
