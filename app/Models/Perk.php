<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perk extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'effect',
        'values',
        'threshold',
        'patch',
    ];

    protected $casts = [
        'values' => 'array',
    ];

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }
}
