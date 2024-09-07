@props(['label', 'fieldName'])

<label class="form-control w-full max-w-xs">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <input type="text" class="input input-bordered w-full max-w-xs @error($fieldName) input-error @enderror" wire:model="{{ $fieldName }}" />

    @error($fieldName)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>
