<?php

namespace App\Livewire\Forms\Admin\Items;

use App\Models\LanternCore;
use App\Rules\ContainsValuesRule;
use App\Utils\UploadUtil;
use App\Utils\ValuesUtil;
use Atomicptr\Functional\Lst;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class LanternCoreForm extends Form
{
    private const UPLOAD_PATH = 'uploads/icons/lantern-cores';

    public ?LanternCore $lanternCore = null;

    #[Validate('required')]
    public string $name = '';

    public TemporaryUploadedFile|string|null $icon = null;

    public TemporaryUploadedFile|string|null $activeIcon = null;

    public ?string $active = null;

    public ?string $activeTitle = null;

    public array $activeValues = [];

    public ?int $activeCooldown = null;

    public ?string $passive = null;

    public array $passiveValues = [];

    public ?string $passiveTitle = null;

    public ?int $patch = null;

    public function setLanternCore(LanternCore $lanternCore): void
    {
        $this->lanternCore = $lanternCore;

        $this->name = $lanternCore->name;
        $this->icon = $lanternCore->icon;
        $this->activeIcon = $lanternCore->activeIcon;
        $this->active = $lanternCore->active;
        $this->activeTitle = $lanternCore->activeTitle;
        $this->activeValues = ValuesUtil::prepare($lanternCore->activeValues);
        $this->activeCooldown = $lanternCore->activeCooldown;
        $this->passive = $lanternCore->passive;
        $this->passiveValues = ValuesUtil::prepare($lanternCore->passiveValues);
        $this->passiveTitle = $lanternCore->passiveTitle;
        $this->patch = $lanternCore->patch;
    }

    public function rules()
    {
        return [
            'active' => new ContainsValuesRule($this->activeValues),
            'passive' => new ContainsValuesRule($this->passiveValues),
        ];
    }

    private function grabFormData(): array
    {
        if ($this->icon instanceof TemporaryUploadedFile) {
            $ext = '.'.Lst::last(explode('.', $this->icon->getFilename()));
            $this->icon = UploadUtil::upload($this->icon, static::UPLOAD_PATH, Str::slug($this->name).$ext)->orElse(null);
        }

        if ($this->activeIcon instanceof TemporaryUploadedFile) {
            $ext = '.'.Lst::last(explode('.', $this->activeIcon->getFilename()));
            $this->activeIcon = UploadUtil::upload($this->activeIcon, static::UPLOAD_PATH, Str::slug($this->name).'-active'.$ext)->orElse(null);
        }

        $this->activeValues = ValuesUtil::clean($this->activeValues);
        $this->passiveValues = ValuesUtil::clean($this->passiveValues);

        return $this->all();
    }

    public function store()
    {
        $this->validate();
        LanternCore::create($this->grabFormData());
    }

    public function update()
    {
        $this->validate();
        $this->lanternCore->update($this->grabFormData());
    }

    public function addActiveValue()
    {
        $this->activeValues = ValuesUtil::add($this->activeValues);
    }

    public function deleteActive(int $index)
    {
        $this->activeValues = ValuesUtil::remove($this->activeValues, $index);
    }

    public function addPassiveValue()
    {
        $this->passiveValues = ValuesUtil::add($this->passiveValues);
    }

    public function deletePassive(int $index)
    {
        $this->passiveValues = ValuesUtil::remove($this->passiveValues, $index);
    }
}
