<?php

use App\Http\Controllers\Api\ArmoursController;
use App\Http\Controllers\Api\BuildsController;
use App\Http\Controllers\Api\CrowdinSourceStringsController;
use App\Http\Controllers\Api\FinderDataController;
use App\Http\Controllers\Api\I18nController;
use App\Http\Controllers\Api\LanternCoreController;
use App\Http\Controllers\Api\PatchController;
use App\Http\Controllers\Api\PerkController;
use App\Http\Controllers\Api\WeaponsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('weapons', WeaponsController::class)->only(['index']);
Route::apiResource('armours', ArmoursController::class)->only(['index']);
Route::apiResource('perks', PerkController::class)->only(['index']);
Route::apiResource('lantern-cores', LanternCoreController::class)->only(['index']);
Route::apiResource('patch', PatchController::class)->only(['index']);

Route::apiResource('builds', BuildsController::class)->only(['index']);
Route::apiResource('finder-data', FinderDataController::class)->only(['index']);
Route::apiResource('crowdin-source-strings', CrowdinSourceStringsController::class)->only(['index']);
Route::apiResource('i18n', I18nController::class)->only(['index']);
