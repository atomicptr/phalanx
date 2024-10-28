<div>
    <h1 class="text-xl mb-8">{{ __("Lantern Cores") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th width="140">{{ __("Icons") }}</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Ability") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lanternCores as $lanternCore)
                    <tr>
                        <td>
                            <div class="avatar">
                                <div class="mask mask-squircle h-12 w-12">
                                    <img src="{{ asset($lanternCore->icon ?? "icons/noicon.png") }}" />
                                </div>
                            </div>
                            <div class="avatar">
                                <div class="mask mask-squircle h-12 w-12">
                                    <img src="{{ asset($lanternCore->activeIcon ?? "icons/noicon.png") }}" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route("admin.items.lantern-cores.edit", ['lanternCore' => $lanternCore->id])}}" class="font-bold" wire:navigate>
                                {{ $lanternCore->name }}
                            </a>
                        </td>
                        <td>
                            {{ $lanternCore->activeTitle }}
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.items.lantern-cores.edit", ['lanternCore' => $lanternCore->id])}}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                <a class="btn join-item" wire:click="delete({{ $lanternCore->id }})" wire:confirm="{{ __("Are you sure you want to delete this lanternCore?")}}">
                                    <x-heroicon-o-trash class="w-6 h-6" />
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex flex-row mt-8">
        <a class="btn btn-primary" href="{{ route("admin.items.lantern-cores.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
