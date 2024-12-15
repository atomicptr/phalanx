<?php

namespace App\Service;

use App\Enums\ArmourType;
use Atomicptr\Functional\Lst;
use Atomicptr\Functional\Map;

final class PerkCalculator
{
    private static function abcd(?int $a = null, ?int $b = null, ?int $c = null, ?int $d = null, ?int $cells = null): array
    {
        return [
            'a' => $a ?? 0,
            'b' => $b ?? 0,
            'c' => $c ?? 0,
            'd' => $d ?? 0,
            'cells' => $cells ?? 0,
        ];
    }

    public static function forLevel(ArmourType $armourType, int $level): array
    {
        return match ($armourType) {
            ArmourType::HEAD => match (true) {
                $level < 5 => self::abcd(b: 1, cells: 1),
                $level < 10 => self::abcd(a: 1, b: 2, cells: 1),
                $level < 15 => self::abcd(a: 2, b: 2, c: 1, cells: 1),
                $level < 20 => self::abcd(a: 2, b: 2, c: 2, cells: 1),
                default => self::abcd(a: 2, b: 3, c: 2, cells: 1),
            },
            ArmourType::TORSO => match (true) {
                $level < 5 => self::abcd(cells: 1),
                $level < 10 => self::abcd(b: 1, cells: 1),
                $level < 15 => self::abcd(a: 1, b: 2, cells: 2),
                $level < 20 => self::abcd(a: 2, b: 2, cells: 2),
                default => self::abcd(a: 3, b: 2, cells: 2),
            },
            ArmourType::ARMS => match (true) {
                $level < 5 => self::abcd(b: 1, cells: 1),
                $level < 10 => self::abcd(b: 2, c: 1, cells: 1),
                $level < 15 => self::abcd(a: 1, b: 2, c: 1, cells: 1),
                $level < 20 => self::abcd(a: 2, b: 2, c: 1, cells: 1),
                default => self::abcd(a: 2, b: 2, c: 2, cells: 1),
            },
            ArmourType::LEGS => match (true) {
                $level < 5 => self::abcd(cells: 1),
                $level < 10 => self::abcd(a: 1, d: 1, cells: 1),
                $level < 15 => self::abcd(a: 2, d: 1, cells: 2),
                $level < 20 => self::abcd(a: 2, d: 2, cells: 2),
                default => self::abcd(a: 3, d: 2, cells: 2),
            },
        };
    }

    public static function calculateForLevel(ArmourType $armourType, int $a, int $b, int $c, int $d, int $level): array
    {
        $data = self::forLevel($armourType, $level);

        $map = Map::empty();

        if ($data['a'] > 0) {
            $map = $map->set($a, $data['a']);
        }

        if ($data['b'] > 0) {
            $map = $map->set($b, $data['b']);
        }

        if ($data['c'] > 0) {
            $map = $map->set($c, $data['c']);
        }

        if ($data['d'] > 0) {
            $map = $map->set($d, $data['d']);
        }

        return Map::fromList(Lst::sort(fn (array $a, array $b) => intval($a[0]) <=> intval($b[0]), $map->toList()))->toArray();
    }

    public static function calculate(ArmourType $armourType, int $a, int $b, int $c, int $d): array
    {
        return Lst::filter(fn (array $arr) => count($arr['perks']) > 0, [
            [
                'min_level' => 1,
                'perks' => self::calculateForLevel($armourType, $a, $b, $c, $d, 1),
            ],
            [
                'min_level' => 5,
                'perks' => self::calculateForLevel($armourType, $a, $b, $c, $d, 5),
            ],
            [
                'min_level' => 10,
                'perks' => self::calculateForLevel($armourType, $a, $b, $c, $d, 10),
            ],
            [
                'min_level' => 15,
                'perks' => self::calculateForLevel($armourType, $a, $b, $c, $d, 15),
            ],
            [
                'min_level' => 20,
                'perks' => self::calculateForLevel($armourType, $a, $b, $c, $d, 20),
            ],
        ]);
    }
}
