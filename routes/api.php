<?php

use App\Http\Controllers\Api\DataController;
use Illuminate\Support\Facades\Route;

Route::apiResource('data', DataController::class)->only(['index']);
