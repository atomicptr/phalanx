<?php

use App\Http\Controllers\Api\BuildsController;
use App\Http\Controllers\Api\CrowdinSourceStringsController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\FinderDataController;
use App\Http\Controllers\Api\I18nController;
use App\Http\Controllers\Api\WeaponsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('data', DataController::class)->only(['index']);
Route::apiResource('weapons', WeaponsController::class)->only(['index']);
Route::apiResource('builds', BuildsController::class)->only(['index']);
Route::apiResource('finder-data', FinderDataController::class)->only(['index']);
Route::apiResource('crowdin-source-strings', CrowdinSourceStringsController::class)->only(['index']);
Route::apiResource('i18n', I18nController::class)->only(['index']);
