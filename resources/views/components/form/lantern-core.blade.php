<form wire:submit="save">

    <div class="max-w-lg">
    <x-input.textfield label="Name" fieldName="form.name" />
    <x-input.image-upload label="Icon" fieldName="form.icon" :previewUrl="$form->icon instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $form->icon->temporaryUrl() : ($form->icon ? asset($form->icon) : null)" />
    <x-input.image-upload label="Active Icon" fieldName="form.activeIcon" :previewUrl="$form->activeIcon instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $form->activeIcon->temporaryUrl() : ($form->activeIcon ? asset($form->activeIcon) : null)" />

    <x-input.textarea label="Active" fieldName="form.active" />
    <x-input.values-repeater :values="$form->activeValues" fieldName="form.activeValues" addFunc="addActiveValue" deleteFunc="deleteActive" />

    <x-input.textarea label="Passive" fieldName="form.passive" />
    <x-input.values-repeater :values="$form->passiveValues" fieldName="form.passiveValues" addFunc="addPassiveValue" deleteFunc="deletePassive" />

    <x-input.patch-select fieldName="form.patch" :values="$patches" />

    <x-input.submit />
    </div>
</form>
