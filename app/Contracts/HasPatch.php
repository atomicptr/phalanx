<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasPatch
{
    public function patch(): BelongsTo;
}
