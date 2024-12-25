<?php

namespace App\Http\Controllers\Api;

use App\Contracts\HasPatch;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeaponResource;
use App\Models\Patch;
use App\Models\Weapon;
use App\Service\CollectionConverter;
use App\Utils\VersionUtil;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class WeaponsController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $commit = env('SOURCE_COMMIT', 'dev');
        $cacheKey = "api-weapons-data-{$patch->name}-$commit";
        $cacheTime = App::hasDebugModeEnabled() ? 1 : Carbon::SECONDS_PER_MINUTE * 30;

        return Cache::remember($cacheKey, $cacheTime, function () use ($patch, $commit) {
            $items = CollectionConverter::toArray(WeaponResource::collection(Weapon::all()->filter(fn (HasPatch $m) => VersionUtil::compare($patch->name, $m->patch()->first()->name) >= 0)));

            return [
                '__meta' => [
                    'commit' => $commit,
                    'buildTime' => (new DateTime(timezone: new DateTimeZone('UTC')))->getTimestamp(),
                ],
                'items' => $items,
            ];
        });
    }
}
