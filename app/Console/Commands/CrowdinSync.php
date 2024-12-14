<?php

namespace App\Console\Commands;

use App\Enums\Language;
use App\Models\Translation;
use CrowdinApiClient\Crowdin;
use CrowdinApiClient\Model\TranslationProjectBuild;
use Illuminate\Console\Command;
use ZipArchive;

use function Illuminate\Filesystem\join_paths;

class CrowdinSync extends Command
{
    protected $signature = 'app:crowdin-sync';

    protected $description = 'Command description';

    public function handle()
    {
        $projectId = config('services.crowdin.project');

        $crowdin = new Crowdin([
            'access_token' => config('services.crowdin.token'),
        ]);

        $builds = $crowdin->translation->getProjectBuilds($projectId, ['limit' => 100]);

        $buildId = null;
        $rebuild = false;

        if ($builds->count() >= 1) {
            $build = $builds[0];

            assert($build instanceof TranslationProjectBuild);

            $buildId = $build->getData()['id'];
            $finishedAt = new \DateTime($build->getData()['finishedAt']);

            $now = new \DateTime;

            $rebuild = $now >= $finishedAt->add(\DateInterval::createFromDateString('2 hours'));
        }

        if ($rebuild) {
            $this->output->writeln('Rebuilding project...');
            $res = $crowdin->translation->buildProject($projectId);
            $buildId = $res->getData()['id'];
        } else {
            $this->output->writeln("Using existing build: $buildId");
        }

        assert($buildId !== null);

        // make sure the new build is done...
        while (true) {
            $res = $crowdin->translation->getProjectBuildStatus($projectId, $buildId);

            if ($res->getData()['status'] === 'finished') {
                break;
            }

            sleep(0.5);
        }

        $res = $crowdin->translation->downloadProjectBuild($projectId, $buildId);

        $url = $res->getData()['url'];

        $tempdir = join_paths(sys_get_temp_dir(), "db-crowdin-$buildId");
        if (! file_exists($tempdir)) {
            assert(mkdir($tempdir));
        }

        $zipFile = join_paths($tempdir, 'crowdin.zip');

        $this->output->writeln("Downloading project file to... $zipFile");

        assert(copy($url, $zipFile));

        $zip = new ZipArchive;
        $zip->open($zipFile);
        assert($zip->extractTo($tempdir));

        $counter = 0;

        foreach (Language::except([Language::ENGLISH])->toArray() as $language) {
            assert($language instanceof Language);
            $baseDir = join_paths($tempdir, $language->crowdinKey());

            $dataPath = join_paths($baseDir, 'data.json');

            if (! file_exists($dataPath)) {
                $this->output->writeln("Data File: $dataPath does not exist");

                continue;
            }

            $data = file_get_contents($dataPath);

            if (! $data) {
                $this->output->writeln("Could not read: $dataPath");

                continue;
            }

            $json = json_decode($data, true);

            foreach ($json as $key => $value) {
                Translation::updateOrInsert(
                    [
                        'ident' => $key,
                        'language' => $language->value,
                    ],
                    [
                        'content' => $value,
                    ],
                );

                $counter++;
            }
        }

        $this->output->writeln("$counter strings imported.");
    }
}
