<form wire:submit="save">

    <x-input.textfield label="Name" fieldName="form.name" />
    <x-input.select label="Type" fieldName="form.type" values="{{ \App\Enums\WeaponType::class }}" />
    <x-input.image-upload label="Icon" fieldName="form.icon" :previewUrl="$form->icon instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $form->icon->temporaryUrl() : ($form->icon ? asset($form->icon) : null)" />
    <x-input.select label="Element" fieldName="form.element" values="{{ \App\Enums\Element::class }}" />

    <x-form.weapon-ability label="Special" type="special" :values="$form->specialValues" />
    <x-form.weapon-ability label="Passive" type="passive" :values="$form->passiveValues" />
    <x-form.weapon-ability label="Active" type="active" :values="$form->activeValues" />

    <x-form.weapon-talents label="Talents" :values="$form->talents" />

    <x-input.patch-select fieldName="form.patch" :values="$patches" />

    <x-input.submit />
</form>
