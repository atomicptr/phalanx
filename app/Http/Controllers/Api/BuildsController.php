<?php

namespace App\Http\Controllers\Api;

use App\Enums\BuildCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuildResource;
use App\Models\Build;
use App\Models\Patch;
use App\Utils\VersionUtil;

class BuildsController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $patchFilterFunc = fn (Build $m) => VersionUtil::compare($patch->name, $m->patch()->first()->name) >= 0;
        $buildFilterFunc = fn (BuildCategory $buildCategory) => fn (Build $b) => $b->buildCategory === $buildCategory;

        $builds = Build::all()->filter($patchFilterFunc);

        return [
            'meta' => BuildResource::collection($builds->filter($buildFilterFunc(BuildCategory::META_BUILDS))),
        ];
    }
}
