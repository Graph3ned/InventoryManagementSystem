<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class Staffs extends Component
{
    public $users;
    public $showModal = false;
    public $editingUser = null;
    
    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|min:8',
    ];

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::where('role', 'staff')->get();
    }

    public function openModal($userId = null)
    {
        if ($userId) {
            $this->editingUser = User::find($userId);
            $this->name = $this->editingUser->name;
            $this->email = $this->editingUser->email;
            $this->password = '';
        } else {
            $this->resetForm();
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->editingUser = null;
    }

    public function save()
    {
        if ($this->editingUser) {
            $this->rules['email'] = 'required|string|email|max:255|unique:users,email,' . $this->editingUser->id;
            if (empty($this->password)) {
                unset($this->rules['password']);
            }
        }

        $this->validate();

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => 'staff',
        ];

        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        if ($this->editingUser) {
            $this->editingUser->update($userData);
            session()->flash('message', 'Staff updated successfully!');
        } else {
            $userData['status'] = 'active'; // New staff are always active by default
            User::create($userData);
            session()->flash('message', 'Staff added successfully!');
        }

        $this->loadUsers();
        $this->closeModal();
    }

    public function deactivateUser($userId)
    {
        $user = User::find($userId);
        if ($user && $user->status === 'active') {
            $user->update(['status' => 'inactive']);
            session()->flash('message', 'Staff member deactivated successfully! They will no longer be able to log in.');
            $this->loadUsers();
        }
    }

    public function activateUser($userId)
    {
        $user = User::find($userId);
        if ($user && $user->status === 'inactive') {
            $user->update(['status' => 'active']);
            session()->flash('message', 'Staff member activated successfully! They can now log in again.');
            $this->loadUsers();
        }
    }


    public function render()
    {
        return view('livewire.staffs');
    }
}
