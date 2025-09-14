<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Welcome extends Component
{
    public function redirectToLogin($role)
    {
        // Set the role in session
        Session::put('loginRole', $role);
        
        // Redirect to login page
        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}