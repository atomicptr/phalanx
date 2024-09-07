@props(['label', 'fieldName'])

<div class="form-control w-full max-w-xs my-2">
    <label class="label cursor-pointer">
        <span class="label-text">{{ __($label) }}</span>
        <input type="checkbox" class="toggle toggle-primary" wire:model="{{ $fieldName }}" />
    </label>
</div>
