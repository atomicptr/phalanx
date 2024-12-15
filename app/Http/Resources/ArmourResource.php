<?php

namespace App\Http\Resources;

use App\Models\Armour;
use App\Service\PerkCalculator;
use App\Service\TranslationService;
use Atomicptr\Functional\Lst;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArmourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => TranslationService::i18n(Armour::class, $this->id, 'name', $this->name),
            'type' => $this->type,
            'icon' => $this->icon,
            'element' => $this->element,
            'cell_slots' => $this->type->cellCount(),
            'stats' => $this->makeStats(),
        ];
    }

    private function makeStats(): array
    {
        return Lst::map(fn (array $arr) => [...$arr, 'perks' => (object) $arr['perks']],
            PerkCalculator::calculate($this->type, $this->perkA, $this->perkB, $this->perkC, $this->perkD)
        );
    }
}
