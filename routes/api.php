<?php

use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\IndexedArmourDataController;
use Illuminate\Support\Facades\Route;

Route::apiResource('data', DataController::class)->only(['index']);
Route::apiResource('indexedarmourdata', IndexedArmourDataController::class)->only(['index']);
