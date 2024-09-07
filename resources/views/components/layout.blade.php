<x-base-layout>
    <div class="drawer lg:drawer-open">
        <input id="drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col">
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
                            <a>
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

            <div class="p-2">
                {{ $slot }}
            </div>
        </div>

        <div class="drawer-side">
            <div class="navbar sticky top-0 z-30 bg-base-100 bg-opacity-90 backdrop-blur" style="height: 68px !important;">
                <div class="mx-2 flex-1 px-2 hidden lg:block">
                    <x-navbar-logo />
                </div>
            </div>

            <label for="drawer" class="drawer-overlay"></label>

            <ul class="menu w-80 p-4 bg-base-100 sticky top-0 z-20 bg-opacity-90 backdrop-blur min-h-screen lg:min-h-max">
                <div class="w-full block lg:hidden" style="height: 68px !important;"></div>

                <li>
                    <a>
                        <x-heroicon-o-home class="w-6 h-6" />
                        {{ __("Home") }}
                    </a>
                </li>

                <li>
                    <h2 class="menu-title">
                        {{ __("Administration") }}
                    </h2>
                    <ul>
                        <li>
                            <a>
                                <x-heroicon-o-users class="w-6 h-6" />
                                {{ __("Users") }}
                            </a>
                        </li>
                        <li>
                            <a>
                                <x-heroicon-o-square-2-stack class="w-6 h-6" />
                                {{ __("Patches") }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <h2 class="menu-title">
                        {{ __("Item Data") }}
                    </h2>
                    <ul>
                        <li>
                            <a>
                                <x-heroicon-o-question-mark-circle class="w-6 h-6" />
                                {{ __("Omnicells") }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route("admin.items.weapons")}}" class="{{ \App\Utils\RouteUtil::active("admin.items.weapons") }}">
                                <x-heroicon-o-question-mark-circle class="w-6 h-6" />
                                {{ __("Weapons") }}
                            </a>
                        </li>
                        <li>
                            <a>
                                <x-heroicon-o-question-mark-circle class="w-6 h-6" />
                                {{ __("Armours") }}
                            </a>
                        </li>
                        <li>
                            <a>
                                <x-heroicon-o-question-mark-circle class="w-6 h-6" />
                                {{ __("Lanterns") }}
                            </a>
                        </li>
                        <li>
                            <a>
                                <x-heroicon-o-question-mark-circle class="w-6 h-6" />
                                {{ __("Perks") }}
                            </a>
                        </li>
                        <li>
                            <a>
                                <x-heroicon-o-question-mark-circle class="w-6 h-6" />
                                {{ __("Cells") }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <h2 class="menu-title">
                        {{ __("Misc Data") }}
                    </h2>
                    <ul>
                        <li>
                            <a>
                                <x-heroicon-o-question-mark-circle class="w-6 h-6" />
                                {{ __("Behemoths") }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</x-base-layout>
