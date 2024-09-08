<?php

namespace App\Traits;

use App\Models\Patch;
use Atomicptr\Functional\Lst;

trait WithPatches
{
    public array $patches = [];

    public ?Patch $newestPatch = null;

    private function loadPatches()
    {
        $patches = Patch::orderBy('name', 'DESC')->get()->all();
        $this->patches = Lst::map(fn (Patch $patch) => [$patch['id'], $patch['name']], $patches); // TODO: dont show confidential patches here if user has no access
        $this->patches = array_combine(Lst::map([Lst::class, 'first'], $this->patches), Lst::map([Lst::class, 'second'], $this->patches));
        $this->newestPatch = Lst::length($patches) > 0 ? Lst::first($patches) : null;
    }
}
