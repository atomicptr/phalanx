@props(['label', 'values'])

<div class="max-w-lg">
    <h2 class="text-xl mt-8 mb-2">
        {{ __($label) }}
    </h2>

    <div class="pl-4">
        @foreach ($values as $index => $stat)
            <div class="card bg-base-200 shadow-xl my-4 min-w-xl" wire:key="stat-{{ $stat['id'] }}">
                <div class="card-body">
                    <x-input.textfield label="Min Level" fieldName="form.stats.{{ $index }}.min_level" />

                    <h3 class="text-lg mb-4 mt-2">{{ __("Perks") }}</h3>

                    @foreach ($stat['perks'] as $perkIndex => $perk)
                        <div wire:key="stat-{{ $stat['id'] }}-perk-{{ $perk['id'] }}" class="card bg-base-300 shadow-xl my-4 min-w-xl">
                            <div class="card-body">
                                <x-input.perk-select fieldName="form.stats.{{ $index }}.perks.{{ $perkIndex }}.perk" :except="$this->selectedPerks($index, $perk['perk'] ?? -1)" />
                                <x-input.textfield label="Amount" fieldName="form.stats.{{ $index }}.perks.{{ $perkIndex }}.amount" />

                                <div class="card-actions justify-end mt-4">
                                    <button class="btn btn-sm btn-ghost" type="button" wire:click="removePerk({{ $index }}, {{ $perkIndex }})">
                                        <x-heroicon-o-trash class="w-6 h-6" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex flex-row w-full justify-center mt-4">
                        <button class="btn btn-sm btn-primary" type="button" wire:click="addPerk({{ $index }})">
                            <x-heroicon-o-plus class="w-6 h-6"/>
                            {{ __("Add Perk") }}
                        </button>
                    </div>

                    <div class="card-actions justify-end mt-4">
                        <button class="btn btn-sm btn-ghost" type="button" wire:click="removeStatSet({{ $index }})">
                            <x-heroicon-o-trash class="w-6 h-6" />
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex flex-row w-full justify-center mt-4">
        <button class="btn btn-sm btn-primary" type="button" wire:click="addStatSet()">
            <x-heroicon-o-plus class="w-6 h-6"/>
            {{ __("Add Armour Stat Set") }}
        </button>
    </div>
</div>
