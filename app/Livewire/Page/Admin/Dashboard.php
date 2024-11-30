<?php

namespace App\Livewire\Page\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public ?int $open = null;

    public function logToggleAudit(int $id)
    {
        $this->open = $this->open === $id ? null : $id;
    }

    public function render()
    {
        return view('livewire.page.admin.dashboard');
    }
}
