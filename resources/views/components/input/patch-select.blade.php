@props(['label' => 'Patch', 'fieldName', 'values'])

<label class="form-control w-full max-w-lg my-2">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <select class="select select-bordered w-full max-w-lg" wire:model.change="{{ $fieldName }}">
        @foreach ($values as $patch)
            <option value="{{ $patch->id }}">
                {{ $patch->name }}

                @if ($patch->confidential)
                    [{{ __("CONFIDENTIAL") }}]
                @endif

                @if ($patch->live)
                    [{{ __("LIVE") }}]
                @endif
            </option>
        @endforeach
    </select>
</label>
