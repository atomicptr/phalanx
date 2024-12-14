<?php

namespace App\Models;

use App\Enums\Language;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'language',
        'ident',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'language' => Language::class,
        ];
    }
}
