@props(['label', 'fieldName'])

<label class="form-control w-full max-w-lg my-2">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <textarea class="textarea textarea-bordered h-24 @error($fieldName) textarea-error @enderror" wire:model="{{ $fieldName }}"></textarea>

    @error($fieldName)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>
