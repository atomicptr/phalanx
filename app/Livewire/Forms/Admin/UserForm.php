<?php

namespace App\Livewire\Forms\Admin;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;

    #[Validate('required')]
    public string $name = '';

    #[Validate('required_with:passwordRepeat|min:12')]
    public string $password = '';

    #[Validate('required_with:password|same:password')]
    public string $passwordRepeat = '';

    #[Validate('required|email')]
    public string $email = '';

    public bool $is_admin = false;

    public bool $can_publish = false;

    public bool $can_access_confidential = false;

    public bool $can_access_patches = false;

    public bool $can_edit_builds = false;

    public bool $can_edit_data = false;

    public function setUser(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->passwordRepeat = '';
        $this->is_admin = $user->is_admin;
        $this->can_publish = $user->can_publish;
        $this->can_access_confidential = $user->can_access_confidential;
        $this->can_access_patches = $user->can_access_patches;
        $this->can_edit_builds = $user->can_edit_builds;
        $this->can_edit_data = $user->can_edit_data;
    }

    public function store(): void
    {
        $this->validate();

        $data = $this->except(['password', 'passwordRepeat']);

        if (! empty($this->password)) {
            $data = $this->all();
        }

        User::create($data);
    }

    public function update(): void
    {
        $this->validate();

        $data = $this->except(['password', 'passwordRepeat']);

        if (! empty($this->password)) {
            $data = $this->all();
        }

        $this->user->update($data);
    }
}
