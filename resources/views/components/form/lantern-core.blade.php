<form wire:submit="save">

    <div class="max-w-lg">
    <x-input.textfield label="Name" fieldName="form.name" />
    <x-input.image-upload label="Icon" fieldName="form.icon" :previewUrl="$form->icon instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $form->icon->temporaryUrl() : ($form->icon ? asset($form->icon) : null)" />
    <x-input.image-upload label="Active Icon" fieldName="form.active_icon" :previewUrl="$form->active_icon instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $form->active_icon->temporaryUrl() : ($form->active_icon ? asset($form->active_icon) : null)" />

    <x-input.textarea label="Active" fieldName="form.active" />
    <x-input.values-repeater :values="$form->active_values" fieldName="form.active_values" addFunc="addActiveValue" deleteFunc="deleteActive" />

    <x-input.textarea label="Passive" fieldName="form.passive" />
    <x-input.values-repeater :values="$form->passive_values" fieldName="form.passive_values" addFunc="addPassiveValue" deleteFunc="deletePassive" />

    <x-input.patch-select fieldName="form.patch" :values="$patches" />

    <x-input.submit />
    </div>
</form>
