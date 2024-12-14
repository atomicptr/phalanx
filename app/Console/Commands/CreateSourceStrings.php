<?php

namespace App\Console\Commands;

use App\Models\Armour;
use App\Models\Build;
use App\Models\LanternCore;
use App\Models\Perk;
use App\Models\SourceString;
use App\Models\Weapon;
use App\Service\TranslationService;
use Illuminate\Console\Command;

class CreateSourceStrings extends Command
{
    protected $signature = 'app:create-source-strings';

    protected $description = 'Command description';

    public function handle()
    {
        // weapons
        $weapons = Weapon::all()->all();

        foreach ($weapons as $weapon) {
            assert($weapon instanceof Weapon);

            $this->updateOrInsert(Weapon::class, 'name', $weapon->id, $weapon->name);
            $this->updateOrInsert(Weapon::class, 'specialName', $weapon->id, $weapon->specialName);
            $this->updateOrInsert(Weapon::class, 'specialDescription', $weapon->id, $weapon->specialDescription);
            $this->updateOrInsert(Weapon::class, 'passiveName', $weapon->id, $weapon->passiveName);
            $this->updateOrInsert(Weapon::class, 'passiveDescription', $weapon->id, $weapon->passiveDescription);
            $this->updateOrInsert(Weapon::class, 'activeName', $weapon->id, $weapon->activeName);
            $this->updateOrInsert(Weapon::class, 'activeDescription', $weapon->id, $weapon->activeDescription);

            foreach ($weapon->talents ?? [] as $rowIndex => $row) {
                foreach ($row['options'] as $colIndex => $col) {
                    if ($col['type'] !== 'custom') {
                        continue;
                    }

                    $this->updateOrInsert(Weapon::class, "talent-{$rowIndex}-{$colIndex}-description", $weapon->id, $col['description']);
                }
            }
        }

        // armour pieces
        $armourPieces = Armour::all()->all();

        foreach ($armourPieces as $armour) {
            assert($armour instanceof Armour);

            $this->updateOrInsert(Armour::class, 'name', $armour->id, $armour->name);
        }

        // lantern cores
        $lanternCores = LanternCore::all()->all();

        foreach ($lanternCores as $lanternCore) {
            assert($lanternCore instanceof LanternCore);

            $this->updateOrInsert(LanternCore::class, 'name', $lanternCore->id, $lanternCore->name);
            $this->updateOrInsert(LanternCore::class, 'active', $lanternCore->id, $lanternCore->active);
            $this->updateOrInsert(LanternCore::class, 'activeTitle', $lanternCore->id, $lanternCore->activeTitle);
            $this->updateOrInsert(LanternCore::class, 'passive', $lanternCore->id, $lanternCore->passive);
            $this->updateOrInsert(LanternCore::class, 'passiveTitle', $lanternCore->id, $lanternCore->passiveTitle);
        }

        // perks
        $perks = Perk::all()->all();

        foreach ($perks as $perk) {
            assert($perk instanceof Perk);

            $this->updateOrInsert(Perk::class, 'name', $perk->id, $perk->name);
            $this->updateOrInsert(Perk::class, 'effect', $perk->id, $perk->effect);
        }

        // builds
        $builds = Build::all()->all();

        foreach ($builds as $build) {
            assert($build instanceof Build);

            $this->updateOrInsert(Build::class, 'name', $build->id, $build->name);
            $this->updateOrInsert(Build::class, 'description', $build->id, $build->description);
        }
    }

    private function updateOrInsert(string $model, string $field, int $id, ?string $content): void
    {
        if ($content === null) {
            return;
        }

        SourceString::updateOrInsert(
            [
                'ident' => TranslationService::makeIdent($model, $id, $field),
            ],
            [
                'model' => $model,
                'modelId' => $id,
                'modelField' => $field,
                'content' => $content,
            ],
        );
    }
}
