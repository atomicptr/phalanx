<?php

namespace App\Service;

use App\Enums\Permissions;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

final class PermissionService
{
    public static function boot(): void
    {
        Gate::define('is-admin', fn (User $user) => $user->is_admin);

        self::defineGate(Permissions::CAN_PUBLISH);
        self::defineGate(Permissions::CAN_ACCESS_CONFIDENTIAL);
        self::defineGate(Permissions::CAN_ACCESS_PATCHES);
        self::defineGate(Permissions::CAN_EDIT_BUILDS);
    }

    private static function defineGate(Permissions $perm): void
    {
        Gate::define($perm->value, fn (User $user) => PermissionService::can($user, $perm));
    }

    public static function can(?User $user, Permissions $perm): bool
    {
        if ($user === null) {
            return false;
        }

        if ($user->is_admin) {
            return true;
        }

        return match ($perm) {
            Permissions::CAN_PUBLISH => $user->can_publish,
            Permissions::CAN_ACCESS_CONFIDENTIAL => $user->can_access_confidential,
            Permissions::CAN_ACCESS_PATCHES => $user->can_access_patches,
            Permissions::CAN_EDIT_BUILDS => $user->can_edit_builds,
        };
    }
}
