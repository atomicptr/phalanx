<?php

namespace App\Livewire\Page\Admin\User;

use App\Livewire\Forms\Admin\UserForm;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    #[Url]
    public User $user;

    public UserForm $form;

    public function mount()
    {
        $this->form->setUser($this->user);
    }

    public function render()
    {
        return view('livewire.page.admin.user.edit');
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('admin.user');
    }
}
