<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LanternCore extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'active_icon',
        'active',
        'active_values',
        'passive',
        'passive_values',
        'patch',
    ];

    protected function casts(): array
    {
        return [
            'active_values' => 'array',
            'passive_values' => 'array',
        ];
    }

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }
}
