<?php

namespace App\Http\Resources;

use App\Utils\VersionUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$major, $minor, $patch] = VersionUtil::parse($this->name);

        return [
            'name' => $this->name,
            'version' => [
                'major' => $major,
                'minor' => $minor,
                'patch' => $patch,
            ],
        ];
    }
}
