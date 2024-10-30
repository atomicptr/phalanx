<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ApiKey extends Model implements Auditable
{
    use HasFactory;
    use IsAuditable;

    protected $fillable = ['name', 'api_key'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(fn (ApiKey $apiKey) => $apiKey->api_key ??= uuid_create());
    }
}
