<?php

namespace App\Livewire\Page\Admin\User;

use App\Models\User;
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
        $user->delete();
        $this->redirectRoute('admin.user'); // better way to handle this?
    }
}
