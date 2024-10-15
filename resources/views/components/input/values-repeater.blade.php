@props(['values', 'fieldName', 'addFunc' => 'addValue', 'addFuncParamsPrefix' => '', 'deleteFunc' => 'deleteValue', 'deleteFuncParamsPrefix' => ''])

<div>
    @foreach ($values as $index => $value)
        <div class="card bg-base-200 shadow-xl my-4 max-w-lg" wire:key="{{ $fieldName }}-{{ $value['id'] }}">
            <div class="card-body">
                <x-input.textfield label="Name" fieldName="{{ $fieldName }}.{{ $index }}.name" />
                <x-input.select label="Type" fieldName="{{ $fieldName }}.{{ $index }}.type" values="{{ \App\Enums\ValueType::class }}" />

                @if ($values[$index]['type']->hasStatField())
                    <x-input.select label="Stat" fieldName="{{ $fieldName }}.{{ $index }}.stat" values="{{ \App\Enums\Stat::class }}" />
                @endif

                <x-input.textfield label="Value" fieldName="{{ $fieldName }}.{{ $index }}.value" />

                <div class="card-actions justify-end mt-4">
                    <button class="btn btn-sm btn-ghost" type="button" wire:click="{{ $deleteFunc }}({{ $deleteFuncParamsPrefix }} {{ $index }})">
                        <x-heroicon-o-trash class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <div class="flex flex-row w-full justify-center mt-4">
        <button class="btn btn-sm btn-primary" type="button" wire:click="{{ $addFunc }}({{ $addFuncParamsPrefix }})">
            <x-heroicon-o-plus class="w-6 h-6"/>
            {{ __("Add Value") }}
        </button>
    </div>
</div>
