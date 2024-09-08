<?php

namespace App\Models;

use App\Enums\Element;
use App\Enums\WeaponType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'icon',
        'element',
        'specialName',
        'specialDescription',
        'specialValues',
        'passiveName',
        'passiveDescription',
        'passiveValues',
        'activeName',
        'activeDescription',
        'activeValues',
        'talents',
        'patch',
    ];

    protected function casts(): array
    {
        return [
            'type' => WeaponType::class,
            'element' => Element::class,
            'specialValues' => 'array',
            'passiveValues' => 'array',
            'activeValues' => 'array',
            'talents' => 'array',
        ];
    }

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }
}
