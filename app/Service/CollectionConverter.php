<?php

namespace App\Service;

use Illuminate\Http\Resources\Json\ResourceCollection;

final class CollectionConverter
{
    public static function toArray(ResourceCollection $collection): array
    {
        $res = [];

        foreach ($collection as $elem) {
            assert($elem->id !== null);

            $res[$elem->id] = $elem;
        }

        return $res;
    }
}
