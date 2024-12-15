<?php

namespace App\Traits;

use App\Models\Perk;
use Atomicptr\Functional\Lst;
use Atomicptr\Functional\Map;

trait WithPerksABCD
{
    public array $perks = [];

    public function loadPerks()
    {
        $this->perks = Perk::orderBy('name', 'ASC')->get()->all();
    }

    public function perkSelectOptions(): array
    {
        return Map::fromList(Lst::map(fn (Perk $perk) => [$perk->id, $perk->name], $this->perks))->toArray();
    }

    public function perkName(int $perkId): string
    {
        $perk = Lst::find(fn (Perk $perk) => $perk->id === $perkId, $this->perks);
        if ($perk->isNone()) {
            return (string) $perkId;
        }

        $perk = $perk->value();
        assert($perk instanceof Perk);

        return $perk->name;
    }
}
