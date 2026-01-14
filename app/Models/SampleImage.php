<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleImage extends Model
{
    protected $fillable = [
        'sample_id',
        'filename',
        'original_filename',
        'path',
        'size',
        'mime_type',
    ];

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }
}
