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

    public TemporaryUploadedFile|string|null $active_icon = null;

    public ?string $active = null;

    public array $active_values = [];

    public ?string $passive = null;

    public array $passive_values = [];

    public ?int $patch = null;

    public function setLanternCore(LanternCore $lanternCore): void
    {
        $this->lanternCore = $lanternCore;

        $this->name = $lanternCore->name;
        $this->icon = $lanternCore->icon;
        $this->active_icon = $lanternCore->active_icon;
        $this->active = $lanternCore->active;
        $this->active_values = ValuesUtil::prepare($lanternCore->active_values);
        $this->passive = $lanternCore->passive;
        $this->passive_values = ValuesUtil::prepare($lanternCore->passive_values);
        $this->patch = $lanternCore->patch;
    }

    public function rules()
    {
        return [
            'active' => new ContainsValuesRule($this->active_values),
            'passive' => new ContainsValuesRule($this->passive_values),
        ];
    }

    private function grabFormData(): array
    {
        if ($this->icon instanceof TemporaryUploadedFile) {
            $ext = '.'.Lst::last(explode('.', $this->icon->getFilename()));
            $this->icon = UploadUtil::upload($this->icon, static::UPLOAD_PATH, Str::slug($this->name).$ext)->orElse(null);
        }

        if ($this->icon instanceof TemporaryUploadedFile) {
            $ext = '.'.Lst::last(explode('.', $this->active_icon->getFilename()));
            $this->active_icon = UploadUtil::upload($this->active_icon, static::UPLOAD_PATH, Str::slug($this->name).'-active'.$ext)->orElse(null);
        }

        $this->active_values = ValuesUtil::clean($this->active_values);
        $this->passive_values = ValuesUtil::clean($this->passive_values);

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
        $this->active_values = ValuesUtil::add($this->active_values);
    }

    public function deleteActive(int $index)
    {
        $this->active_values = ValuesUtil::remove($this->active_values, $index);
    }

    public function addPassiveValue()
    {
        $this->passive_values = ValuesUtil::add($this->passive_values);
    }

    public function deletePassive(int $index)
    {
        $this->passive_values = ValuesUtil::remove($this->passive_values, $index);
    }
}
