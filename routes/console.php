<?php

use App\Console\Commands\CreateSourceStrings;
use App\Console\Commands\CrowdinSync;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CreateSourceStrings::class)->hourly();
Schedule::command(CrowdinSync::class)->daily()->after(function () {
    Artisan::call('app:deploy-frontend');
});
