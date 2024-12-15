<?php

namespace App\Livewire;

use App\Enums\Permissions;
use App\Service\PermissionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class DeployButton extends Component
{
    private const RATE_LIMITER_KEY = 'deploy-frontend';

    private const RATE_LIMITER_ATTEMPTS = 1;

    private const RATE_LIMITER_PER_MINUTES = 1;

    public function render()
    {
        return view('livewire.deploy-button');
    }

    public function can(): bool
    {
        return RateLimiter::remaining(static::RATE_LIMITER_KEY, static::RATE_LIMITER_ATTEMPTS) > 0;
    }

    public function deploy()
    {
        RateLimiter::attempt(
            static::RATE_LIMITER_KEY,
            static::RATE_LIMITER_ATTEMPTS,
            function () {
                assert(PermissionService::can(Auth::user(), Permissions::CAN_PUBLISH));
                Artisan::call('app:deploy-frontend');
            },
            static::RATE_LIMITER_PER_MINUTES * Carbon::SECONDS_PER_MINUTE,
        );
    }
}
