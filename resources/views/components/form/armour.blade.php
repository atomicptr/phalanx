<form wire:submit="save">

    <x-input.textfield label="Name" fieldName="form.name" />
    <x-input.select label="Type" fieldName="form.type" values="{{ \App\Enums\ArmourType::class }}" />
    <x-input.image-upload label="Icon" fieldName="form.icon" :previewUrl="$form->icon instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $form->icon->temporaryUrl() : ($form->icon ? asset($form->icon) : null)" />
    <x-input.select label="Element" fieldName="form.element" values="{{ \App\Enums\Element::class }}" />

    <x-input.select label="Perk A" fieldName="form.perkA" :values="$this->perkSelectOptions()" />
    <x-input.select label="Perk B" fieldName="form.perkB" :values="$this->perkSelectOptions()" />
    <x-input.select label="Perk C" fieldName="form.perkC" :values="$this->perkSelectOptions()" />
    <x-input.select label="Perk D" fieldName="form.perkD" :values="$this->perkSelectOptions()" />

    @if ($this->form->perkA && $this->form->perkB && $this->form->perkC && $this->form->perkD)
        @foreach (\App\Enums\ArmourType::cases() as $armourType)
            <div class="card bg-base-200 max-w-lg my-4">
                <div class="card-body">
                    <div class="text-lg">
                        {{ $armourType->displayString() }}
                    </div>
            
                    <ul class="list-disc ml-8">
                        @foreach (\App\Service\PerkCalculator::calculate($armourType, $this->form->perkA, $this->form->perkB, $this->form->perkC, $this->form->perkD) as $data)
                            <li>
                                {{ __("Minimum Level:") }} {{ $data["min_level"] }}
                                <ul class="list-disc ml-8">
                                    @foreach ($data["perks"] as $perkId => $amount)
                                        <li>{{ $this->perkName($perkId) }}: {{ $amount }}x</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    @endif

    <x-form.armour-stats label="Stats" :values="$form->stats" />

    <x-input.patch-select fieldName="form.patch" :values="$patches" />

    <x-input.submit />
</form>
