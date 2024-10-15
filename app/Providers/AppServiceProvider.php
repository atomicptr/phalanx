<?php

namespace App\Providers;

use App\Models\Armour;
use App\Models\Patch;
use App\Models\Perk;
use App\Models\Scopes\ConfidentialScope;
use App\Models\Weapon;
use App\Service\PermissionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PermissionService::boot();

        Patch::addGlobalScope(new ConfidentialScope);
        Weapon::addGlobalScope(new ConfidentialScope);
        Armour::addGlobalScope(new ConfidentialScope);
        // TODO: lantern cores
        Perk::addGlobalScope(new ConfidentialScope);
    }
}
