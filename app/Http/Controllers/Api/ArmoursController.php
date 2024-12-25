<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ArmourResource;
use App\Models\Armour;

class ArmoursController extends DataController
{
    public function index()
    {
        return $this->buildCollectionResponse(Armour::class, ArmourResource::class);
    }
}
