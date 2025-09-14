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
    public $status = 'active';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|min:8',
        'status' => 'required|in:active,inactive',
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
            $this->status = $this->editingUser->status ?? 'active';
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
        $this->status = 'active';
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
            'status' => $this->status,
            'role' => 'staff',
        ];

        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        if ($this->editingUser) {
            $this->editingUser->update($userData);
            session()->flash('message', 'Staff updated successfully!');
        } else {
            User::create($userData);
            session()->flash('message', 'Staff added successfully!');
        }

        $this->loadUsers();
        $this->closeModal();
    }

    public function delete($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->delete();
            session()->flash('message', 'Staff deleted successfully!');
            $this->loadUsers();
        }
    }


    public function render()
    {
        return view('livewire.staffs');
    }
}
