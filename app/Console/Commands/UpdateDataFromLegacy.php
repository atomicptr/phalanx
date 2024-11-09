<?php

namespace App\Console\Commands;

use App\Models\Armour;
use Atomicptr\Functional\Lst;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateDataFromLegacy extends Command
{
    protected $signature = 'app:update-data-from-legacy';

    protected $description = 'Update some data from legacy data';

    public function handle()
    {
        $dataUrl = 'https://www.dauntless-builder.com/data.json';

        $response = Http::get($dataUrl);
        $data = json_decode($response->getBody());

        DB::transaction(function () use ($data) {
            $this->updateArmours($data);
        });
    }

    private function updateArmours(object $data): void
    {
        $armours = Armour::all()->all();

        // update armours
        foreach ($data->armours as $armourData) {
            if (! property_exists($armourData, 'behemoth')) {
                continue;
            }

            if (property_exists($armourData, 'rarity') && $armourData->rarity === 'exotic') {
                continue;
            }

            $behemoth = $armourData->behemoth;
            $type = $armourData->type;

            $armour = Lst::find(fn (Armour $armour) => $armour->name === "$behemoth $type", $armours);

            if ($armour->isNone()) {
                continue;
            }

            $armour = $armour->value();
            assert($armour instanceof Armour);

            $this->output->writeln("Found matching legacy armour: '{$armour->name}' renaming to: '{$armourData->name}'");

            $armour->name = $armourData->name;

            if ($armour->icon === null) {
                $this->output->writeln("No icon found, will try to get: {$armourData->icon}");

                $iconData = file_get_contents('https://cdn.jsdelivr.net/gh/atomicptr/dauntless-builder'.$armourData->icon);

                if ($iconData === false) {
                    throw new Exception("Could not download icon at: {$armourData->icon}");
                }

                $tempIcon = tempnam('/tmp', 'db-icon-');
                $tempIconHandle = fopen($tempIcon, 'w');
                fwrite($tempIconHandle, $iconData);
                fclose($tempIconHandle);

                $ext = '.png';

                $storage = Storage::disk(getenv('APP_UPLOAD_DISK', 'public'));
                $res = $storage->putFileAs('uploads/icons/armours', $tempIcon, Str::slug($armour->name).$ext);

                if ($res === false) {
                    throw new Exception("Could not upload image: {$armourData->icon}");
                }

                $armour->icon = $res;
                $this->output->writeln("For armour '{$armour->name}', uploaded icon: {$armour->icon}");
            }

            assert($armour->save());
        }
    }
}
