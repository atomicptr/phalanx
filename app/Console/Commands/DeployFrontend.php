<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DeployFrontend extends Command
{
    protected $signature = 'app:deploy-frontend';

    protected $description = '(re)deploy the frontend';

    public function handle()
    {
        $cloudflareDeployHook = env('CLOUDFLARE_DEPLOY_HOOK');
        assert($cloudflareDeployHook !== null, 'CLOUDFLARE_DEPLOY_HOOK must be set');

        $this->output->writeln('Deploying frontend...');
        $response = Http::post($cloudflareDeployHook);

        $this->output->writeln("{$response->status()} {$response->getReasonPhrase()}");
        $this->output->writeln((string) $response->getBody());
    }
}
