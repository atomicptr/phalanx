@props(['label', 'fieldName', 'live' => false])

<div class="form-control w-full max-w-lg my-2">
    <label class="label cursor-pointer">
        <span class="label-text">{{ __($label) }}</span>
        <input type="checkbox" class="toggle toggle-primary" @if ($live) wire:model.change="{{ $fieldName }}" @else wire:model="{{ $fieldName }}" @endif />
    </label>
</div>
