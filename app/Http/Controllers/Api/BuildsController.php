<?php

namespace App\Http\Controllers\Api;

use App\Enums\BuildCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuildResource;
use App\Models\Build;
use App\Models\Patch;
use App\Utils\VersionUtil;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class BuildsController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $commit = env('SOURCE_COMMIT', 'dev');
        $cacheKey = "api-builds-{$patch->name}-$commit";
        $cacheTime = App::hasDebugModeEnabled() ? 1 : Carbon::SECONDS_PER_MINUTE * 30;

        return Cache::remember($cacheKey, $cacheTime, function () use ($patch, $commit) {
            $buildFilterFunc = fn (BuildCategory $buildCategory) => fn (Build $b) => $b->buildCategory === $buildCategory;

            $builds = Build::all()
                ->filter(fn (Build $m) => \DauntlessBuilder\Build::fromId($m->buildId)->isOk())
                ->filter(fn (Build $m) => VersionUtil::compare($patch->name, $m->patch()->first()->name) >= 0);

            return [
                '__meta' => [
                    'commit' => $commit,
                    'buildTime' => (new DateTime(timezone: new DateTimeZone('UTC')))->getTimestamp(),
                ],
                'meta' => BuildResource::collection($builds->filter($buildFilterFunc(BuildCategory::META_BUILDS))),
            ];
        });
    }
}
