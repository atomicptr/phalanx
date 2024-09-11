@props(['label', 'type', 'values'])

<div class="max-w-lg">
    <h2 class="text-xl mt-8 mb-2">
        {{ __($label) }}
    </h2>

    <div class="pl-4">
        <x-input.textfield label="Name" fieldName="form.{{ $type }}Name" />
        <x-input.textarea label="Description" fieldName="form.{{ $type }}Description" />

        <div class="text-lg my-4">
            {{ __("Values") }}
        </div>

        <x-input.values-repeater :values="$values" fieldName="form.{{ $type }}Values" addFunc="add{{ ucfirst($type) }}Value" deleteFunc="delete{{ ucfirst($type) }}" />
    </div>
</div>
