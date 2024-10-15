@props(['label' => 'Perks', 'fieldName', 'except' => []])

<label class="form-control w-full max-w-lg my-2">
    <div class="label">
        <span class="label-text">{{ __($label) }}</span>
    </div>

    <select class="select select-bordered w-full max-w-lg" wire:model.change="{{ $fieldName }}">
        <option></option>
        @foreach (\App\Models\Perk::whereNotIn('id', $except)->get() as $perk)
            <option value="{{ $perk->id }}">{{ __($perk->name) }}</option>
        @endforeach
    </select>
</label>
