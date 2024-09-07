<div>
    <h1 class="text-xl mb-8">{{ __("Weapons") }}</h1>

    <div class="flex flex-row justify-end mb-8">
        <a class="btn btn-primary" href="{{ route("admin.items.weapons.new") }}">
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th width="32">{{ __("Icon") }}</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Type") }}
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($weapons as $weapon)
                    <tr>
                        <td>
                            <div class="avatar">
                                <div class="mask mask-squircle h-12 w-12">
                                    <img src="{{ asset($weapon->icon) }}" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route("admin.items.weapons.edit", ['weapon' => $weapon->id])}}" class="font-bold">
                                {{ $weapon->name }}
                            </a>
                        </td>
                        <td>
                            {{ $weapon->type->displayString() }}
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.items.weapons.edit", ['weapon' => $weapon->id])}}">
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                <a class="btn join-item" wire:click="delete({{ $weapon->id }})" wire:confirm="{{ __("Are you sure you want to delete this patch?")}}">
                                    <x-heroicon-o-trash class="w-6 h-6" />
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
