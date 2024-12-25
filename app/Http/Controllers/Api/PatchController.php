<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatchResource;
use App\Models\Patch;
use DateTime;
use DateTimeZone;

class PatchController extends Controller
{
    public function index()
    {
        $patch = Patch::where(['live' => true])->first();
        assert($patch instanceof Patch);

        $commit = env('SOURCE_COMMIT', 'dev');

        return [
            '__meta' => [
                'commit' => $commit,
                'buildTime' => (new DateTime(timezone: new DateTimeZone('UTC')))->getTimestamp(),
            ],
            'item' => PatchResource::make($patch),
        ];
    }
}
