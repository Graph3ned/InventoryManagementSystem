<?php

namespace App\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public function render()
    {
        return view('livewire.welcome')->layout('layouts.welcome');
    }

    public function redirectToLogin($role)
    {
        session(['loginRole' => $role]);
        return redirect()->route('login');
    }
}