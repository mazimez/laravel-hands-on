<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Livewire\TestComponent;

class TestController extends Controller
{
    public function testLivewire()
    {
        return view('layout.livewire', [
            'livewire_component' => TestComponent::getName(),
            'livewire_data' => [
                'data' => [
                    'name' => 'test',
                    'email' => 'test@gmail.com',
                    'number' => '332232323',
                ],
            ],
        ]);
    }
}
