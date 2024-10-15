<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'api_key'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(fn (ApiKey $apiKey) => $apiKey->api_key ??= uuid_create());
    }
}
