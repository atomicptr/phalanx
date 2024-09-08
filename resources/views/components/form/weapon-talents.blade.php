@props(['label', 'values'])

<div>
    <h2 class="text-xl mt-8 mb-2">
        {{ __($label) }}
    </h2>

    <div class="pl-4">
        @foreach ($values as $index => $talent)
            <div wire:key="talent-{{ $talent['id'] }}">
                <x-input.textfield label="Name" fieldName="form.talents.{{ $index }}.name" />

                <h3 class="text-lg mb-4 mt-2">{{ __("Options") }}</h3>

                <div class="flex flex-row flex-wrap gap-4">
                    @foreach ($talent['options'] ?? [] as $optionIndex => $option)
                        <div class="card bg-base-200 shadow-xl my-4 min-w-xl" wire:key="option-{{ $option['id'] }}">
                            <div class="card-body">
                                <x-input.select label="Type" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.type" values="{{ \App\Enums\WeaponTalentOptionType::class }}" />

                                @if ($option['type'] === \App\Enums\WeaponTalentOptionType::CUSTOM)
                                    <x-input.textarea label="Description" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.description" />

                                    <div class="flex flex-row justify-between items-center max-w-lg mt-4 mb-2">
                                        <h4 class="text-lg">{{ __("Values") }}</h4>
                                    </div>

                                    @foreach ($option['values'] ?? [] as $valueIndex => $value)
                                        <div class="card bg-base-300 shadow-xl my-4 min-w-md" wire:key="value-{{ $value['id'] }}">
                                            <div class="card-body">
                                                <x-input.textfield label="Name" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.values.{{ $valueIndex }}.name" />
                                                <x-input.select label="Type" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.values.{{ $valueIndex }}.type" values="{{ \App\Enums\ValueType::class }}" />

                                                @if ($value['type']->hasStatField())
                                                    <x-input.select label="Stat" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.values.{{ $valueIndex }}.stat" values="{{ \App\Enums\Stat::class }}" />
                                                @endif

                                                <x-input.textfield label="Value" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.values.{{ $valueIndex }}.value" />

                                                <div class="card-actions justify-end mt-4">
                                                    <button class="btn btn-sm btn-ghost" type="button" wire:click="deleteOptionValue({{ $index }}, {{ $optionIndex }}, {{ $valueIndex }})">
                                                        <x-heroicon-o-trash class="w-6 h-6" />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="flex flex-row w-full justify-center mt-4">
                                        <button class="btn btn-sm btn-primary" type="button" wire:click="addOptionValue({{ $index }}, {{ $optionIndex }})">
                                            <x-heroicon-o-plus class="w-6 h-6"/>
                                            {{ __("Add Value") }}
                                        </button>
                                    </div>
                                @elseif ($option['type'] === \App\Enums\WeaponTalentOptionType::STAT)
                                    <x-input.select label="Stat" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.stat" values="{{ \App\Enums\Stat::class }}" />
                                    <x-input.textfield label="Value" fieldName="form.talents.{{ $index }}.options.{{ $optionIndex }}.value" />
                                @endif

                                <div class="card-actions justify-end mt-4">
                                    <button class="btn btn-sm btn-ghost" type="button" wire:click="deleteOption({{ $index }}, {{ $optionIndex }})">
                                        <x-heroicon-o-trash class="w-6 h-6" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (count($talent['options'] ?? []) < 5)
                    <div class="flex flex-row w-full justify-center mt-4">
                        <button class="btn btn-sm btn-primary" type="button" wire:click="addOption({{ $index }})">
                            <x-heroicon-o-plus class="w-6 h-6"/>
                            {{ __("Add Option") }}
                        </button>
                    </div>
                @endif
            </div>
        @endforeach

        @if (count($values) < 5)
            <div class="flex flex-row w-full justify-center mt-4">
                <button class="btn btn-sm btn-primary" type="button" wire:click="addTalent()">
                    <x-heroicon-o-plus class="w-6 h-6"/>
                    {{ __("Add Talent") }}
                </button>
            </div>
        @endif
    </div>
</div>
