<form wire:submit="save">

    <x-input.textfield label="Name" fieldName="form.name" />

    <x-input.textfield label="Build ID" fieldName="form.buildId" hasLiveUpdates />

    @if ($this->form->buildId ?? null)
        @php($build = \DauntlessBuilder\Build::fromId($this->form->buildId ?? ""))

        @if ($build->hasError())
            <div class="alert alert-error max-w-lg">
                {{ __("Could not parse build") }}
            </div>
        @else
            <x-mini-build :build="$build->value()" />
        @endif
    @endif

    <x-input.textarea label="Description" fieldName="form.description" />

    <x-input.textfield label="Youtube ID" fieldName="form.youtube" />

    <x-input.patch-select fieldName="form.patch" :values="$patches" />

    <x-input.submit />
</form>
