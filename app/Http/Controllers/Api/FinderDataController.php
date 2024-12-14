<?php

namespace App\Http\Controllers\Api;

use App\Enums\ArmourType;
use App\Http\Controllers\Controller;
use App\Models\Armour;
use App\Models\Patch;
use App\Utils\VersionUtil;
use Atomicptr\Functional\Lst;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;

class FinderDataController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $commit = env('SOURCE_COMMIT', 'dev');
        $cacheKey = "api-finder-data-{$patch->name}-$commit";

        return Cache::remember($cacheKey, Carbon::SECONDS_PER_MINUTE * 30, function () use ($patch, $commit) {
            $patchFilterFunc = fn (Armour $m) => VersionUtil::compare($patch->name, $m->patch()->first()->name) >= 0;

            $armours = Armour::all()->filter($patchFilterFunc)->map(
                fn (Armour $armour) => [
                    'id' => $armour->id,
                    'perks' => $armour->stats[count($armour->stats) - 1]['perks'],
                    'type' => $armour->type,
                ]
            );

            $categories = Lst::groupBy(fn (array $armour) => $armour['type']->value, $armours->all());

            $result = [
                '__meta' => [
                    'commit' => $commit,
                    'buildTime' => (new DateTime(timezone: new DateTimeZone('UTC')))->getTimestamp(),
                ],
            ];

            foreach ($categories as $categoryName => $items) {
                $result[$categoryName] = new \stdClass;

                foreach ($items as $item) {
                    $result[$categoryName] = $this->addArmourToPerksMap($result[$categoryName], $item);
                }

                $result[$categoryName] = $this->sortPerksArmour($result[$categoryName]);
            }

            return $result;
        });
    }

    private function addArmourToPerksMap(object $map, array $armour): object
    {
        $perks = new \stdClass;

        foreach ($armour['perks'] as $perk) {
            $perks->{$perk['perk']} = intval($perk['amount']);
        }

        $basicArmour = new \stdClass;
        $basicArmour->id = $armour['id'];
        $basicArmour->perks = $perks;

        $armourPerks = array_keys((array) $perks);
        sort($armourPerks);

        return match ($armour['type']) {
            ArmourType::HEAD, ArmourType::ARMS => $this->add3PerkArmourPiece($map, $armourPerks, $basicArmour),
            ArmourType::TORSO, ArmourType::LEGS => $this->add2PerkArmourPiece($map, $armourPerks, $basicArmour),
        };
    }

    private function add3PerkArmourPiece(object $map, array $armourPerks, object $basicArmour): object
    {
        $map = $this->initPerksMap($map, [$armourPerks[0], $armourPerks[1], $armourPerks[2]]);
        $map->{$armourPerks[0]}->{$armourPerks[1]}->{$armourPerks[2]}[] = $basicArmour;
        $map = $this->initPerksMap($map, [$armourPerks[0], $armourPerks[1], 0]);
        $map->{$armourPerks[0]}->{$armourPerks[1]}->{0}[] = $basicArmour;
        $map = $this->initPerksMap($map, [$armourPerks[0], $armourPerks[2], 0]);
        $map->{$armourPerks[0]}->{$armourPerks[2]}->{0}[] = $basicArmour;
        $map = $this->initPerksMap($map, [$armourPerks[0], 0, 0]);
        $map->{$armourPerks[0]}->{0}->{0}[] = $basicArmour;

        $map = $this->initPerksMap($map, [$armourPerks[1], $armourPerks[2], 0]);
        $map->{$armourPerks[1]}->{$armourPerks[2]}->{0}[] = $basicArmour;
        $map = $this->initPerksMap($map, [$armourPerks[1], 0, 0]);
        $map->{$armourPerks[1]}->{0}->{0}[] = $basicArmour;

        $map = $this->initPerksMap($map, [$armourPerks[2], 0, 0]);
        $map->{$armourPerks[2]}->{0}->{0}[] = $basicArmour;

        $map = $this->initPerksMap($map, [0, 0, 0]);
        $map->{0}->{0}->{0}[] = $basicArmour;

        return $map;
    }

    private function add2PerkArmourPiece(object $map, array $armourPerks, object $basicArmour): object
    {
        $map = $this->initPerksMap($map, [$armourPerks[0], $armourPerks[1]]);
        $map->{$armourPerks[0]}->{$armourPerks[1]}[] = $basicArmour;
        $map = $this->initPerksMap($map, [$armourPerks[0], 0]);
        $map->{$armourPerks[0]}->{0}[] = $basicArmour;

        $map = $this->initPerksMap($map, [$armourPerks[1], 0]);
        $map->{$armourPerks[1]}->{0}[] = $basicArmour;

        $map = $this->initPerksMap($map, [0, 0]);
        $map->{0}->{0}[] = $basicArmour;

        return $map;
    }

    private function initPerksMap(object $map, array $perks): object
    {
        $m = $map;

        foreach ($perks as $index => $perk) {
            if (! isset($m->{$perk})) {
                $m->{$perk} = $index === Lst::length($perks) - 1 ? [] : new \stdClass;
            }

            $m = $m->{$perk};
        }

        return $map;
    }

    private function sortPerksArmour(object $map, ?string $importantId = null): object
    {
        $map = clone $map;

        foreach ($map as $key => $value) {
            if (is_array($value)) {
                if ($importantId === '0') {
                    continue;
                }
                $map->{$key} = Lst::sort(fn (object $a, object $b) => $b->perks->{$importantId} <=> $a->perks->{$importantId}, $value);

                continue;
            }

            $map->{$key} = $this->sortPerksArmour($value, $importantId ?? $key);
        }

        return $map;
    }
}
