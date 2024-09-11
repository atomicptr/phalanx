<form wire:submit="save">

    <x-input.textfield label="Name" fieldName="form.name" />
    <x-input.textarea label="Effect" fieldName="form.effect" />

    <div class="max-w-lg">
        <div class="text-lg my-4">
            {{ __("Values") }}
        </div>

        <x-input.values-repeater :values="$form->values" fieldName="form.values" />
    </div>

    <x-input.textfield label="Threshold" fieldName="form.threshold" />

    <x-input.select label="Patch" fieldName="form.patch" :values="$patches" />

    <x-input.submit />
</form>
