<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ItemData\WeaponsController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(route('admin.index')));

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/admin', [IndexController::class, 'index'])->name('admin.index');

    // items data
    // Route::get("/admin/items/omnicellss", [OmnicellssController::class, "index"])->name("admin.items.omnicellss");
    Route::get('/admin/items/weapons', [WeaponsController::class, 'index'])->name('admin.items.weapons');
    // Route::get("/admin/items/armours", [ArmoursController::class, "index"])->name("admin.items.armours");
    // Route::get("/admin/items/lanterns", [LanternsController::class, "index"])->name("admin.items.lanterns");
    // Route::get("/admin/items/perks", [PerksController::class, "index"])->name("admin.items.perks");
    // Route::get("/admin/items/cells", [CellsController::class, "index"])->name("admin.items.cells");
});
