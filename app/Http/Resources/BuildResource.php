<?php

namespace App\Http\Resources;

use App\Models\Build;
use App\Service\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => TranslationService::i18n(Build::class, $this->id, 'name', $this->name),
            'buildId' => $this->buildId,
            'description' => TranslationService::i18n(Build::class, $this->id, 'description', $this->description),
            'youtube' => $this->youtube,
        ];
    }
}
