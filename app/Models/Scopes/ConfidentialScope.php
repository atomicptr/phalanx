<?php

namespace App\Models\Scopes;

use App\Enums\Permissions;
use App\Models\Patch;
use App\Service\PermissionService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ConfidentialScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();

        // if user can access confidential information dont do anything
        if (PermissionService::can($user, Permissions::CAN_ACCESS_CONFIDENTIAL)) {
            return;
        }

        // patch needs a bit of diffrent handling here
        if ($model instanceof Patch) {
            $builder->where('confidential', false);

            return;
        }

        $builder->whereHas('patch', fn ($q) => $q->where('confidential', false));
    }
}
