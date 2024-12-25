<?php

namespace App\Models;

use App\Contracts\HasPatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class LanternCore extends Model implements Auditable, HasPatch
{
    use HasFactory;
    use IsAuditable;

    protected $fillable = [
        'name',
        'icon',
        'activeIcon',
        'active',
        'activeTitle',
        'activeValues',
        'activeCooldown',
        'passive',
        'passiveValues',
        'passiveTitle',
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
