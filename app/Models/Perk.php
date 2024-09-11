<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
