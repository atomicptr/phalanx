<div class="navbar w-full sticky top-0 z-20 bg-base-100 bg-opacity-90 backdrop-blur">
    <div class="flex-none lg:hidden">
        <label for="drawer" class="btn btn-square btn-ghost">
            <x-heroicon-o-bars-3 class="inline-block h-6 w-6 stroke-current" />
        </label>
    </div>

    <div class="mx-2 flex-1 px-2 lg:hidden">
        <x-navbar-logo />
    </div>

    <div class="mx-2 flex-1 hidden lg:block"></div>

    <div class="dropdown dropdown-end hidden md:block">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
                <img src="{{ Auth::user()->gravatarUrl() }}" />
            </div>
        </div>
        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li>
                <a href="{{ route("admin.settings") }}" wire:navigate>
                    {{ __("Settings") }}
                </a>
            </li>
            <li>
                <a href="{{ route("logout") }}">
                    {{ __("Logout") }}
                </a>
            </li>
        </ul>
    </div>
</div>

