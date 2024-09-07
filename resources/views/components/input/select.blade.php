@props(['label', 'fieldName', 'values'])

<label class="form-control w-full max-w-xs">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <select class="select select-bordered w-full max-w-xs @error($fieldName) select-error @enderror" wire:model="{{ $fieldName }}">
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

    @error($fieldName)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>

