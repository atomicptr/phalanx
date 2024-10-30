<?php

namespace App\Livewire\Page\Admin\User;

use App\Enums\Permissions;
use App\Models\User;
use App\Service\PermissionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $users = [];

    public function mount()
    {
        $this->users = User::all()->all();
    }

    public function render()
    {
        return view('livewire.page.admin.user.index');
    }

    public function delete(User $user)
    {
        PermissionService::can(Auth::user(), Permissions::CAN_DELETE_ENTRIES);

        $user->delete();
        $this->redirectRoute('admin.user'); // better way to handle this?
    }
}
