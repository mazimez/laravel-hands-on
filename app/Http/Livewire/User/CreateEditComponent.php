<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEditComponent extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function rules()
    {
        return [
            'user.name' => 'required',
            'user.email' => $this->user->id ? 'required|email' : 'required|email|unique:users,email',
            'user.phone_number' => 'numeric',
            'image' => 'file|nullable'
        ];
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function storeData()
    {
        $this->validate();

        $this->user->save();

        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.user.create-edit-component');
    }
}