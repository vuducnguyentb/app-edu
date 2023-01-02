<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.home-component')
            ->layout('layouts.app-admin');
    }
}
