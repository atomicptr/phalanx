<?php

namespace App\Http\Controllers\Api;

use App\Enums\Language;
use App\Http\Controllers\Controller;
use App\Models\Patch;
use App\Models\SourceString;
use App\Models\Translation;
use Atomicptr\Functional\Lst;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class I18nController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $commit = env('SOURCE_COMMIT', 'dev');
        $cacheKey = "api-i18n-{$patch->name}-$commit";
        $cacheTime = App::hasDebugModeEnabled() ? 1 : Carbon::SECONDS_PER_MINUTE * 30;

        return Cache::remember($cacheKey, $cacheTime, function () use ($commit) {
            $sourceStrings = SourceString::where('manual', true)->orderBy('ident', 'ASC')->get()->all();
            $translations = Translation::all()->all();

            $res = [
                '__meta' => [
                    'commit' => $commit,
                    'buildTime' => (new DateTime(timezone: new DateTimeZone('UTC')))->getTimestamp(),
                ],
            ];

            foreach (Language::values() as $lang) {
                if (! array_key_exists($lang, $res)) {
                    $res[$lang] = [];
                }

                foreach ($sourceStrings as $sourceString) {
                    assert($sourceString instanceof SourceString);

                    $translation = Lst::find(fn (Translation $trans) => $trans->ident === $sourceString->ident, $translations);

                    $content = $translation->isSome() ? $translation->value()->content : $sourceString->content;

                    $res[$lang][$sourceString->ident] = $content;
                }
            }

            return $res;
        });
    }
}
