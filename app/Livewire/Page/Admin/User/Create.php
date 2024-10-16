<?php

namespace App\Livewire\Page\Admin\User;

use App\Livewire\Forms\Admin\UserForm;
use Livewire\Component;

class Create extends Component
{
    public UserForm $form;

    public function render()
    {
        return view('livewire.page.admin.user.create');
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('admin.user');
    }
}
