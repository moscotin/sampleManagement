<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sample extends Model
{
    protected $fillable = ['wafer_id', 'name', 'description'];

    public function wafer(): BelongsTo
    {
        return $this->belongsTo(Wafer::class);
    }

    public function fabricationSteps(): HasMany
    {
        return $this->hasMany(FabricationStep::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(SampleImage::class);
    }
}
