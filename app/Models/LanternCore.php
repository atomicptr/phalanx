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
        'activeIcon',
        'active',
        'activeTitle',
        'activeValues',
        'passive',
        'passiveValues',
        'patch',
    ];

    protected function casts(): array
    {
        return [
            'activeValues' => 'array',
            'passiveValues' => 'array',
        ];
    }

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }
}
