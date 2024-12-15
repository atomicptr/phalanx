<?php

namespace App\Livewire\Page\Admin\SourceStrings;

use App\Enums\Permissions;
use App\Models\SourceString;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $sourceStrings = [];

    public function mount()
    {
        $this->sourceStrings = SourceString::where('manual', true)->orderBy('ident', 'ASC')->get()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.source-strings.index');
    }

    public function delete(SourceString $sourceString)
    {
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $sourceString->delete();
        $this->redirectRoute('admin.source-string'); // better way to handle this?
    }
}
