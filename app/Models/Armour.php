<?php

namespace App\Models;

use App\Enums\ArmourType;
use App\Enums\Element;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Armour extends Model implements Auditable
{
    use HasFactory;
    use IsAuditable;

    protected $fillable = [
        'name',
        'type',
        'description',
        'icon',
        'element',
        'stats',
        'patch',
    ];

    protected function casts(): array
    {
        return [
            'type' => ArmourType::class,
            'element' => Element::class,
            'stats' => 'array',
        ];
    }

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }
}
