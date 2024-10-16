<?php

namespace App\Console\Commands;

use App\Enums\ArmourType;
use App\Enums\Element;
use App\Models\Armour;
use App\Models\Patch;
use App\Models\Perk;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Illuminate\Filesystem\join_paths;

class ImportArmourData extends Command
{
    protected $signature = 'app:import-armour-data';

    protected $description = 'Import data from user created CSV files';

    public function handle()
    {
        $cwd = getcwd();
        $perkCsvFile = join_paths($cwd, 'Dauntless_Perks.csv');
        $dataCsvFile = join_paths($cwd, 'Dauntless_Armor.csv');
        $patternCsvFile = join_paths($cwd, 'Dauntless_ArmorPattern.csv');

        if (! file_exists($perkCsvFile)) {
            $this->output->writeln("Could not find file: $perkCsvFile");

            return;
        }

        if (! file_exists($dataCsvFile)) {
            $this->output->writeln("Could not find file: $dataCsvFile");

            return;
        }

        if (! file_exists($patternCsvFile)) {
            $this->output->writeln("Could not find file: $patternCsvFile");

            return;
        }

        // parse perks...
        $perkCsvHandle = fopen($perkCsvFile, 'r');
        assert($perkCsvFile !== false);

        $patch = Patch::where(['live' => true])->first();

        $first = true;

        $colName = 0;
        $colCost = 5;
        $colDesc = 16;

        Perk::query()->truncate();

        $perkMap = [];

        while (($data = fgetcsv($perkCsvHandle)) !== false) {
            if ($first) {
                $first = false;

                continue;
            }

            $perk = Perk::create([
                'name' => $data[$colName],
                'effect' => $data[$colDesc],
                'values' => [],
                'threshold' => intval($data[$colCost]),
                'patch' => $patch->id,
            ]);

            $perkMap[$perk->name] = $perk->id;
        }

        fclose($perkCsvHandle);

        // parse armour
        $armourTemplates = [];

        $dataCsvHandle = fopen($dataCsvFile, 'r');

        $first = true;

        $colName = 0;
        $colElement = 3;
        $colA = 7;
        $colB = 12;
        $colC = 17;
        $colD = 22;

        while (($data = fgetcsv($dataCsvHandle)) !== false) {
            if ($first) {
                $first = false;

                continue;
            }

            $armourTemplates[$data[$colName]] = [
                'name' => ucfirst($data[$colName]),
                'element' => Element::from(strtolower($data[$colElement])),
                'a' => $perkMap[$data[$colA]],
                'b' => $perkMap[$data[$colB]],
                'c' => $perkMap[$data[$colC]],
                'd' => $perkMap[$data[$colD]],
            ];
        }

        fclose($dataCsvHandle);

        $patterns = [];

        $patternCsvHandle = fopen($patternCsvFile, 'r');

        $first = true;

        $colType = 0;
        $colLevel = 3;
        $colA = 4;
        $colB = 5;
        $colC = 6;
        $colD = 7;

        $parse = function (mixed $val) {
            if (empty($val)) {
                return null;
            }

            return intval($val);
        };

        while (($data = fgetcsv($patternCsvHandle)) !== false) {
            if ($first) {
                $first = false;

                continue;
            }

            $type = ArmourType::from(strtolower(match ($data[$colType]) {
                'Helmet' => 'Head',
                default => $data[$colType],
            }));

            if (! array_key_exists($type->value, $patterns)) {
                $patterns[$type->value] = [
                    'type' => $type,
                    'levels' => [],
                ];
            }

            $level = $data[$colLevel];

            $patterns[$type->value]['levels'][$level] = [
                'a' => $parse($data[$colA]),
                'b' => $parse($data[$colB]),
                'c' => $parse($data[$colC]),
                'd' => $parse($data[$colD]),
            ];
        }

        fclose($patternCsvHandle);

        Armour::query()->truncate();

        foreach ($armourTemplates as $armour) {
            foreach ($patterns as $pattern) {
                $name = $armour['name'].' '.ucfirst($pattern['type']->value);

                $stats = [];

                foreach ($pattern['levels'] as $level => $levelStats) {
                    $newStatsEntry = [
                        'id' => (string) Str::uuid(),
                        'min_level' => intval($level),
                        'perks' => [],
                    ];

                    if ($levelStats['a'] !== null) {
                        $newStatsEntry['perks'][] = [
                            'id' => (string) Str::uuid(),
                            'perk' => $armour['a'],
                            'amount' => $levelStats['a'],
                        ];
                    }

                    if ($levelStats['b'] !== null) {
                        $newStatsEntry['perks'][] = [
                            'id' => (string) Str::uuid(),
                            'perk' => $armour['b'],
                            'amount' => $levelStats['b'],
                        ];
                    }

                    if ($levelStats['c'] !== null) {
                        $newStatsEntry['perks'][] = [
                            'id' => (string) Str::uuid(),
                            'perk' => $armour['c'],
                            'amount' => $levelStats['c'],
                        ];
                    }

                    if ($levelStats['d'] !== null) {
                        $newStatsEntry['perks'][] = [
                            'id' => (string) Str::uuid(),
                            'perk' => $armour['d'],
                            'amount' => $levelStats['d'],
                        ];
                    }

                    if (! empty($newStatsEntry['perks'])) {
                        $stats[] = $newStatsEntry;
                    }
                }

                Armour::create([
                    'name' => $name,
                    'description' => '',
                    'type' => $pattern['type'],
                    'element' => $armour['element'],
                    'stats' => $stats,
                    'patch' => $patch->id,
                ]);
            }
        }
    }
}
