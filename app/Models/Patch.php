<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'live',
        'confidential',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function (Patch $model) {
            if (! $model->live) {
                return;
            }

            // if this model is being marked as confidential AND its set to live remove confidential
            if ($model->confidential) {
                $model->confidential = false;
                $model->save();
            }

            // if this was set to live, remove live property from all others
            static::where('id', '!=', $model->id)->update(['live' => false]);
        });
    }
}
