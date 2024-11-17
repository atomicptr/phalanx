<?php

use App\Enums\Permissions;
use App\Livewire\Page\Admin\ApiKey;
use App\Livewire\Page\Admin\Builds\Meta;
use App\Livewire\Page\Admin\Dashboard;
use App\Livewire\Page\Admin\Items\Armours;
use App\Livewire\Page\Admin\Items\LanternCores;
use App\Livewire\Page\Admin\Items\Weapons;
use App\Livewire\Page\Admin\Misc\Perks;
use App\Livewire\Page\Admin\Patch;
use App\Livewire\Page\Admin\Settings;
use App\Livewire\Page\Admin\User;
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
    Route::get('/admin/settings', Settings::class)->name('admin.settings');

    ////// Administration

    // users
    Route::get('/admin/user', User\Index::class)->name('admin.user')->can('is-admin');
    Route::get('/admin/user/new', User\Create::class)->name('admin.user.new')->can('is-admin');
    Route::get('/admin/user/{user}', User\Edit::class)->name('admin.user.edit')->can('is-admin');

    // api keys
    Route::get('/admin/api-key', ApiKey\Index::class)->name('admin.api-key')->can('is-admin');
    Route::get('/admin/api-key/new', ApiKey\Create::class)->name('admin.api-key.new')->can('is-admin');
    Route::get('/admin/api-key/{apiKey}', ApiKey\Edit::class)->name('admin.api-key.edit')->can('is-admin');

    // patches
    Route::get('/admin/patch', Patch\Index::class)->name('admin.patch')->can(Permissions::CAN_ACCESS_PATCHES->value);
    Route::get('/admin/patch/new', Patch\Create::class)->name('admin.patch.new')->can(Permissions::CAN_ACCESS_PATCHES->value);
    Route::get('/admin/patch/{patch:name}', Patch\Edit::class)->name('admin.patch.edit')->can(Permissions::CAN_ACCESS_PATCHES->value);

    ////// Data

    // weapon data
    Route::get('/admin/items/weapons', Weapons\Index::class)->name('admin.items.weapons')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/items/weapons/new', Weapons\Create::class)->name('admin.items.weapons.new')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/items/weapons/{weapon}', Weapons\Edit::class)->name('admin.items.weapons.edit')->can(Permissions::CAN_EDIT_DATA->value);

    // armour data
    Route::get('/admin/items/armours', Armours\Index::class)->name('admin.items.armours')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/items/armours/new', Armours\Create::class)->name('admin.items.armours.new')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/items/armours/{armour}', Armours\Edit::class)->name('admin.items.armours.edit')->can(Permissions::CAN_EDIT_DATA->value);

    // lantern cores data
    Route::get('/admin/items/lantern-cores', LanternCores\Index::class)->name('admin.items.lantern-cores')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/items/lantern-cores/new', LanternCores\Create::class)->name('admin.items.lantern-cores.new')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/items/lantern-cores/{lanternCore}', LanternCores\Edit::class)->name('admin.items.lantern-cores.edit')->can(Permissions::CAN_EDIT_DATA->value);

    // perk data
    Route::get('/admin/misc/perks', Perks\Index::class)->name('admin.misc.perks')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/misc/perks/new', Perks\Create::class)->name('admin.misc.perks.new')->can(Permissions::CAN_EDIT_DATA->value);
    Route::get('/admin/misc/perks/{perk}', Perks\Edit::class)->name('admin.misc.perks.edit')->can(Permissions::CAN_EDIT_DATA->value);

    ////// Builds

    // meta builds
    Route::get('/admin/builds/meta', Meta\Index::class)->name('admin.builds.meta')->can(Permissions::CAN_EDIT_BUILDS->value);
    Route::get('/admin/builds/meta/new', Meta\Create::class)->name('admin.builds.meta.new')->can(Permissions::CAN_EDIT_BUILDS->value);
    Route::get('/admin/builds/meta/{build}', Meta\Edit::class)->name('admin.builds.meta.edit')->can(Permissions::CAN_EDIT_BUILDS->value);
});
