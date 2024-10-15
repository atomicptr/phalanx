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
        $this->patches = Patch::orderBy('name', 'DESC')->get()->all();
        $this->newestPatch = Lst::length($this->patches) > 0 ? Lst::first($this->patches) : null;
    }
}
