<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function rules()
    {
        return [
            'data.name' => 'required',
            'data.email' => 'required|email',
            'data.number' => 'numeric',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function showData()
    {
        dd($this->data);
    }

    public function storeData()
    {
        $this->validate();
        //store data into DB
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.test-component');
    }
}
