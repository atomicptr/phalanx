<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArmourResource;
use App\Http\Resources\LanternCoreResource;
use App\Http\Resources\PatchResource;
use App\Http\Resources\PerkResource;
use App\Http\Resources\WeaponResource;
use App\Enums\ArmourType;
use App\Models\Armour;
use App\Models\LanternCore;
use App\Models\Patch;
use App\Models\Perk;
use App\Models\Weapon;
use App\Utils\VersionUtil;
use Atomicptr\Functional\Lst;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexedArmourDataController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $patchFilterFunc = fn(Armour|Weapon|Perk|LanternCore $m) => VersionUtil::compare($patch->name, $m->patch()->first()->name) >= 0;

        $armours = Lst::map(
            fn(Armour $armour) => [
                'id' => $armour->id,
                'perks' => $armour->stats[count($armour->stats) - 1]["perks"],
                'type' => $armour->type,
            ],
            Armour::all()->all(),
        );

        $heads = [];
        $torsos = [];
        $arms = [];
        $legs = [];

        foreach ($armours as $armour) {
            $this->addArmour($heads, $torsos, $arms, $legs, $armour);
        }

        // Sort armour data at perk 0's
        $this->sort2PerksArmour($torsos);
        $this->sort2PerksArmour($legs);
        $this->sort3PerksArmour($heads);
        $this->sort3PerksArmour($arms);

        return [
            'patch' => PatchResource::make($patch),
            'heads' => $heads,
            'torsos' => $torsos,
            'arms' => $arms,
            'legs' => $legs,
        ];
    }

    private function addArmour(&$heads, &$torsos, &$arms, &$legs, $armour)
    {
        $tmpPerks = array_map(
            fn($perk) => [
                $perk["perk"] => $perk["amount"],
            ],
            $armour["perks"],
        );

        $perks = [];
        foreach ($tmpPerks as $item) {
            foreach ($item as $key => $value) {
                $perks[$key] = $value;
            }
        }

        $basicArmour = [
            'id' => $armour["id"],
            'perks' => $perks,
        ];

        $armour_perks = array_keys((array)$perks);
        sort($armour_perks);

        switch ($armour["type"]) {
            case ArmourType::HEAD:
                $this->InitialiseDictionary3Perks($heads, $armour_perks[0], $armour_perks[1], $armour_perks[2]);
                $heads[$armour_perks[0]][$armour_perks[1]][$armour_perks[2]][] = $basicArmour;
                $this->InitialiseDictionary3Perks($heads, $armour_perks[0], $armour_perks[1], 0);
                $heads[$armour_perks[0]][$armour_perks[1]][0][] = $basicArmour;
                $this->InitialiseDictionary3Perks($heads, $armour_perks[0], $armour_perks[2], 0);
                $heads[$armour_perks[0]][$armour_perks[2]][0][] = $basicArmour;
                $this->InitialiseDictionary3Perks($heads, $armour_perks[0], 0, 0);
                $heads[$armour_perks[0]][0][0][] = $basicArmour;

                $this->InitialiseDictionary3Perks($heads, $armour_perks[1], $armour_perks[2], 0);
                $heads[$armour_perks[1]][$armour_perks[2]][0][] = $basicArmour;
                $this->InitialiseDictionary3Perks($heads, $armour_perks[1], 0, 0);
                $heads[$armour_perks[1]][0][0][] = $basicArmour;

                $this->InitialiseDictionary3Perks($heads, $armour_perks[2], 0, 0);
                $heads[$armour_perks[2]][0][0][] = $basicArmour;

                $this->InitialiseDictionary3Perks($heads, 0, 0, 0);
                $heads[0][0][0][] = $basicArmour;
                break;
            case ArmourType::TORSO:
                $this->InitialiseDictionary2Perks($torsos, $armour_perks[0], $armour_perks[1]);
                $torsos[$armour_perks[0]][$armour_perks[1]][] = $basicArmour;
                $this->InitialiseDictionary2Perks($torsos, $armour_perks[0], 0);
                $torsos[$armour_perks[0]][0][] = $basicArmour;

                $this->InitialiseDictionary2Perks($torsos, $armour_perks[1], 0);
                $torsos[$armour_perks[1]][0][] = $basicArmour;

                $this->InitialiseDictionary2Perks($torsos, 0, 0);
                $torsos[0][0][] = $basicArmour;
                break;
            case ArmourType::ARMS:
                $this->InitialiseDictionary3Perks($arms, $armour_perks[0], $armour_perks[1], $armour_perks[2]);
                $arms[$armour_perks[0]][$armour_perks[1]][$armour_perks[2]][] = $basicArmour;
                $this->InitialiseDictionary3Perks($arms, $armour_perks[0], $armour_perks[1], 0);
                $arms[$armour_perks[0]][$armour_perks[1]][0][] = $basicArmour;
                $this->InitialiseDictionary3Perks($arms, $armour_perks[0], $armour_perks[2], 0);
                $arms[$armour_perks[0]][$armour_perks[2]][0][] = $basicArmour;
                $this->InitialiseDictionary3Perks($arms, $armour_perks[0], 0, 0);
                $arms[$armour_perks[0]][0][0][] = $basicArmour;

                $this->InitialiseDictionary3Perks($arms, $armour_perks[1], $armour_perks[2], 0);
                $arms[$armour_perks[1]][$armour_perks[2]][0][] = $basicArmour;
                $this->InitialiseDictionary3Perks($arms, $armour_perks[1], 0, 0);
                $arms[$armour_perks[1]][0][0][] = $basicArmour;

                $this->InitialiseDictionary3Perks($arms, $armour_perks[2], 0, 0);
                $arms[$armour_perks[2]][0][0][] = $basicArmour;

                $this->InitialiseDictionary3Perks($arms, 0, 0, 0);
                $arms[0][0][0][] = $basicArmour;
                break;
            case ArmourType::LEGS:
                $this->InitialiseDictionary2Perks($legs, $armour_perks[0], $armour_perks[1]);
                $legs[$armour_perks[0]][$armour_perks[1]][] = $basicArmour;
                $this->InitialiseDictionary2Perks($legs, $armour_perks[0], 0);
                $legs[$armour_perks[0]][0][] = $basicArmour;

                $this->InitialiseDictionary2Perks($legs, $armour_perks[1], 0);
                $legs[$armour_perks[1]][0][] = $basicArmour;

                $this->InitialiseDictionary2Perks($legs, 0, 0);
                $legs[0][0][] = $basicArmour;
                break;
        }
    }

    private function InitialiseDictionary2Perks(&$dict, $perk1, $perk2)
    {
        if (!array_key_exists($perk1, $dict)) {
            $dict[$perk1] = [];
        }
        if (!array_key_exists($perk2, $dict[$perk1])) {
            $dict[$perk1][$perk2] = [];
        }
    }

    private function InitialiseDictionary3Perks(&$dict, $perk1, $perk2, $perk3)
    {
        if (!array_key_exists($perk1, $dict)) {
            $dict[$perk1] = [];
        }
        if (!array_key_exists($perk2, $dict[$perk1])) {
            $dict[$perk1][$perk2] = [];
        }
        if (!array_key_exists($perk3, $dict[$perk1][$perk2])) {
            $dict[$perk1][$perk2][$perk3] = [];
        }
    }

    private function sort2PerksArmour(&$dict)
    {
        foreach ($dict as $key => $value) {
            if ($key == 0) {
                continue;
            }
            if (array_key_exists(0, $value)) {
                $value[0] = Lst::sort(fn(array $a, array $b) => $b["perks"][$key] <=> $a["perks"][$key], $value[0]);
            }
        }
    }

    private function sort3PerksArmour(&$dict)
    {
        foreach ($dict as $key => $value) {
            if ($key == 0) {
                continue;
            }
            if (array_key_exists(0, $value)) {
                if (array_key_exists(0, $value[0])) {
                    $value[0][0] = Lst::sort(fn(array $a, array $b) => $b["perks"][$key] <=> $a["perks"][$key], $value[0][0]);
                }
            }
        }
    }
}
