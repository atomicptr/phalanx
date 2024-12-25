<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WeaponResource;
use App\Models\Weapon;

class WeaponsController extends DataController
{
    public function index()
    {
        return $this->buildCollectionResponse(Weapon::class, WeaponResource::class);
    }
}
