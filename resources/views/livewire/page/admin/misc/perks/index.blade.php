<div>
    <h1 class="text-xl mb-8">{{ __("Perks") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th width="64"></th>
                    <th>{{ __("Name") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($perks as $perk)
                    <tr>
                        <td>
                            <img class="w-8 h-8" src="{{ $perk->type->icon() }}" />
                        </td>
                        <td>
                            <a href="{{ route("admin.misc.perks.edit", ['perk' => $perk->id])}}" class="font-bold" wire:navigate>
                                {{ $perk->name }}
                            </a>
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.misc.perks.edit", ['perk' => $perk->id])}}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                <a class="btn join-item" wire:click="delete({{ $perk->id }})" wire:confirm="{{ __("Are you sure you want to delete this perk?")}}">
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
        <a class="btn btn-primary" href="{{ route("admin.misc.perks.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
