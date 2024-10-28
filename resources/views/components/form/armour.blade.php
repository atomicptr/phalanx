<form wire:submit="save">

    <x-input.textfield label="Name" fieldName="form.name" />
    <x-input.select label="Type" fieldName="form.type" values="{{ \App\Enums\ArmourType::class }}" />
    <x-input.image-upload label="Icon" fieldName="form.icon" :previewUrl="$form->icon instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $form->icon->temporaryUrl() : ($form->icon ? asset($form->icon) : null)" />
    <x-input.select label="Element" fieldName="form.element" values="{{ \App\Enums\Element::class }}" />

    <x-form.armour-stats label="Stats" :values="$form->stats" />

    <x-input.patch-select fieldName="form.patch" :values="$patches" />

    <x-input.submit />
</form>
