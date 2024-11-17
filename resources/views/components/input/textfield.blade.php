@props(['label', 'fieldName', 'type' => 'text', 'hasLiveUpdates' => false])

<label class="form-control w-full max-w-lg my-2">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    @if ($hasLiveUpdates)
        <input type="{{ $type }}" class="input input-bordered w-full max-w-lg @error($fieldName) input-error @enderror" wire:model.change="{{ $fieldName }}" />
    @else
        <input type="{{ $type }}" class="input input-bordered w-full max-w-lg @error($fieldName) input-error @enderror" wire:model="{{ $fieldName }}" />
    @endif

    @error($fieldName)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>
