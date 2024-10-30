<?php

namespace App\Models;

use App\Enums\PerkType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Perk extends Model implements Auditable
{
    use HasFactory;
    use IsAuditable;

    protected $fillable = [
        'name',
        'type',
        'effect',
        'values',
        'threshold',
        'patch',
    ];

    protected $casts = [
        'type' => PerkType::class,
        'values' => 'array',
    ];

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }
}
