<a class="btn btn-ghost flex flex-row items-center gap-2" href="{{ route('admin.index') }}" wire:navigate>
    <img src="https://www.dauntless-builder.com/assets/icon.png" class="h-8"/>
    <div class="text-xl">{{ Config::get("app.name") }}</div>
</a>
