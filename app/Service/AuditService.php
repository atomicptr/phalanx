<?php

namespace App\Service;

use App\Enums\BuildCategory;
use App\Models\Armour;
use App\Models\Build;
use App\Models\LanternCore;
use App\Models\Patch;
use App\Models\Perk;
use App\Models\Weapon;
use Atomicptr\Functional\Lst;
use Jfcherng\Diff\DiffHelper;
use OwenIt\Auditing\Models\Audit;

final class AuditService
{
    public static function logs(): array
    {
        $logs = Audit::all()->sortByDesc('created_at')->take(20)->all();

        return Lst::filter(
            fn (?object $data) => $data !== null,
            Lst::map(fn (Audit $audit) => self::convert($audit), $logs)
        );
    }

    private static function convert(Audit $audit): ?object
    {
        return (object) [
            'id' => $audit->id,
            'date' => $audit->created_at,
            'event' => $audit->event,
            'user' => $audit->user,
            'item' => $audit->auditable,
            'model' => (object) [
                'id' => $audit->auditable_id,
                'type' => $audit->auditable_type,
                'name' => match ($audit->auditable_type) {
                    Weapon::class => 'weapon',
                    Armour::class => 'armour piece',
                    LanternCore::class => 'lantern core',
                    Build::class => 'build',
                    Perk::class => 'perk',
                    Patch::class => 'patch',
                    default => $audit->auditable_type,
                },
                'link' => match ($audit->auditable_type) {
                    Weapon::class => route('admin.items.weapons.edit', ['weapon' => $audit->auditable_id]),
                    Armour::class => route('admin.items.armours.edit', ['armour' => $audit->auditable_id]),
                    LanternCore::class => route('admin.items.lantern-cores.edit', ['lanternCore' => $audit->auditable_id]),
                    Build::class => match ($audit->auditable->buildCategory) {
                        BuildCategory::META_BUILDS => route('admin.builds.meta.edit', ['build' => $audit->auditable_id]),
                        default => '#',
                    },
                    Perk::class => route('admin.misc.perks.edit', ['perk' => $audit->auditable_id]),
                    Patch::class => route('admin.patch.edit', ['patch' => $audit->auditable->name]),
                    default => '#',
                },
            ],
            'change' => (object) [
                'old' => $audit->old_values,
                'new' => $audit->new_values,
                'diff' => DiffHelper::calculate(
                    json_encode($audit->old_values, JSON_PRETTY_PRINT),
                    json_encode($audit->new_values, JSON_PRETTY_PRINT),
                    'Inline',
                    [],
                    [
                        'detailLevel' => 'line',
                    ]
                ),
            ],
        ];
    }
}
