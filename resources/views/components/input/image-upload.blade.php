@props(['label', 'fieldName', 'previewUrl'])

<label class="form-control w-full max-w-xs">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <input type="file" accept="image/*" class="file-input file-input-bordered w-full max-w-xs @error($fieldName) file-input-error @enderror" wire:model="{{ $fieldName }}" />

    @error($fieldName)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror

    @if ($previewUrl ?? false)
        <div class="mt-4 flex flex-row justify-center">
            <div class="card bg-base-300 h-32 w-32 p-4">
                <img class="w-32 h-32" src="{{ $previewUrl }}" />
            </div>
        </div>
    @endif
</label>
