<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(route("admin.index")));

Route::get("/login", [LoginController::class, "index"])->name("login");

// admin
Route::get("/admin", [IndexController::class, "index"])
    ->name("admin.index")
    ->middleware("auth");
