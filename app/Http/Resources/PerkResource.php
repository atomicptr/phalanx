<?php

namespace App\Http\Resources;

use App\Models\Perk;
use App\Service\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerkResource extends JsonResource
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
            'name' => TranslationService::i18n(Perk::class, $this->id, 'name', $this->name),
            'type' => $this->type,
            'effect' => TranslationService::i18n(Perk::class, $this->id, 'effect', $this->effect),
            'values' => ValuesResource::make($this->values),
            'threshold' => $this->threshold,
        ];
    }
}
