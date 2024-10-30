<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Patch extends Model implements Auditable
{
    use HasFactory;
    use IsAuditable;

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
