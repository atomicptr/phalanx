<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Enums\ArmourType;
use App\Enums\Element;
use App\Models\Armour;
use Atomicptr\Functional\Lst;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class ArmourForm extends Form
{
    public ?Armour $armour = null;

    #[Validate('required')]
    public string $name = '';

    public ArmourType $type = ArmourType::HEAD;

    public ?string $description = null;

    public TemporaryUploadedFile|string|null $icon = null;

    public Element $element = Element::BLAZE;

    public array $stats = [];

    public ?int $patch = null;

    public function setArmour(Armour $armour)
    {
        $this->armour = $armour;

        $this->name = $armour->name;
        $this->type = $armour->type;
        $this->description = $armour->description;
        $this->icon = $armour->icon;
        $this->element = $armour->element;
        $this->stats = $armour->stats ?? [];
        $this->patch = $armour->patch;
    }

    // TODO: validate stats

    public function store()
    {
        $this->validate();
        Armour::create($this->all());
    }

    public function update()
    {
        $this->validate();
        $this->armour->update($this->all());
    }

    public function addStatSet(): void
    {
        $this->stats = Lst::sort(fn (array $a, array $b) => $a['min_level'] <=> $b['min_level'], $this->stats);
        $highestLevel = Lst::length($this->stats) > 0 ? Lst::last($this->stats)['min_level'] : 0;
        $this->stats = Lst::cons($this->stats, ['id' => (string) Str::uuid(), 'min_level' => (Lst::isEmpty($this->stats) ? 0 : $highestLevel + 10), 'perks' => []]);
    }

    public function removeStatSet(int $index): void
    {
        $this->stats = Lst::filter(fn (array $val, int $idx) => $idx !== $index, $this->stats);
    }

    public function addPerk(int $index): void
    {
        $this->stats[$index]['perks'] = Lst::cons($this->stats[$index]['perks'], ['id' => (string) Str::uuid(), 'perk' => null, 'amount' => 0]);
    }

    public function removePerk(int $index, int $perkIndex): void
    {
        $this->stats[$index]['perks'] = Lst::filter(fn (array $val, int $idx) => $idx !== $perkIndex, $this->stats[$index]['perks']);
    }

    public function selectedPerks(int $index): array
    {
        return Lst::map(fn (array $perk) => intval($perk['perk']), Lst::filter(fn (array $perk) => $perk !== null, $this->stats[$index]['perks']));
    }
}
