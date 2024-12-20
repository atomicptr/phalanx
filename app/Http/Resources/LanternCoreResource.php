<?php

namespace App\Http\Resources;

use App\Models\LanternCore;
use App\Service\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanternCoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => TranslationService::i18n(LanternCore::class, $this->id, 'name', $this->name),
            'icon' => $this->icon,
            'active_icon' => $this->activeIcon,
            'active_cooldown' => $this->activeCooldown,
            'active' => $this->makeAbility($this->activeTitle, $this->active, $this->activeValues, 'active'),
            'passive' => $this->makeAbility($this->passiveTitle, $this->passive, $this->passiveValues, 'passive'),
        ];
    }

    private function makeAbility(?string $title, ?string $description, array $values, string $abilityIdent): ?array
    {
        if (empty($description)) {
            return null;
        }

        return [
            'title' => TranslationService::i18n(LanternCore::class, $this->id, $abilityIdent.'Title', $title),
            'description' => TranslationService::i18n(LanternCore::class, $this->id, $abilityIdent, $description),
            'values' => ValuesResource::make($values),
        ];
    }
}
