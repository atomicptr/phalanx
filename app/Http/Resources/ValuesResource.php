<?php

namespace App\Http\Resources;

use App\Enums\Stat;
use App\Enums\ValueType;
use App\Utils\NumberUtil;
use Atomicptr\Functional\Lst;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\NotImplementedException;

class ValuesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return Lst::map(fn (array $value) => $this->parseValue($value), $this->resource);
    }

    private function parseValue(array $value): array
    {
        return match (ValueType::from($value['type'])) {
            ValueType::CUSTOM => [
                'name' => $value['name'],
                'type' => $value['type'],
                'value' => NumberUtil::parse($value['value']),
            ],
            ValueType::STAT => [
                'name' => $value['name'],
                'type' => $value['type'],
                'stat' => $value['stat'] ?? Stat::MIGHT,
                'value' => NumberUtil::parse($value['value']),
            ],
            default => throw new NotImplementedException(code: 1729006881),
        };
    }
}
