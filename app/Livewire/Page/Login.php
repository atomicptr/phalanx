<?php

namespace App\Livewire\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|email')]
    public string $email;

    #[Validate('required')]
    public string $password;

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            return $this->redirectRoute('admin.index', navigate: true);
        }

        session()->flash('error', 'Invalid credentials!');
    }

    #[Layout('components.layouts.base')]
    public function render()
    {
        return view('livewire.page.login');
    }
}
