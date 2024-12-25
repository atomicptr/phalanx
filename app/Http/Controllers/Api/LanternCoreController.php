<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LanternCoreResource;
use App\Models\LanternCore;

class LanternCoreController extends DataController
{
    public function index()
    {
        return $this->buildCollectionResponse(LanternCore::class, LanternCoreResource::class);
    }
}
