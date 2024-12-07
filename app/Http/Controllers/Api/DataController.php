<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArmourResource;
use App\Http\Resources\LanternCoreResource;
use App\Http\Resources\PatchResource;
use App\Http\Resources\PerkResource;
use App\Http\Resources\WeaponResource;
use App\Models\Armour;
use App\Models\LanternCore;
use App\Models\Patch;
use App\Models\Perk;
use App\Models\Weapon;
use App\Utils\VersionUtil;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DataController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $patchFilterFunc = fn (Armour|Weapon|Perk|LanternCore $m) => VersionUtil::compare($patch->name, $m->patch()->first()->name) >= 0;

        return [
            '__meta' => [
                'buildTime' => (new DateTime(timezone: new DateTimeZone('UTC')))->getTimestamp(),
            ],
            'patch' => PatchResource::make($patch),
            'armours' => $this->collectionToObject(ArmourResource::collection(Armour::all()->filter($patchFilterFunc))),
            'weapons' => $this->collectionToObject(WeaponResource::collection(Weapon::all()->filter($patchFilterFunc))),
            'lantern_cores' => $this->collectionToObject(LanternCoreResource::collection(LanternCore::all()->filter($patchFilterFunc))),
            'perks' => $this->collectionToObject(PerkResource::collection(Perk::all()->filter($patchFilterFunc))),
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
