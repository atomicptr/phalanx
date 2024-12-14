<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceString extends Model
{
    protected $fillable = [
        'ident',
        'content',
        'model',
        'modelId',
        'modelField',
    ];
}
