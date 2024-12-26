<ul class="menu w-80 p-4 bg-base-100 sticky top-0 z-20 bg-opacity-90 backdrop-blur min-h-screen lg:min-h-max">
    <div class="w-full block lg:hidden" style="height: 68px !important;"></div>

    <li>
        <a href="{{ route("admin.index") }}" wire:navigate>
            <x-heroicon-o-home class="w-6 h-6" />
            {{ __("Home") }}
        </a>
    </li>

    @canany(["is-admin", "can-access-patches"])
        <li>
            <h2 class="menu-title">
                {{ __("Administration") }}
            </h2>
            <ul>
                @can("is-admin")
                    <li>
                        <a href="{{ route("admin.user") }}" class="{{ \App\Utils\RouteUtil::active("admin.user") }}" wire:navigate>
                            <x-heroicon-o-users class="w-6 h-6" />
                            {{ __("Users") }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("admin.api-key") }}" class="{{ \App\Utils\RouteUtil::active("admin.api-key") }}" wire:navigate>
                            <x-heroicon-o-key class="w-6 h-6" />
                            {{ __("API Keys") }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("admin.source-string") }}" class="{{ \App\Utils\RouteUtil::active("admin.source-string") }}" wire:navigation>
                            <x-heroicon-o-globe-alt class="w-6 h-6" />
                            {{ __("Source Strings") }}
                        </a>
                    </li>
                @endcan
                @can("can-access-patches")
                    <li>
                        <a href="{{ route("admin.patch")}}" class="{{ \App\Utils\RouteUtil::active("admin.patch") }}" wire:navigate>
                            <x-heroicon-o-square-2-stack class="w-6 h-6" />
                            {{ __("Patches") }}
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany

    @can("can-edit-data")
        <li>
            <h2 class="menu-title">
                {{ __("Data") }}
            </h2>
            <ul>
                <li>
                    <a href="{{ route("admin.items.weapons")}}" class="{{ \App\Utils\RouteUtil::active("admin.items.weapons") }}" wire:navigate>
                        <img src="{{ asset("icons/weapons.png") }}" class="w-6 h-6" />
                        {{ __("Weapons") }}
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.items.armours")}}" class="{{ \App\Utils\RouteUtil::active("admin.items.armours") }}" wire:navigate>
                        <img src="{{ asset("icons/torso.png") }}" class="w-6 h-6" />
                        {{ __("Armours") }}
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.items.lantern-cores")}}" class="{{ \App\Utils\RouteUtil::active("admin.items.lantern-cores") }}" wire:navigate>
                        <img src="{{ asset("icons/lantern.png") }}" class="w-6 h-6" />
                        {{ __("Lantern Cores") }}
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.misc.perks")}}" class="{{ \App\Utils\RouteUtil::active("admin.misc.perks") }}" wire:navigate>
                        <img src="{{ asset("icons/prismatic.png") }}" class="w-6 h-6" />
                        {{ __("Perks") }}
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    @can("can-edit-builds")
        <li>
            <h2 class="menu-title">
                {{ __("Builds") }}
            </h2>
            <ul>
                <li>
                    <a href="{{ route("admin.builds.meta") }}" class="{{ \App\Utils\RouteUtil::active("admin.builds.meta") }}" wire:navigation>
                        <x-heroicon-o-sparkles class="w-6 h-6" />
                        {{ __("Meta Builds") }}
                    </a>
                </li>
                <li>
                    <a class="disabled">
                        <x-heroicon-o-arrow-uturn-up class="w-6 h-6" />
                        {{ __("Progression Builds") }}
                    </a>
                </li>
                <li>
                    <a class="disabled">
                        <x-heroicon-o-bolt class="w-6 h-6" />
                        {{ __("Trial Builds") }}
                    </a>
                </li>
            </ul>
        </li>
    @endcan
</ul>

