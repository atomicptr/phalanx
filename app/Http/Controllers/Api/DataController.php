<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArmourResource;
use App\Http\Resources\PatchResource;
use App\Http\Resources\PerkResource;
use App\Http\Resources\WeaponResource;
use App\Models\Armour;
use App\Models\Patch;
use App\Models\Perk;
use App\Models\Weapon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DataController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        return [
            'patch' => PatchResource::make($patch),
            'armours' => $this->collectionToObject(ArmourResource::collection(Armour::all())),
            'weapons' => $this->collectionToObject(WeaponResource::collection(Weapon::all())),
            'perks' => $this->collectionToObject(PerkResource::collection(Perk::all())),
        ];
    }

    private function collectionToObject(ResourceCollection $collection): array
    {
        $res = [];

        foreach ($collection as $elem) {
            assert($elem->id !== null);

            $res[$elem->id] = $elem;
        }

        return $res;
    }
}
