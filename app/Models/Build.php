<?php

namespace App\Models;

use App\Enums\BuildCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable as IsAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Build extends Model implements Auditable
{
    use IsAuditable;

    protected $fillable = [
        'name',
        'buildId',
        'description',
        'youtube',
        'buildCategory',
        'patch',
    ];

    protected $casts = [
        'buildCategory' => BuildCategory::class,
    ];

    public function patch(): BelongsTo
    {
        return $this->belongsTo(Patch::class, 'patch');
    }

    public function parseBuild(): \DauntlessBuilder\Build
    {
        // this should always work
        return \DauntlessBuilder\Build::fromId($this->buildId)->value();
    }
}
