@props(['label', 'fieldName'])

<label class="form-control w-full max-w-lg my-2">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <input type="text" class="input input-bordered w-full max-w-lg @error($fieldName) input-error @enderror" wire:model="{{ $fieldName }}" />

    @error($fieldName)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>
