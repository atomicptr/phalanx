<x-layouts.base>
    <div class="drawer lg:drawer-open">
        <input id="drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col">
            <x-navbar />

            <div class="p-2 container mx-auto">
                <x-flash-messages />

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

            <x-drawer-menu />
        </div>
    </div>
</x-layouts.base>
