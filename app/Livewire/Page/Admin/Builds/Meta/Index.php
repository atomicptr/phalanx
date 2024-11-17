<?php

namespace App\Livewire\Page\Admin\Builds\Meta;

use App\Enums\BuildCategory;
use App\Enums\Permissions;
use App\Models\Build;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $builds;

    public function mount()
    {
        $this->builds = Build::where('buildCategory', '=', BuildCategory::META_BUILDS->value)->get()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.builds.meta.index');
    }

    public function delete(Build $build)
    {
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $build->delete();
        $this->redirectRoute('admin.builds.meta'); // better way to handle this?
    }
}
