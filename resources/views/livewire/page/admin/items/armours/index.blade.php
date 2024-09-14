<div>
    <h1 class="text-xl mb-8">{{ __("Armours") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th width="32">{{ __("Icon") }}</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Type") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($armours as $armour)
                    <tr>
                        <td>
                            <div class="avatar">
                                <div class="mask mask-squircle h-12 w-12">
                                    <img src="{{ asset($armour->icon ?? "icons/noicon.png") }}" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route("admin.items.armours.edit", ['armour' => $armour->id])}}" class="font-bold" wire:navigate>
                                {{ $armour->name }}
                            </a>
                        </td>
                        <td>
                            {{ $armour->type->displayString() }}
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.items.armours.edit", ['armour' => $armour->id])}}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                <a class="btn join-item" wire:click="delete({{ $armour->id }})" wire:confirm="{{ __("Are you sure you want to delete this armour piece?")}}">
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
        <a class="btn btn-primary" href="{{ route("admin.items.armours.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
