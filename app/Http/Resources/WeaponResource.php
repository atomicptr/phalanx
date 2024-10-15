<?php

namespace App\Http\Resources;

use App\Enums\Stat;
use App\Enums\ValueType;
use App\Utils\NumberUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\NotImplementedException;

class WeaponResource extends JsonResource
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
            'special' => $this->makeAbility('special'),
            'active' => $this->makeAbility('active'),
            'passive' => $this->makeAbility('passive'),
            'talents' => $this->makeTalentArray(),
        ];
    }

    private function makeAbility(string $abilityName): ?array
    {
        $name = $this->{$abilityName.'Name'};
        $desc = $this->{$abilityName.'Description'};
        $values = $this->{$abilityName.'Values'};

        if (empty($desc)) {
            return null;
        }

        return [
            'name' => $name,
            'description' => $desc,
            'values' => ValuesResource::make($values),
        ];
    }

    private function makeTalentArray(): array
    {
        $res = [];

        $talents = array_values($this->talents);

        for ($row = 0; $row < 5; $row++) {
            if (! isset($talents[$row])) {
                $res[$row] = [null, null, null, null, null];

                continue;
            }

            $res[$row] = [
                'name' => $talents[$row]['name'] ?? null,
                'options' => [],
            ];

            $options = array_values($talents[$row]['options']);

            for ($col = 0; $col < 5; $col++) {
                if (! isset($options[$col])) {
                    $res[$row]['options'][$col] = null;

                    continue;
                }

                $res[$row]['options'][$col] = [
                    'name' => $options[$col]['name'] ?? null,
                    ...$this->parseTalentValue($options[$col]),
                ];
            }
        }

        return $res;
    }

    private function parseTalentValue(array $value): array
    {
        return match (ValueType::from($value['type'])) {
            ValueType::CUSTOM => [
                'type' => $value['type'],
                'description' => $value['description'],
                'values' => ValuesResource::make($value['values']),
            ],
            ValueType::STAT => [
                'type' => $value['type'],
                'stat' => $value['stat'] ?? Stat::MIGHT,
                'value' => NumberUtil::parse($value['value']),
            ],
            default => throw new NotImplementedException(code: 1729009805),
        };
    }
}
