<?php

namespace App\Livewire\Forms;

use App\Enums\BuildCategory;
use App\Models\Build;
use Atomicptr\Functional\Lst;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BuildForm extends Form
{
    public ?Build $build;

    public ?string $name;

    #[Validate('required')]
    public string $buildId;

    public ?string $description;

    public ?string $youtube;

    public ?int $patch = null;

    public function setBuild(Build $build)
    {
        assert($build->buildCategory === BuildCategory::META_BUILDS);

        $this->build = $build;

        $this->name = $build->name;
        $this->buildId = $build->buildId;
        $this->description = $build->description;
        $this->youtube = $build->youtube;
        $this->patch = $build->patch;
    }

    private function grabData(): array
    {
        $this->validate();
        $data = $this->all();

        $data['buildId'] = Lst::last(explode('/', $data['buildId']));

        return [
            ...$data,
            'buildCategory' => BuildCategory::META_BUILDS, // TODO: make this configurable somehow somewhere
        ];
    }

    public function store(): void
    {
        Build::create($this->grabData());
    }

    public function update(): void
    {
        $this->build->update($this->grabData());
    }
}
