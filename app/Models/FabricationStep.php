<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FabricationStep extends Model
{
    protected $fillable = ['sample_id', 'user_id', 'activity_name', 'description', 'performed_at'];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
