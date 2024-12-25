<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PerkResource;
use App\Models\Perk;

class PerkController extends DataController
{
    public function index()
    {
        return $this->buildCollectionResponse(Perk::class, PerkResource::class);
    }
}
