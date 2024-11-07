<?php

use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\FinderDataController;
use Illuminate\Support\Facades\Route;

Route::apiResource('data', DataController::class)->only(['index']);
Route::apiResource('finder-data', FinderDataController::class)->only(['index']);
