<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RecordAnnotation extends Model
{
    protected $fillable = [
        'annotatable_type',
        'annotatable_id',
        'title',
        'content_html',
    ];

    public function annotatable(): MorphTo
    {
        return $this->morphTo();
    }
}
