<?php

namespace App\Models;

use App\Contracts\HasPatch;
use App\Enums\ArmourType;
use App\Enums\Element;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Armour extends Model implements Auditable, HasPatch
{
    use HasFactory;
    use IsAuditable;

    protected $fillable = [
        'name',
        'type',
        'description',
        'icon',
        'element',
        'patch',
        'perkA',
        'perkB',
        'perkC',
        'perkD',
    ];

    protected function casts(): array
    {
        return [
            'type' => ArmourType::class,
            'element' => Element::class,
        ];
    }

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }

    public function a(): BelongsTo
    {
        return $this->belongsTo(Perk::class, 'perkA');
    }

    public function b(): BelongsTo
    {
        return $this->belongsTo(Perk::class, 'perkB');
    }

    public function c(): BelongsTo
    {
        return $this->belongsTo(Perk::class, 'perkC');
    }

    public function d(): BelongsTo
    {
        return $this->belongsTo(Perk::class, 'perkD');
    }
}
