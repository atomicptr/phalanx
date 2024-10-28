<?php

namespace App\Http\Resources;

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
            'name' => $this->name,
            'icon' => $this->icon,
            'active_icon' => $this->activeIcon,
            'active' => $this->makeAbility($this->active, $this->activeValues),
            'passive' => $this->makeAbility($this->passive, $this->passiveValues),
        ];
    }

    private function makeAbility(?string $description, array $values): ?array
    {
        if (empty($description)) {
            return null;
        }

        return [
            'description' => $description,
            'values' => ValuesResource::make($values),
        ];
    }
}
