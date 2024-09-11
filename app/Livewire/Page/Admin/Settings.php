<?php

namespace App\Livewire\Page\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Settings extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required_with:passwordRepeat|min:12')]
    public string $password = '';

    #[Validate('required_with:password|same:password')]
    public string $passwordRepeat = '';

    public function mount()
    {
        $this->email = Auth::user()->email;
    }

    public function render()
    {
        return view('livewire.page.admin.settings');
    }

    public function save()
    {
        $this->validate();

        // TODO: allow email changing
        $user = Auth::user();
        assert($user instanceof User);

        $shouldSave = false;

        if (! empty($this->password)) {
            $user->update(['password' => Hash::make($this->password)]);
            $shouldSave = true;
        }

        if ($shouldSave) {
            $user->save();
        }

        session()->flash('message', __('Successfully updated'));
        session()->flash('messageType', 'success');
        redirect(url()->previous());
    }
}
