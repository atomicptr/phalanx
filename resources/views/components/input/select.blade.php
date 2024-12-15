@props(['label', 'fieldName', 'values', 'empty' => false])

<label class="form-control w-full max-w-lg my-2">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <div class="flex flex-row gap-2 items-center">
        <select class="select select-bordered w-full max-w-lg @error($fieldName) select-error @enderror" wire:model.change="{{ $fieldName }}">
            @if ($empty)
                <option>{{ $empty }}</option>
            @endif

            @if (is_array($values))
                @foreach ($values as $key => $value)
                    <option value="{{ $key }}">
                        {{ $value }}
                    </option>
                @endforeach
            @elseif (enum_exists($values))
                @foreach ($values::cases() as $case)
                    <option value="{{ $case->value }}">
                        @if ($case instanceof \App\Contracts\DisplayAsString)
                            {{ __($case->displayString()) }}
                        @else
                            {{ $case->value }}
                        @endif
                    </option>
                @endforeach
            @endif
        </select>

        @if (!is_array($values) && enum_exists($values) && is_subclass_of($values, \App\Contracts\HasIcon::class))
            <img class="w-8 h-8" src="{{ $this->form->type->icon() }}" />
        @endif
    </div>

    @error($fieldName)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>

