@props(['label', 'type', 'values'])

<div class="max-w-lg">
    <h2 class="text-xl mt-8 mb-2">
        {{ __($label) }}
    </h2>

    <div class="pl-4">
        <x-input.textfield label="Name" fieldName="form.{{ $type }}Name" />
        <x-input.textarea label="Description" fieldName="form.{{ $type }}Description" />

        <div class="text-lg my-4">
            {{ __("Values") }}
        </div>

        @foreach ($values as $index => $value)
            <div class="card bg-base-200 shadow-xl my-4 max-w-lg" wire:key="value-{{ $value['id'] }}">
                <div class="card-body">
                    <x-input.textfield label="Name" fieldName="form.{{ $type }}Values.{{ $index }}.name" />
                    <x-input.select label="Type" fieldName="form.{{ $type }}Values.{{ $index }}.type" values="{{ \App\Enums\ValueType::class }}" />

                    @if ($values[$index]['type']->hasStatField())
                        <x-input.select label="Stat" fieldName="form.{{ $type }}Values.{{ $index }}.stat" values="{{ \App\Enums\Stat::class }}" />
                    @endif

                    <x-input.textfield label="Value" fieldName="form.{{ $type }}Values.{{ $index }}.value" />

                    <div class="card-actions justify-end mt-4">
                        <button class="btn btn-sm btn-ghost" type="button" wire:click="delete{{ ucfirst($type) }}({{ $index }})">
                            <x-heroicon-o-trash class="w-6 h-6" />
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex flex-row w-full justify-center mt-4">
            <button class="btn btn-sm btn-primary" type="button" wire:click="add{{ ucfirst($type) }}Value()">
                <x-heroicon-o-plus class="w-6 h-6"/>
                {{ __("Add Value") }}
            </button>
        </div>
    </div>
</div>
