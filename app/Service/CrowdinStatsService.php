<?php

namespace App\Service;

use App\Enums\Language;
use Atomicptr\Functional\Collection;
use CrowdinApiClient\Crowdin;
use CrowdinApiClient\Model\ProgressLanguage;

final class CrowdinStatsService
{
    public static function stats(): array
    {
        $projectId = config('services.crowdin.project');

        $crowdin = new Crowdin([
            'access_token' => config('services.crowdin.token'),
        ]);

        $res = [];

        foreach (Language::except([Language::ENGLISH]) as $lang) {
            assert($lang instanceof Language);

            $status = $crowdin->translationStatus->getLanguageProgress($projectId, $lang->crowdinKey());

            $total = Collection::from($status->__toArray())->map(fn (ProgressLanguage $l) => $l->getData()['words']['total'])->foldl(fn (int $acc, int $curr) => $acc + $curr, 0);
            $translated = Collection::from($status->__toArray())->map(fn (ProgressLanguage $l) => $l->getData()['words']['translated'])->foldl(fn (int $acc, int $curr) => $acc + $curr, 0);
            $approved = Collection::from($status->__toArray())->map(fn (ProgressLanguage $l) => $l->getData()['words']['approved'])->foldl(fn (int $acc, int $curr) => $acc + $curr, 0);

            $res[$lang->value] = [
                'total' => $total,
                'translated' => $translated,
                'approved' => $approved,
                'progress' => round(($translated / $total) * 100),
            ];
        }

        return $res;
    }
}
