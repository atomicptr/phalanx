<?php

namespace App\Models;

use App\Enums\Element;
use App\Enums\WeaponType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'icon',
        'element',
        'special',
        'passive',
        'active',
        'patch',
    ];

    protected function casts(): array
    {
        return [
            'type' => WeaponType::class,
            'element' => Element::class,
        ];
    }

    public function special(): HasOne
    {
        return $this->hasOne(WeaponAbility::class, localKey: 'special');
    }

    public function passive(): HasOne
    {
        return $this->hasOne(WeaponAbility::class, localKey: 'passive');
    }

    public function active(): HasOne
    {
        return $this->hasOne(WeaponAbility::class, localKey: 'active');
    }

    public function talents(): HasMany
    {
        return $this->hasMany(WeaponTalent::class);
    }

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }
}
