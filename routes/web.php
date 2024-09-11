<?php

use App\Livewire\Page\Admin\Dashboard;
use App\Livewire\Page\Admin\Items\Weapons;
use App\Livewire\Page\Admin\Misc\Perks;
use App\Livewire\Page\Admin\Patch;
use App\Livewire\Page\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(route('admin.index')));

Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    Auth::logout();

    return redirect(route('login'));
})->name('logout');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/admin', Dashboard::class)->name('admin.index');

    // administration
    Route::get('/admin/patch', Patch\Index::class)->name('admin.patch');
    Route::get('/admin/patch/new', Patch\Create::class)->name('admin.patch.new');
    Route::get('/admin/patch/{patch:name}', Patch\Edit::class)->name('admin.patch.edit');

    // items data
    Route::get('/admin/items/weapons', Weapons\Index::class)->name('admin.items.weapons');
    Route::get('/admin/items/weapons/new', Weapons\Create::class)->name('admin.items.weapons.new');
    Route::get('/admin/items/weapons/{weapon}', Weapons\Edit::class)->name('admin.items.weapons.edit');

    // misc data
    Route::get('/admin/misc/perks', Perks\Index::class)->name('admin.misc.perks');
    Route::get('/admin/misc/perks/new', Perks\Create::class)->name('admin.misc.perks.new');
    Route::get('/admin/misc/perks/{perk}', Perks\Edit::class)->name('admin.misc.perks.edit');
});
