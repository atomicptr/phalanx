<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SourceString;
use Atomicptr\Functional\Lst;
use Atomicptr\Functional\Map;

class CrowdinSourceStringsController extends Controller
{
    public function index()
    {
        return Map::fromList(
            Lst::map(fn (SourceString $string) => [$string->ident, $string->content], SourceString::all()->all())
        )->toArray();
    }
}
