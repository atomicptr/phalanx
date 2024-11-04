<?php

namespace App\Http\Controllers\Api;

use App\Enums\ArmourType;
use App\Http\Controllers\Controller;
use App\Models\Armour;
use Atomicptr\Functional\Lst;

class IndexedArmourDataController extends Controller
{
    public function index()
    {
        $armours = Lst::map(
            fn (Armour $armour) => [
                'id' => $armour->id,
                'perks' => $armour->stats[count($armour->stats) - 1]['perks'],
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

        // Sort armour data where 1 perk is relevant
        $this->sort2PerksArmour($torsos);
        $this->sort2PerksArmour($legs);
        $this->sort3PerksArmour($heads);
        $this->sort3PerksArmour($arms);

        return [
            'heads' => $heads,
            'torsos' => $torsos,
            'arms' => $arms,
            'legs' => $legs,
        ];
    }

    private function addArmour(array &$heads, array &$torsos, array &$arms, array &$legs, $armour)
    {
        $perks = [];
        foreach ($armour['perks'] as $perk) {
            $perks[$perk['perk']] = $perk['amount'];
        }

        $basicArmour = [
            'id' => $armour['id'],
            'perks' => $perks,
        ];

        $armour_perks = array_keys((array) $perks);
        sort($armour_perks);

        switch ($armour['type']) {
            case ArmourType::HEAD:
                $this->initialiseMap3Perks($heads, $armour_perks[0], $armour_perks[1], $armour_perks[2]);
                $heads[$armour_perks[0]][$armour_perks[1]][$armour_perks[2]][] = $basicArmour;
                $this->initialiseMap3Perks($heads, $armour_perks[0], $armour_perks[1], 0);
                $heads[$armour_perks[0]][$armour_perks[1]][0][] = $basicArmour;
                $this->initialiseMap3Perks($heads, $armour_perks[0], $armour_perks[2], 0);
                $heads[$armour_perks[0]][$armour_perks[2]][0][] = $basicArmour;
                $this->initialiseMap3Perks($heads, $armour_perks[0], 0, 0);
                $heads[$armour_perks[0]][0][0][] = $basicArmour;

                $this->initialiseMap3Perks($heads, $armour_perks[1], $armour_perks[2], 0);
                $heads[$armour_perks[1]][$armour_perks[2]][0][] = $basicArmour;
                $this->initialiseMap3Perks($heads, $armour_perks[1], 0, 0);
                $heads[$armour_perks[1]][0][0][] = $basicArmour;

                $this->initialiseMap3Perks($heads, $armour_perks[2], 0, 0);
                $heads[$armour_perks[2]][0][0][] = $basicArmour;

                $this->initialiseMap3Perks($heads, 0, 0, 0);
                $heads[0][0][0][] = $basicArmour;
                break;
            case ArmourType::TORSO:
                $this->initialiseMap2Perks($torsos, $armour_perks[0], $armour_perks[1]);
                $torsos[$armour_perks[0]][$armour_perks[1]][] = $basicArmour;
                $this->initialiseMap2Perks($torsos, $armour_perks[0], 0);
                $torsos[$armour_perks[0]][0][] = $basicArmour;

                $this->initialiseMap2Perks($torsos, $armour_perks[1], 0);
                $torsos[$armour_perks[1]][0][] = $basicArmour;

                $this->initialiseMap2Perks($torsos, 0, 0);
                $torsos[0][0][] = $basicArmour;
                break;
            case ArmourType::ARMS:
                $this->initialiseMap3Perks($arms, $armour_perks[0], $armour_perks[1], $armour_perks[2]);
                $arms[$armour_perks[0]][$armour_perks[1]][$armour_perks[2]][] = $basicArmour;
                $this->initialiseMap3Perks($arms, $armour_perks[0], $armour_perks[1], 0);
                $arms[$armour_perks[0]][$armour_perks[1]][0][] = $basicArmour;
                $this->initialiseMap3Perks($arms, $armour_perks[0], $armour_perks[2], 0);
                $arms[$armour_perks[0]][$armour_perks[2]][0][] = $basicArmour;
                $this->initialiseMap3Perks($arms, $armour_perks[0], 0, 0);
                $arms[$armour_perks[0]][0][0][] = $basicArmour;

                $this->initialiseMap3Perks($arms, $armour_perks[1], $armour_perks[2], 0);
                $arms[$armour_perks[1]][$armour_perks[2]][0][] = $basicArmour;
                $this->initialiseMap3Perks($arms, $armour_perks[1], 0, 0);
                $arms[$armour_perks[1]][0][0][] = $basicArmour;

                $this->initialiseMap3Perks($arms, $armour_perks[2], 0, 0);
                $arms[$armour_perks[2]][0][0][] = $basicArmour;

                $this->initialiseMap3Perks($arms, 0, 0, 0);
                $arms[0][0][0][] = $basicArmour;
                break;
            case ArmourType::LEGS:
                $this->initialiseMap2Perks($legs, $armour_perks[0], $armour_perks[1]);
                $legs[$armour_perks[0]][$armour_perks[1]][] = $basicArmour;
                $this->initialiseMap2Perks($legs, $armour_perks[0], 0);
                $legs[$armour_perks[0]][0][] = $basicArmour;

                $this->initialiseMap2Perks($legs, $armour_perks[1], 0);
                $legs[$armour_perks[1]][0][] = $basicArmour;

                $this->initialiseMap2Perks($legs, 0, 0);
                $legs[0][0][] = $basicArmour;
                break;
        }
    }

    private function initialiseMap2Perks(array &$map, int $perk1, int $perk2)
    {
        if (! array_key_exists($perk1, $map)) {
            $map[$perk1] = [];
        }
        if (! array_key_exists($perk2, $map[$perk1])) {
            $map[$perk1][$perk2] = [];
        }
    }

    private function initialiseMap3Perks(array &$map, int $perk1, int $perk2, int $perk3)
    {
        if (! array_key_exists($perk1, $map)) {
            $map[$perk1] = [];
        }
        if (! array_key_exists($perk2, $map[$perk1])) {
            $map[$perk1][$perk2] = [];
        }
        if (! array_key_exists($perk3, $map[$perk1][$perk2])) {
            $map[$perk1][$perk2][$perk3] = [];
        }
    }

    private function sort2PerksArmour(array &$map)
    {
        foreach ($map as $key => $value) {
            if ($key === 0) {
                continue;
            }
            if (array_key_exists(0, $value)) {
                $map[$key][0] = Lst::sort(fn (array $a, array $b) => $b['perks'][$key] <=> $a['perks'][$key], $value[0]);
            }
        }
    }

    private function sort3PerksArmour(array &$map)
    {
        foreach ($map as $key => $value) {
            if ($key === 0) {
                continue;
            }
            if (array_key_exists(0, $value)) {
                if (array_key_exists(0, $value[0])) {
                    $map[$key][0][0] = Lst::sort(fn (array $a, array $b) => $b['perks'][$key] <=> $a['perks'][$key], $value[0][0]);
                }
            }
        }
    }
}