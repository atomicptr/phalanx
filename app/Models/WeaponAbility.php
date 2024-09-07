<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponAbility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'values',
    ];

    protected $casts = [
        'values' => 'array',
    ];
}
