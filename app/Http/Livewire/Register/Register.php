<?php

namespace App\Http\Livewire\Register;

use Livewire\Component;

class Register extends Component
{
    public function render()
    {
        return view('livewire.register.register')->layout('layouts.guest');;
    }
}
