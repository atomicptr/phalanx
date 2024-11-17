<?php

namespace App\Service;

use App\Models\Armour;
use App\Models\LanternCore;
use App\Models\Weapon;
use Atomicptr\Functional\Lst;
use DauntlessBuilder\Build;

final class BuildService
{
    public static function fetch(Build $build): object
    {
        $res = new \stdClass;

        $res->weapon1 = null;
        $res->weapon2 = null;

        $weaponsData = Weapon::findMany(Lst::filter(fn (int $id) => $id !== 0, [$build->weapon1->id, $build->weapon2->id]))->all();

        foreach ($weaponsData as $weapon) {
            if ($weapon->id === $build->weapon1->id) {
                $res->weapon1 = $weapon;

                continue;
            }

            if ($weapon->id === $build->weapon2->id) {
                $res->weapon2 = $weapon;

                continue;
            }
        }

        $res->head = null;
        $res->torso = null;
        $res->arms = null;
        $res->legs = null;

        $armoursData = Armour::findMany(Lst::filter(fn (int $id) => $id !== 0, [$build->head->id, $build->torso->id, $build->arms->id, $build->legs->id]))->all();

        foreach ($armoursData as $armour) {
            if ($armour->id === $build->head->id) {
                $res->head = $armour;

                continue;
            }

            if ($armour->id === $build->torso->id) {
                $res->torso = $armour;

                continue;
            }

            if ($armour->id === $build->arms->id) {
                $res->arms = $armour;

                continue;
            }

            if ($armour->id === $build->legs->id) {
                $res->legs = $armour;

                continue;
            }
        }

        $res->lanternCore = $build->lanternCore === 0 ? null : LanternCore::where('id', $build->lanternCore->id)->get()->first();

        return $res;
    }
}
