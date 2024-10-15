<?php

namespace App\Http\Resources;

use App\Utils\NumberUtil;
use Atomicptr\Functional\Lst;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArmourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'icon' => $this->icon,
            'element' => $this->element,
            'cell_slots' => $this->type->cellCount(),
            'stats' => $this->makeStats(),
        ];
    }

    private function makeStats(): array
    {
        return Lst::sort(fn (array $a, array $b) => $a['min_level'] <=> $b['min_level'], Lst::map(fn (array $stat) => [
            'min_level' => NumberUtil::parse($stat['min_level']),
            'perks' => Lst::map(fn (array $perk) => [
                'perk' => intval($perk['perk']),
                'amount' => intval($perk['amount']),
            ], $stat['perks']),
        ], $this->stats));
    }
}
